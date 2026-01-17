<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public int $cpt = 0;
    public function increment()
    {
        $this->cpt++;
    }
    public function decrement()
    {
        $this->cpt--;
    }
}; ?>
<div>
    <div>
        <button wire:click="increment"> add</button>
        {{ $cpt }}
        <button wire:click="decrement"> sub</button>
    </div>
   
</div>
