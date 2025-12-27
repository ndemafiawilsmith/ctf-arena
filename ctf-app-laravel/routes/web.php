<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\CtfEvents;
use App\Livewire\CtfEvent;
use App\Livewire\ChallengeBoard;

use App\Http\Controllers\ChallengeController;

Route::get('/', CtfEvents::class)->name('ctf-events');
Route::get('/ctf/{event}', CtfEvent::class)->name('ctf-event');
// Route::get('/challenges', ChallengeBoard::class)->name('challenge-board');
Route::get('/ctf/{event}', CtfEvent::class)->name('ctf-event');
Route::get('/events/{event}', \App\Livewire\EventDetails::class)->name('event.details');
Route::get('/events/{event}/checkout', \App\Livewire\EventCheckout::class)->name('event.checkout');
Route::get('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/events/{event}/challenges', \App\Livewire\ChallengeBoard::class)->name('challenge-board');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
