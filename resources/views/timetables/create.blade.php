@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-2xl font-bold mb-6">Generate New Timetable</h2>

        <form action="{{ route('timetables.generate') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Class Level Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Class Level</label>
                <select name="class_level_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Select Class Level</option>
                    @foreach($classLevels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Term Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Term</label>
                <select name="term" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @foreach($terms as $term)
                        <option value="{{ $term }}">{{ $term }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Academic Year -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                <select name="academic_year" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @foreach($academicYears as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Generation Progress -->
            <div id="generation-progress" class="hidden">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Generation in progress... (<span id="current-generation">0</span>%)
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Generate Timetable
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Assuming you're using Laravel Echo
    Echo.channel('timetable-generation')
        .listen('TimetableGenerationProgress', (e) => {
            // Update progress bar
            const progress = (e.progress.generation / e.progress.total_generations) * 100;
            document.querySelector('#generation-progress').style.width = `${progress}%`;
            
            // Update statistics
            document.querySelector('#current-generation').textContent = e.progress.generation;
            document.querySelector('#best-fitness').textContent = e.progress.best_fitness;
            document.querySelector('#teacher-conflicts').textContent = e.progress.stats.teacher_conflicts;
            document.querySelector('#classroom-conflicts').textContent = e.progress.stats.classroom_conflicts;
            
            // Update chart if you're using one
            updateChart(e.progress);
        });

    // If you want to use a chart library like Chart.js
    const ctx = document.getElementById('fitness-chart').getContext('2d');
    const fitnessChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Best Fitness Score',
                data: []
            }]
        }
    });

    function updateChart(progress) {
        fitnessChart.data.labels.push(progress.generation);
        fitnessChart.data.datasets[0].data.push(progress.best_fitness);
        fitnessChart.update();
    }
</script>
@endpush