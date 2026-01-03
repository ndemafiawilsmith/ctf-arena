<nav x-data="{ open: false }"
    class="fixed top-0 left-0 right-0 z-40 bg-[#0d0015]/90 backdrop-blur-md border-b border-[#00ff41]/20">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
                <a href="{{ route('ctf-events') }}" class="flex items-center gap-3">
                    <svg class="text-[#00ff41]" width="28" height="28" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="4 17 10 11 4 5"></polyline>
                        <line x1="12" y1="19" x2="20" y2="19"></line>
                    </svg>
                    <span class="font-mono font-bold text-white text-xl hidden sm:block">CTF_ARENA</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('ctf-events') }}" class="text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                    EVENTS
                </a>
                <a href="/#leaderboard" class="text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                    LEADERBOARD
                </a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="w-8 h-8 rounded-full bg-[#00ff41] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#0d0015] focus:ring-[#00ff41]"></button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <div class="hidden md:flex items-center gap-4">
                    <button onclick="Livewire.dispatch('openAuthModal', { mode: 'login' })"
                        class="text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                        LOGIN
                    </button>

                    <button onclick="Livewire.dispatch('openAuthModal', { mode: 'signup' })"
                        class="px-4 py-2 bg-[#00ff41] text-black font-mono font-bold text-sm rounded hover:bg-[#00ff41]/80 transition-colors">
                        REGISTER
                    </button>
                </div>

                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="#events"
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition">EVENTS</a>
            <a href="#leaderboard"
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition">LEADERBOARD</a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700">
            @auth
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                            this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
            <div class="space-y-1">
                <button onclick="Livewire.dispatch('openAuthModal', 'login'); open = false;"
                    class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition">
                    LOGIN
                </button>
                <button onclick="Livewire.dispatch('openAuthModal', 'signup'); open = false;"
                    class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition">
                    REGISTER
                </button>
            </div>
            @endauth
        </div>
    </div>
</nav>