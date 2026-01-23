<?php

use App\Models\task;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public $tasks = [];
    public string $input = '';
    public bool $editing = false;
    public int $editIndex = -1;
    public int $priority = 1;

    public function mount()
    {
        $this->tasks = task::where('created_by_id', auth()->user()->id)->get()->toArray();
    }

    public function addTask()
    {
        $tasks = new task();
        $tasks->name = $this->input;
        $tasks->priority = $this->priority;
        $tasks->created_by_id = auth()->user()->id;
        $tasks->save();
        $this->tasks[] = $tasks;
        $this->input = '';
    }
    public function toggelEditTask(int $index)
    {

        $task = $this->tasks[$index];

        $this->input = $task['name'];
        $this->priority = $task['priority'];
        $this->editIndex = $index;
        $this->editing = true;
    }
    public function editTask()
    {


        $task = task::find($this->tasks[$this->editIndex]['id']);
        $task->name = $this->input;
        $task->priority = $this->priority;
        $task->save();

        $this->tasks[$this->editIndex] = $task;

        $this->editing = false;
        $this->editIndex = -1;
        $this->input = '';
        $this->priority = 1;
    }
}; ?>

<div class='container'>

    <h1>Task List</h1>

    <ul>
        @foreach ($tasks as $index => $task)
            <li class="{{ $task['priority'] == 3 ? 'prioritaire-high' : ($task['priority'] == 2 ? 'prioritaire-mid' : 'prioritaire-low')
                                                                       }} {{ $editIndex == $index ? 'editing' : '' }}">
                {{ $task['name'] }}
                <a href="#" wire:click="toggelEditTask({{ $index }})">edit </a>
            </li>
        @endforeach
    </ul>
    <div style="display: flex;">
        <input style="width: 70%;" type="text" name="" id="" wire:model="input">
        <select style="width: 28%;" name="" id="" wire:model="priority">
            <option value="1">low</option>
            <option value="2">mid</option>
            <option value="3">high</option>
        </select>


    </div>
    @if (!$editing)
        <button wire:click="addTask">add task</button>
    @else
        <button wire:click="editTask">update task</button>
    @endif

    @dump($tasks)
</div>