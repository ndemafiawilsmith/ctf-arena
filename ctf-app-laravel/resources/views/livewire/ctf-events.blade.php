<div>
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615307390_81db8ad7.jpg" alt="CTF Arena" class="w-full h-full object-cover opacity-10">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0d0015]/50 via-[#0d0015]/80 to-[#0d0015]"></div>
        </div>
        <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(#00ff41 1px, transparent 1px), linear-gradient(90deg, #00ff41 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00ff41]/10 border border-[#00ff41]/30 rounded-full mb-6">
                <span class="w-2 h-2 bg-[#00ff41] rounded-full animate-pulse"></span>
                <span class="text-[#00ff41] font-mono text-sm">LIVE_EVENTS_ACTIVE</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-mono font-bold text-white mb-6 leading-tight">
                <span class="text-[#00ff41]">CAPTURE</span> THE FLAG
                <br>
                <span class="text-purple-400">ARENA</span>
            </h1>
            <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto font-mono">
                Compete in elite cybersecurity challenges. Hack. Learn. Dominate.
                <br>
                <span class="text-[#00ff41]">Powered by TryHackMe</span>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#events" class="px-8 py-4 bg-[#00ff41] text-black font-mono font-bold rounded-lg hover:bg-[#00ff41]/80 transition-all flex items-center justify-center gap-2 group">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                    BROWSE_EVENTS
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
                <a href="/register" class="px-8 py-4 bg-transparent border-2 border-[#00ff41] text-[#00ff41] font-mono font-bold rounded-lg hover:bg-[#00ff41]/10 transition-all flex items-center justify-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    VIEW_PROFILE
                </a>
            </div>
            <div class="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-mono font-bold text-[#00ff41]">500+</div>
                    <div class="text-gray-500 font-mono text-sm">CHALLENGES</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-mono font-bold text-purple-400">10K+</div>
                    <div class="text-gray-500 font-mono text-sm">HACKERS</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-mono font-bold text-yellow-400">$50K</div>
                    <div class="text-gray-500 font-mono text-sm">PRIZES</div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <div class="w-6 h-10 border-2 border-[#00ff41]/50 rounded-full flex items-start justify-center p-2">
                <div class="w-1 h-2 bg-[#00ff41] rounded-full animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-mono font-bold text-white mb-4">
                    WHY_<span class="text-[#00ff41]">CTF_ARENA</span>?
                </h2>
                <p class="text-gray-400 font-mono max-w-2xl mx-auto">
                    The ultimate platform for cybersecurity competitions
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                $features = [
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#00ff41]"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>',
                        'title' => 'REAL_CHALLENGES',
                        'description' => 'Hands-on labs powered by TryHackMe. No simulations, real vulnerabilities.'
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-400"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path></svg>',
                        'title' => 'COMPETE_&_WIN',
                        'description' => 'Join paid events for cash prizes or free events to sharpen your skills.'
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-400"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
                        'title' => 'GLOBAL_COMMUNITY',
                        'description' => 'Connect with hackers worldwide. Share knowledge, climb the ranks.'
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-400"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
                        'title' => 'INSTANT_ACCESS',
                        'description' => 'Redeem access codes or pay directly. Start hacking in seconds.'
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>',
                        'title' => 'ALL_CATEGORIES',
                        'description' => 'Web, Pwn, Crypto, Forensics, Reverse Engineering, and more.'
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
                        'title' => 'SECURE_PLATFORM',
                        'description' => 'Enterprise-grade security. Your flags, your glory.'
                    ]
                ];
                @endphp

                @foreach ($features as $feature)
                <div class="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-6 hover:border-[#00ff41]/50 transition-all group">
                    <div class="w-14 h-14 rounded-lg bg-black/50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        {!! $feature['icon'] !!}
                    </div>
                    <h3 class="text-lg font-mono font-bold text-white mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-gray-400 text-sm">{{ $feature['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="py-20 px-6 bg-gradient-to-b from-transparent to-[#1a0b2e]/30">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-mono font-bold text-white mb-2">
                        ACTIVE_<span class="text-[#00ff41]">EVENTS</span>
                    </h2>
                    <p class="text-gray-400 font-mono">
                        Choose your battlefield. Prove your skills.
                    </p>
                </div>
                <div class="flex gap-2 mt-4 md:mt-0">
                    <button class="px-4 py-2 bg-[#00ff41] text-black font-mono text-sm rounded">ALL</button>
                    <button class="px-4 py-2 bg-black/30 text-gray-400 font-mono text-sm rounded border border-[#00ff41]/20 hover:text-white">LIVE</button>
                    <button class="px-4 py-2 bg-black/30 text-gray-400 font-mono text-sm rounded border border-[#00ff41]/20 hover:text-white">FREE</button>
                    <button class="px-4 py-2 bg-black/30 text-gray-400 font-mono text-sm rounded border border-[#00ff41]/20 hover:text-white">PAID</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($events as $event)
                    <x-event-card :event="$event" />
                @empty
                    <div class="col-span-full text-center text-gray-400 font-mono">
                        LOADING_EVENTS...
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- Leaderboard Section -->
    <section id="leaderboard" class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-mono font-bold text-white mb-2">
                        GLOBAL_<span class="text-[#00ff41]">RANKINGS</span>
                    </h2>
                    <p class="text-gray-400 font-mono mb-8">
                        Top hackers worldwide. Real-time updates.
                    </p>
                    
                    @if($leaderboard->isEmpty())
                        <div class="p-6 bg-[#0d0015] border border-[#00ff41]/20 rounded-lg text-center text-gray-400 font-mono">
                            No ranked players yet. Be the first to solve a challenge!
                        </div>
                    @else
                        <div class="bg-[#0d0015] border border-[#00ff41]/20 rounded-lg overflow-hidden">
                            @foreach($leaderboard as $index => $user)
                                <div class="flex items-center p-4 border-b border-[#00ff41]/10 last:border-0 hover:bg-[#00ff41]/5 transition-colors">
                                    <div class="w-12 h-12 flex items-center justify-center font-mono font-bold text-xl {{ $index < 3 ? 'text-[#00ff41]' : 'text-gray-500' }}">
                                        #{{ $index + 1 }}
                                    </div>
                                    <div class="flex-1 px-4">
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-mono font-bold text-white">{{ $user->name }}</h4>
                                            @if($index === 0) <span class="text-yellow-400 text-xs">👑</span> @endif
                                        </div>
                                        <p class="text-xs text-gray-500 font-mono">{{ $user->total_solves }} solves</p>
                                    </div>
                                    <div class="font-mono font-bold text-[#00ff41] text-lg">
                                        {{ $user->total_points }} pts
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-8">
                    <h3 class="text-2xl font-mono font-bold text-white mb-6">
                        HOW_TO_<span class="text-[#00ff41]">COMPETE</span>
                    </h3>
                    <div class="space-y-6">
                        @php
                        $steps = [
                            ['step' => '01', 'title' => 'CREATE_ACCOUNT', 'desc' => 'Sign up with your email and choose a hacker name'],
                            ['step' => '02', 'title' => 'JOIN_EVENT', 'desc' => 'Browse events and unlock access with a code or payment'],
                            ['step' => '03', 'title' => 'HACK_CHALLENGES', 'desc' => 'Launch TryHackMe labs and find the flags'],
                            ['step' => '04', 'title' => 'SUBMIT_FLAGS', 'desc' => 'Enter flags to earn points and climb the leaderboard']
                        ];
                        @endphp
                        @foreach($steps as $item)
                        <div class="flex gap-4">
                            <div class="w-12 h-12 rounded-lg bg-[#00ff41]/20 flex items-center justify-center font-mono font-bold text-[#00ff41] flex-shrink-0">
                                {{ $item['step'] }}
                            </div>
                            <div>
                                <h4 class="font-mono font-bold text-white">{{ $item['title'] }}</h4>
                                <p class="text-gray-400 text-sm">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button class="w-full mt-8 px-6 py-4 bg-[#00ff41] text-black font-mono font-bold rounded-lg hover:bg-[#00ff41]/80 transition-all flex items-center justify-center gap-2">
                        GET_STARTED
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <!-- Footer -->
    <x-footer />
</div>
