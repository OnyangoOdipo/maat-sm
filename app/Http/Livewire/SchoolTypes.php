<?php

namespace App\Http\Livewire;

use App\Models\SchoolType;
use Livewire\Component;

class SchoolTypes extends Component
{
    public $category = '';
    public $name = '';
    public $description = '';
    public $editingId = null;

    protected $rules = [
        'category' => 'required|in:boarding,day',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string'
    ];

    public function save()
    {
        $this->validate();

        SchoolType::create([
            'school_id' => auth()->user()->school_id,
            'category' => $this->category,
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->reset(['category', 'name', 'description']);
        $this->emit('saved');
    }

    public function edit($id)
    {
        $type = SchoolType::findOrFail($id);
        $this->editingId = $id;
        $this->category = $type->category;
        $this->name = $type->name;
        $this->description = $type->description;
    }

    public function update()
    {
        $this->validate();

        SchoolType::findOrFail($this->editingId)->update([
            'category' => $this->category,
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->reset(['editingId', 'category', 'name', 'description']);
        $this->emit('updated');
    }

    public function delete($id)
    {
        SchoolType::findOrFail($id)->delete();
        $this->emit('deleted');
    }

    public function render()
    {
        $schoolTypes = SchoolType::where('school_id', auth()->user()->school_id)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('livewire.school-types', [
            'schoolTypes' => $schoolTypes
        ]);
    }
} 