<div
    wire:keydown.escape.window="closeModal">
    @if($isOpen)
    <div
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" wire:click="closeModal"></div>
        <div
            class="relative bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/30 rounded-lg p-8 w-full max-w-md shadow-2xl shadow-[#00ff41]/10"
            @click.stop>
            <button wire:click="closeModal"
                class="absolute top-4 right-4 text-gray-400 hover:text-[#00ff41] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <div class="flex items-center gap-3 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-[#00ff41]">
                    <polyline points="4 17 10 11 4 5"></polyline>
                    <line x1="12" y1="19" x2="20" y2="19"></line>
                </svg>
                <h2 class="text-2xl font-mono font-bold text-white">
                    @if ($mode === 'login')
                    ACCESS_TERMINAL
                    @elseif ($mode === 'signup')
                    CREATE_IDENTITY
                    @else
                    RECOVER_ACCESS
                    @endif
                </h2>
            </div>

            <form wire:submit.prevent="submit" class="space-y-4">
                @if ($mode === 'signup')
                <div>
                    <label class="block text-[#00ff41] font-mono text-sm mb-2">
                        USERNAME
                    </label>
                    <input type="text" wire:model.defer="username"
                        class="w-full bg-black/50 border border-[#00ff41]/30 rounded px-4 py-3 text-white font-mono focus:border-[#00ff41] focus:outline-none focus:ring-1 focus:ring-[#00ff41]/50 transition-all"
                        placeholder="h4ck3r_name" required>
                    @error('username') <span class="text-red-500 text-xs font-mono mt-1 block" style="color: red;">{{ $message }}</span> @enderror
                </div>
                @endif

                <div>
                    <label class="block text-[#00ff41] font-mono text-sm mb-2">
                        EMAIL
                    </label>
                    <input type="email" wire:model.defer="email"
                        class="w-full bg-black/50 border border-[#00ff41]/30 rounded px-4 py-3 text-white font-mono focus:border-[#00ff41] focus:outline-none focus:ring-1 focus:ring-[#00ff41]/50 transition-all"
                        placeholder="user@domain.com" required>
                    @error('email') <span class="text-red-500 text-xs font-mono mt-1 block" style="color: red;">{{ $message }}</span> @enderror
                </div>

                @if ($mode !== 'forgot-password')
                <div>
                    <label class="block text-[#00ff41] font-mono text-sm mb-2">
                        PASSWORD
                    </label>
                    <div class="relative">
                        <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model.defer="password"
                            class="w-full bg-black/50 border border-[#00ff41]/30 rounded px-4 py-3 text-white font-mono focus:border-[#00ff41] focus:outline-none focus:ring-1 focus:ring-[#00ff41]/50 transition-all pr-12"
                            placeholder="••••••••" required>
                        <button type="button" wire:click="togglePasswordVisibility"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#00ff41]">
                            @if ($showPassword)
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24">
                                </path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            @endif
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs font-mono mt-1 block" style="color: red;">{{ $message }}</span> @enderror
                </div>
                @endif

                @if ($error)
                <div class="bg-red-500/10 border border-red-500/30 rounded p-3 text-red-400 text-sm font-mono" style="color: red;">
                    ERROR: {{ $error }}
                </div>
                @endif

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-[#00ff41] text-black font-mono font-bold py-3 rounded hover:bg-[#00ff41]/80 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <div wire:loading wire:target="submit">
                        <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="2" x2="12" y2="6"></line>
                            <line x1="12" y1="18" x2="12" y2="22"></line>
                            <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                            <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                            <line x1="2" y1="12" x2="6" y2="12"></line>
                            <line x1="18" y1="12" x2="22" y2="12"></line>
                            <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                            <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                        </svg>
                        <span>PROCESSING...</span>
                    </div>
                    <div wire:loading.remove wire:target="submit">
                        @if ($mode === 'login')
                        LOGIN
                        @elseif ($mode === 'signup')
                        REGISTER
                        @else
                        SEND LINK
                        @endif
                    </div>
                </button>
            </form>

            <div class="mt-6 text-center space-y-2">
                @if ($mode === 'login')
                <button wire:click="switchMode('signup')"
                    class="block w-full text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                    Need an account? REGISTER
                </button>
                <button wire:click="switchMode('forgot-password')"
                    class="block w-full text-gray-500 hover:text-[#00ff41] font-mono text-xs transition-colors">
                    Forgot Password?
                </button>
                @elseif ($mode === 'signup')
                <button wire:click="switchMode('login')"
                    class="block w-full text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                    Have an account? LOGIN
                </button>
                @else
                <button wire:click="switchMode('login')"
                    class="block w-full text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                    Back to LOGIN
                </button>
                @endif
            </div>
        </div>
        @endif
    </div>