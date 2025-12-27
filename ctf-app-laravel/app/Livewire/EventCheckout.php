<?php

namespace App\Livewire;

use Livewire\Component;

class EventCheckout extends Component
{
    public \App\Models\CtfEvent $event;

    public function mount(\App\Models\CtfEvent $event)
    {
        $this->event = $event;

        if (!$this->event->is_paid || $this->event->price <= 0) {
            return redirect()->route('challenges.board', $this->event);
        }
    }

    public function pay()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $amountInKobo = $this->event->price * 100; // Paystack expects amount in kobo
        $email = $user->email;
        $reference = \Illuminate\Support\Str::uuid();

        // Initialize Paystack Transaction
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transaction/initialize', [
            'email' => $email,
            'amount' => $amountInKobo,
            'reference' => $reference,
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'user_id' => $user->id,
                'ctf_event_id' => $this->event->id,
            ],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return redirect($data['data']['authorization_url']);
        } else {
            $this->dispatch('error', message: 'Payment initialization failed: ' . $response->json()['message'] ?? 'Unknown error');
        }
    }

    public function render()
    {
        return view('livewire.event-checkout')->layout('components.layouts.app', ['title' => 'Checkout - ' . $this->event->name]);
    }
}
