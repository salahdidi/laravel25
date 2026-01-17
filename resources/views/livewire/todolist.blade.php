<?php

use Illuminate\Support\Facades\Cache as Cache;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;


new #[Layout('layouts.app')] class extends Component {
     public array $tasks = [];
     public array $allTasks = [];
     public string $task  = '';
     public string $search = '';

     public function save()
     {
        $this->tasks[] = $this->task;
        $this->allTasks[] = $this->task;
        $this->task = '';
        
     }
     public function filterTasks()
     {
        $this->allTasks = $this->tasks;
        $this->tasks = array_filter($this->tasks, function($task) {
            return str_contains(strtolower($task), strtolower($this->search));
        });
     }
}; ?>

<div>
    <div>
        <label for="text">Task Name : </label>
        <input type="text" wire:model="task">
        <button wire:click="save()"> add Task</button>
        
    </div>
    <div>
        <label for="search"> cherche une task</label>
        <input type="text" wire:model="search" wire:change="filterTasks">
    </div>
    @foreach ($tasks as $task)
          {{ $task }}
          <br>
    @endforeach
</div>
