<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;

class AuthModal extends Component
{
    public bool $isOpen = false;
    public string $mode = 'login';
    public string $email = '';
    public string $password = '';
    public string $username = '';
    public bool $showPassword = false;
    public string $error = '';
    public bool $loading = false;

    // protected $listeners = ['openAuthModal'];

    #[On('openAuthModal')]
    public function openAuthModal($mode = 'login')
    {
        // Handle array payload (named parameters)
        if (is_array($mode) && isset($mode['mode'])) {
            $mode = $mode['mode'];
        }

        $this->resetState();
        $this->mode = $mode;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function switchMode($mode = null)
    {
        if ($mode) {
            $this->mode = $mode;
        } else {
            $this->mode = $this->mode === 'login' ? 'signup' : 'login';
        }
        $this->reset('error');
    }

    public function submit()
    {
        $this->reset('error');

        if ($this->mode === 'login') {
            $this->login();
        } elseif ($this->mode === 'signup') {
            $this->register();
        } else {
            $this->sendPasswordResetLink();
        }
    }

    public function handleSubmit()
    {
        $this->submit();
    }

    public function sendPasswordResetLink()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => $this->email]);

        if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
            $this->closeModal();
            // Optional: Dispatch a success notification or show a message
            // For now, simpler is better for "hacker" aesthetic
        } else {
            $this->addError('email', __($status));
        }
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->closeModal();
            return redirect()->intended(route('dashboard'));
        }

        $this->addError('email', 'These credentials do not match our records.');
    }

    public function register()
    {
        $this->validate([
            'username' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        event(new \Illuminate\Auth\Events\Registered($user));

        Auth::login($user);

        $this->closeModal();
        return redirect()->route('dashboard');
    }

    public function resetState()
    {
        $this->reset(['email', 'password', 'username', 'showPassword', 'error', 'loading']);
    }

    public function render()
    {
        return view('livewire.auth-modal');
    }
}
