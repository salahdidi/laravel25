<?php

use Livewire\Attributes\Reactive;
use Livewire\Volt\Component;

new class extends Component {
    #[Reactive]
    public array $item = [];
    public int $editIndex = -1;
    public int $index = 0;
}; ?>


<li class="{{ $item['priority'] == 3 ? 'prioritaire-high' : ($item['priority'] == 2 ? 'prioritaire-mid' : 'prioritaire-low')
            }} {{ $editIndex == $index ? 'editing' : '' }}">
    {{ $item['name'] }}
    <a href="#" wire:click="$parent.toggelEditTask({{ $index }})">edit </a>
</li>