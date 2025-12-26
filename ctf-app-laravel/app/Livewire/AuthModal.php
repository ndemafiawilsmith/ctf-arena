<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    protected $listeners = ['openAuthModal'];

    public function openAuthModal($mode = 'login')
    {
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

    public function switchMode()
    {
        $this->mode = $this->mode === 'login' ? 'signup' : 'login';
        $this->reset('error');
    }

    public function handleSubmit()
    {
        $this->reset('error');
        $this->loading = true;

        if ($this->mode === 'login') {
            $this->login();
        } else {
            $this->register();
        }

        $this->loading = false;
    }

    public function login()
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            $this->closeModal();
            return redirect()->intended('/');
        } else {
            $this->error = 'Invalid credentials.';
        }
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

        Auth::login($user);

        $this->closeModal();
        return redirect()->intended('/');
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