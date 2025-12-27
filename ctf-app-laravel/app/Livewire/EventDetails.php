<?php

namespace App\Livewire;

use Livewire\Component;

class EventDetails extends Component
{
    public \App\Models\CtfEvent $event;

    public function mount(\App\Models\CtfEvent $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.event-details')
            ->layout('components.layouts.app', ['title' => $this->event->name]);
    }
}
