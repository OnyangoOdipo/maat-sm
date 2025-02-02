<?php

namespace App\Services;

use App\Models\Timetable;
use App\Models\TimetableSlot;
use App\Models\TimeSlot;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Support\Collection;

class TimetableGenerator
{
    protected $timetable;
    protected $timeslots;
    protected $subjects;
    protected $teachers;
    protected $classrooms;
    protected $constraints;
    protected $progressCallback;
    protected $currentGeneration = 0;
    protected $bestFitnessHistory = [];

    public function __construct(Timetable $timetable)
    {
        $this->timetable = $timetable;
        $this->loadData();
    }

    protected function loadData()
    {
        // Load all required data
        $this->timeslots = TimeSlot::where('class_level_id', $this->timetable->class_level_id)
            ->where('type', 'regular')
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        $this->subjects = Subject::whereHas('classLevels', function($query) {
            $query->where('class_level_id', $this->timetable->class_level_id);
        })->get();

        $this->teachers = Teacher::whereHas('subjects', function($query) {
            $query->whereIn('subject_id', $this->subjects->pluck('id'));
        })->get();

        $this->classrooms = Classroom::where('school_id', $this->timetable->school_id)
            ->where('class_level_id', $this->timetable->class_level_id)
            ->get();
    }

    public function setProgressCallback(callable $callback)
    {
        $this->progressCallback = $callback;
        return $this;
    }

    public function generate()
    {
        $population = $this->initializePopulation();
        $generations = 100;
        $populationSize = 50;

        for ($i = 0; $i < $generations; $i++) {
            $this->currentGeneration = $i + 1;
            
            // Get current best fitness before evolution
            $currentBest = $this->calculateFitness($this->getBestSolution($population));
            
            // Evolve population
            $population = $this->evolvePopulation($population);
            
            // Track progress
            $bestSolution = $this->getBestSolution($population);
            $bestFitness = $this->calculateFitness($bestSolution);
            $this->bestFitnessHistory[] = $bestFitness;
            
            // Calculate statistics
            $stats = $this->getGenerationStats($population, $bestSolution);
            
            // Report progress
            if ($this->progressCallback) {
                call_user_func($this->progressCallback, [
                    'generation' => $this->currentGeneration,
                    'total_generations' => $generations,
                    'best_fitness' => $bestFitness,
                    'improvement' => $bestFitness - $currentBest,
                    'stats' => $stats
                ]);
            }
        }

        $bestSolution = $this->getBestSolution($population);
        $this->saveSolution($bestSolution);
        return $bestSolution;
    }

    protected function initializePopulation()
    {
        $population = [];
        for ($i = 0; $i < 50; $i++) { // Population size of 50
            $population[] = $this->createRandomSolution();
        }
        return $population;
    }

    protected function createRandomSolution()
    {
        $solution = [];
        $subjectsPerDay = $this->subjects->count() / 5; // Distribute subjects across 5 days

        foreach ($this->timeslots as $timeslot) {
            // Skip if it's a break
            if ($timeslot->is_break) continue;

            // Randomly select a subject that hasn't exceeded its daily limit
            $subject = $this->getRandomSubject($solution, $timeslot->day, $subjectsPerDay);
            
            if ($subject) {
                // Find available teacher for this subject
                $teacher = $this->getAvailableTeacher($solution, $timeslot, $subject);
                
                // Find available classroom
                $classroom = $this->getAvailableClassroom($solution, $timeslot);

                if ($teacher && $classroom) {
                    $solution[] = [
                        'timeslot_id' => $timeslot->id,
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher->id,
                        'classroom_id' => $classroom->id
                    ];
                }
            }
        }

        return $solution;
    }

    protected function getRandomSubject($solution, $day, $maxPerDay)
    {
        $subjectsToday = collect($solution)
            ->filter(function($slot) use ($day) {
                return $this->timeslots->find($slot['timeslot_id'])->day === $day;
            })
            ->groupBy('subject_id')
            ->map->count();

        $availableSubjects = $this->subjects->filter(function($subject) use ($subjectsToday, $maxPerDay) {
            return !isset($subjectsToday[$subject->id]) || $subjectsToday[$subject->id] < $maxPerDay;
        });

        return $availableSubjects->isNotEmpty() ? $availableSubjects->random() : null;
    }

    protected function getAvailableTeacher($solution, $timeslot, $subject)
    {
        return $this->teachers
            ->filter(function($teacher) use ($solution, $timeslot, $subject) {
                // Check if teacher teaches this subject
                if (!$teacher->subjects->contains($subject->id)) {
                    return false;
                }

                // Check if teacher is available in this timeslot
                return !collect($solution)->contains(function($slot) use ($timeslot, $teacher) {
                    return $slot['teacher_id'] === $teacher->id &&
                           $slot['timeslot_id'] === $timeslot->id;
                });
            })
            ->random();
    }

    protected function getAvailableClassroom($solution, $timeslot)
    {
        return $this->classrooms
            ->filter(function($classroom) use ($solution, $timeslot) {
                return !collect($solution)->contains(function($slot) use ($timeslot, $classroom) {
                    return $slot['classroom_id'] === $classroom->id &&
                           $slot['timeslot_id'] === $timeslot->id;
                });
            })
            ->random();
    }

    protected function evolvePopulation($population)
    {
        $newPopulation = [];
        $populationSize = count($population);

        // Keep the best solutions (elitism)
        $sorted = collect($population)->sortByDesc(function($solution) {
            return $this->calculateFitness($solution);
        });
        $newPopulation[] = $sorted->first();
        $newPopulation[] = $sorted->slice(1, 1)->first();

        // Create new solutions through crossover and mutation
        while (count($newPopulation) < $populationSize) {
            $parent1 = $this->selectParent($population);
            $parent2 = $this->selectParent($population);
            
            $child = $this->crossover($parent1, $parent2);
            $child = $this->mutate($child);
            
            $newPopulation[] = $child;
        }

        return $newPopulation;
    }

    protected function calculateFitness($solution)
    {
        $score = 100;
        $penalties = [
            'teacher_conflicts' => 0,
            'classroom_conflicts' => 0,
            'subject_distribution' => 0,
            'teacher_load' => 0
        ];

        // Check for conflicts and calculate penalties
        foreach ($solution as $slot1) {
            foreach ($solution as $slot2) {
                if ($slot1 === $slot2) continue;

                // Teacher teaching at the same time
                if ($slot1['teacher_id'] === $slot2['teacher_id'] &&
                    $slot1['timeslot_id'] === $slot2['timeslot_id']) {
                    $penalties['teacher_conflicts']++;
                }

                // Same classroom used at the same time
                if ($slot1['classroom_id'] === $slot2['classroom_id'] &&
                    $slot1['timeslot_id'] === $slot2['timeslot_id']) {
                    $penalties['classroom_conflicts']++;
                }
            }
        }

        // Apply penalties
        $score -= ($penalties['teacher_conflicts'] * 10);
        $score -= ($penalties['classroom_conflicts'] * 10);
        $score -= ($penalties['subject_distribution'] * 5);
        $score -= ($penalties['teacher_load'] * 5);

        return max(0, $score);
    }

    protected function selectParent($population)
    {
        // Tournament selection
        $tournamentSize = 3;
        $tournament = collect($population)->random($tournamentSize);
        
        return $tournament->sortByDesc(function($solution) {
            return $this->calculateFitness($solution);
        })->first();
    }

    protected function crossover($parent1, $parent2)
    {
        // Single point crossover
        $crossoverPoint = rand(0, count($parent1) - 1);
        return array_merge(
            array_slice($parent1, 0, $crossoverPoint),
            array_slice($parent2, $crossoverPoint)
        );
    }

    protected function mutate($solution)
    {
        // Random mutation of slots
        foreach ($solution as &$slot) {
            if (rand(0, 100) < 5) { // 5% mutation rate
                $type = rand(0, 2);
                switch ($type) {
                    case 0: // Change subject
                        $slot['subject_id'] = $this->subjects->random()->id;
                        break;
                    case 1: // Change teacher
                        $slot['teacher_id'] = $this->teachers->random()->id;
                        break;
                    case 2: // Change classroom
                        $slot['classroom_id'] = $this->classrooms->random()->id;
                        break;
                }
            }
        }
        return $solution;
    }

    protected function getBestSolution($population)
    {
        return collect($population)->sortByDesc(function($solution) {
            return $this->calculateFitness($solution);
        })->first();
    }

    protected function saveSolution($solution)
    {
        foreach ($solution as $slot) {
            TimetableSlot::create([
                'timetable_id' => $this->timetable->id,
                'timeslot_id' => $slot['timeslot_id'],
                'subject_id' => $slot['subject_id'],
                'teacher_id' => $slot['teacher_id'],
                'classroom_id' => $slot['classroom_id']
            ]);
        }
    }

    protected function getGenerationStats($population, $bestSolution)
    {
        return [
            'teacher_conflicts' => $this->countTeacherConflicts($bestSolution),
            'classroom_conflicts' => $this->countClassroomConflicts($bestSolution),
            'average_fitness' => $this->calculateAverageFitness($population),
            'subject_distribution' => $this->analyzeSubjectDistribution($bestSolution),
        ];
    }

    protected function countTeacherConflicts($solution)
    {
        $conflicts = 0;
        foreach ($solution as $slot1) {
            foreach ($solution as $slot2) {
                if ($slot1 === $slot2) continue;
                if ($slot1['teacher_id'] === $slot2['teacher_id'] &&
                    $slot1['timeslot_id'] === $slot2['timeslot_id']) {
                    $conflicts++;
                }
            }
        }
        return $conflicts / 2; // Divide by 2 as each conflict is counted twice
    }

    /**
     * Count the number of classroom conflicts in a given timetable
     * 
     * @param array $timetable The timetable to check for conflicts
     * @return int Number of classroom conflicts found
     */
    public function countClassroomConflicts($timetable)
    {
        $conflicts = 0;
        $classroomUsage = [];

        foreach ($timetable as $slot) {
            $timeSlot = $slot['time_slot'];
            $classroom = $slot['classroom'];
            $day = $slot['day'];

            $key = "$day-$timeSlot-$classroom";

            if (isset($classroomUsage[$key])) {
                $conflicts++;
            }

            $classroomUsage[$key] = true;
        }

        return $conflicts;
    }

    /**
     * Check if a specific classroom is available at a given time slot
     * 
     * @param string $classroom The classroom to check
     * @param string $timeSlot The time slot to check
     * @param string $day The day to check
     * @param array $currentTimetable The current timetable
     * @return bool Whether the classroom is available
     */
    protected function isClassroomAvailable($classroom, $timeSlot, $day, $currentTimetable)
    {
        foreach ($currentTimetable as $slot) {
            if ($slot['day'] === $day && 
                $slot['time_slot'] === $timeSlot && 
                $slot['classroom'] === $classroom) {
                return false;
            }
        }
        return true;
    }

    /**
     * Calculate the average fitness of the population
     * 
     * @param array $population The population to analyze
     * @return float The average fitness score
     */
    protected function calculateAverageFitness($population)
    {
        $totalFitness = 0;
        foreach ($population as $solution) {
            $totalFitness += $this->calculateFitness($solution);
        }
        return $totalFitness / count($population);
    }

    /**
     * Analyze the distribution of subjects in the timetable
     * 
     * @param array $solution The timetable solution to analyze
     * @return array Statistics about subject distribution
     */
    protected function analyzeSubjectDistribution($solution)
    {
        $distribution = [];
        
        // Count occurrences of each subject
        foreach ($solution as $slot) {
            $subjectId = $slot['subject_id'];
            if (!isset($distribution[$subjectId])) {
                $distribution[$subjectId] = 0;
            }
            $distribution[$subjectId]++;
        }

        // Handle empty distribution case
        if (empty($distribution)) {
            return [
                'min_lessons' => 0,
                'max_lessons' => 0,
                'average_lessons' => 0,
                'distribution' => []
            ];
        }

        // Calculate statistics
        $stats = [
            'min_lessons' => min($distribution),
            'max_lessons' => max($distribution),
            'average_lessons' => array_sum($distribution) / count($distribution),
            'distribution' => $distribution
        ];

        return $stats;
    }
}