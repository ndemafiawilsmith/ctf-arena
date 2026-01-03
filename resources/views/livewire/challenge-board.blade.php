<div class="min-h-screen bg-[#0d0015] text-white font-sans antialiased">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#1a0b2e] to-[#0d0015] border-b border-[#00ff41]/20 p-6">
        <div class="max-w-7xl mx-auto">
            <a href="/" class="text-gray-400 hover:text-[#00ff41] font-mono text-sm mb-4 flex items-center gap-2 inline-block">
                ← BACK_TO_EVENTS
            </a>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-mono font-bold text-white">{{ $event->name }}</h1>
                    <p class="text-gray-400 font-mono text-sm mt-1">
                        {{ count($challenges) }} challenges • {{ count($solvedChallengeIds) }} solved
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    @if($event->is_rewarded)
                    <div class="hidden md:flex flex-col items-end mr-4">
                        <span class="text-[#00ff41] font-mono font-bold text-xs border border-[#00ff41] px-2 py-0.5 rounded flex items-center gap-1 mb-1">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="7"></circle>
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                            </svg>
                            PRIZES ENABLED
                        </span>
                        @if($event->sponsor)
                        <span class="text-xs text-blue-400 font-mono">Sponsored by {{ $event->sponsor }}</span>
                        @endif
                    </div>
                    @endif
                    <div class="bg-black/30 border border-[#00ff41]/30 rounded-lg px-6 py-3">
                        <div class="text-gray-400 font-mono text-xs">YOUR_SCORE</div>
                        <div class="text-[#00ff41] font-mono text-2xl font-bold flex items-center gap-2">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                <path d="M4 22h16"></path>
                                <path d="M10 14.66V17c0 .55-.45 1-1 1H5c-.55 0-1-.45-1-1v-2.34"></path>
                                <path d="M14 14.66V17c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-2.34"></path>
                                <path d="M18 9a4 4 0 0 0-4-4h-4a4 4 0 0 0-4 4"></path>
                                <path d="M12 14.66L12 9"></path>
                            </svg>
                            {{ $userScore }} <span class="text-sm font-normal text-gray-400">/ {{ $totalPoints }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="max-w-7xl mx-auto px-6 mt-6">
        <div class="flex items-center gap-6 border-b border-[#00ff41]/20">
            <button
                wire:click="setTab('challenges')"
                class="pb-3 text-sm font-mono font-bold transition-all {{ $activeTab === 'challenges' ? 'text-[#00ff41] border-b-2 border-[#00ff41]' : 'text-gray-400 hover:text-white' }}">
                CHALLENGES
            </button>
            <button
                wire:click="setTab('leaderboard')"
                class="pb-3 text-sm font-mono font-bold transition-all {{ $activeTab === 'leaderboard' ? 'text-[#00ff41] border-b-2 border-[#00ff41]' : 'text-gray-400 hover:text-white' }}">
                LEADERBOARD
            </button>
            @if($event->is_rewarded)
            <button
                wire:click="setTab('prizes')"
                class="pb-3 text-sm font-mono font-bold transition-all {{ $activeTab === 'prizes' ? 'text-[#00ff41] border-b-2 border-[#00ff41]' : 'text-gray-400 hover:text-white' }}">
                PRIZES
            </button>
            @endif
        </div>
    </div>

    @if ($activeTab === 'challenges')
    <!-- Category Filter -->
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex flex-wrap gap-2">
            @foreach ($categories as $cat)
            <button
                wire:click="setFilter('{{ $cat }}')"
                class="px-4 py-2 rounded font-mono text-sm transition-all flex items-center gap-2 category-btn {{ $filter === $cat ? 'bg-[#00ff41] text-black' : 'bg-black/30 text-gray-400 hover:text-white border border-[#00ff41]/20 hover:border-[#00ff41]/50' }}">
                @switch($cat)
                @case('All') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg> @break
                @case('Web') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="16 18 22 12 16 6"></polyline>
                    <polyline points="8 6 2 12 8 18"></polyline>
                </svg> @break
                @case('Pwn') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <circle cx="12" cy="12" r="6"></circle>
                    <circle cx="12" cy="12" r="2"></circle>
                </svg> @break
                @case('Forensics') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg> @break
                @case('Crypto') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg> @break
                @case('Reverse') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="16 18 22 12 16 6"></polyline>
                    <polyline points="8 6 2 12 8 18"></polyline>
                </svg> @break
                @case('Misc') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg> @break
                @endswitch
                {{ $cat }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Challenge Grid -->
    <div class="max-w-7xl mx-auto px-6 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($challenges as $challenge)
            @php
            $isSolved = in_array($challenge->id, $solvedChallengeIds);
            $difficultyColor = match($challenge->difficulty) {
            'easy' => 'text-green-400 border-green-400/30',
            'medium' => 'text-yellow-400 border-yellow-400/30',
            'hard' => 'text-orange-400 border-orange-400/30',
            'insane' => 'text-red-400 border-red-400/30',
            default => 'text-gray-400 border-gray-400/30'
            };
            @endphp
            <div class="challenge-card relative bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border rounded-lg overflow-hidden transition-all {{ $isSolved ? 'border-[#00ff41]/50 shadow-lg shadow-[#00ff41]/10' : 'border-[#00ff41]/20 hover:border-[#00ff41]/40' }}">
                @if ($isSolved)
                <div class="absolute top-3 right-3 text-[#00ff41]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                @endif

                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[#00ff41]">
                            @switch($challenge->category)
                            @case('Web') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 18 22 12 16 6"></polyline>
                                <polyline points="8 6 2 12 8 18"></polyline>
                            </svg> @break
                            @case('Pwn') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="6"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg> @break
                            @case('Forensics') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg> @break
                            @case('Crypto') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg> @break
                            @case('Reverse') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 18 22 12 16 6"></polyline>
                                <polyline points="8 6 2 12 8 18"></polyline>
                            </svg> @break
                            @case('Misc') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg> @break
                            @endswitch
                        </span>
                        <span class="text-gray-400 font-mono text-xs">{{ $challenge->category }}</span>
                        <span class="ml-auto px-2 py-0.5 rounded border font-mono text-xs {{ $difficultyColor }}">
                            {{ strtoupper($challenge->difficulty) }}
                        </span>
                    </div>

                    <h3 class="text-lg font-mono font-bold mb-2 {{ $isSolved ? 'text-[#00ff41]' : 'text-white' }}">
                        {{ $challenge->title }}
                    </h3>

                    <div class="text-gray-400 text-sm mb-4 prose prose-invert prose-sm max-w-none">
                        {!! \Illuminate\Support\Str::markdown($challenge->description) !!}
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <div class="text-[#00ff41] font-mono font-bold text-xl">
                            {{ $challenge->points }} pts
                        </div>
                        <a
                            href="{{ $challenge->external_link }}"
                            class="flex items-center gap-2 px-3 py-1.5 bg-purple-600/20 text-purple-400 rounded font-mono text-xs hover:bg-purple-600/30 transition-colors">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            START_HACKING
                        </a>
                    </div>

                    @if (!$isSolved)
                    <div class="flex gap-2">
                        <input
                            type="text"
                            placeholder="flag{...}"
                            wire:model="flags.{{ $challenge->id }}"
                            wire:keydown.enter="submitFlag('{{ $challenge->id }}')"
                            class="flex-1 bg-black/50 border border-[#00ff41]/30 rounded px-3 py-2 text-white font-mono text-sm focus:border-[#00ff41] focus:outline-none" />
                        <button
                            wire:click="submitFlag('{{ $challenge->id }}')"
                            class="px-4 py-2 bg-[#00ff41] text-black rounded font-mono text-sm font-bold hover:bg-[#00ff41]/80 transition-colors flex items-center gap-1">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                                <line x1="4" y1="22" x2="4" y2="15"></line>
                            </svg>
                        </button>
                    </div>
                    @else
                    <div class="bg-[#00ff41]/10 border border-[#00ff41]/30 rounded px-3 py-2 text-[#00ff41] font-mono text-sm text-center">
                        SOLVED
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if ($challenges->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-400 font-mono">No challenges found in this category</p>
        </div>
        @endif
    </div>
    @elseif ($activeTab === 'leaderboard')
    <div class="max-w-7xl mx-auto px-6 py-8">
        @if($leaderboard->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-400 font-mono">No solves yet. Be the first!</p>
        </div>
        @else
        <div class="bg-[#0d0015] border border-[#00ff41]/20 rounded-lg overflow-hidden">
            <table class="w-full text-left font-mono">
                <thead class="bg-[#1a0b2e] text-[#00ff41]">
                    <tr>
                        <th class="px-6 py-4 font-bold uppercase text-sm border-b border-[#00ff41]/20">Rank</th>
                        <th class="px-6 py-4 font-bold uppercase text-sm border-b border-[#00ff41]/20">User</th>
                        <th class="px-6 py-4 font-bold uppercase text-sm border-b border-[#00ff41]/20 text-right">Points</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#00ff41]/10">
                    @foreach ($leaderboard as $index => $entry)
                    <tr class="hover:bg-[#00ff41]/5 transition-colors {{ auth()->id() === $entry->id ? 'bg-[#00ff41]/10' : '' }}">
                        <td class="px-6 py-4 text-white text-lg font-bold">#{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-gray-300">
                            <div class="flex items-center gap-2">
                                <span>{{ $entry->name }}</span>
                                @if ($index === 0)
                                <span class="text-yellow-400 text-xs">👑</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-[#00ff41] font-bold text-right">{{ $entry->total_points }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @elseif ($activeTab === 'prizes' && $event->is_rewarded)
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="bg-gradient-to-r from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-xl p-8 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
            </div>
            <h2 class="text-2xl font-mono font-bold text-[#00ff41] mb-6 flex items-center gap-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
                PRIZE_POOL
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- 2nd Place -->
                <div class="order-2 md:order-1 flex flex-col items-center justify-end text-center p-4 bg-gray-900/50 rounded-lg border border-gray-600/30 transform translate-y-4">
                    <span class="text-4xl mb-2">🥈</span>
                    <span class="font-mono font-bold text-gray-300 text-lg">2nd Place</span>
                    <span class="font-mono font-bold text-white text-xl mt-2">₦{{ number_format($event->second_prize) }}</span>
                </div>
                <!-- 1st Place -->
                <div class="order-1 md:order-2 flex flex-col items-center justify-end text-center p-6 bg-yellow-900/20 rounded-lg border border-yellow-500/50 shadow-lg shadow-yellow-500/10">
                    <span class="text-6xl mb-4">🥇</span>
                    <span class="font-mono font-bold text-yellow-500 text-xl">1st Place</span>
                    <span class="font-mono font-bold text-white text-3xl mt-2">₦{{ number_format($event->first_prize) }}</span>
                </div>
                <!-- 3rd Place -->
                <div class="order-3 md:order-3 flex flex-col items-center justify-end text-center p-4 bg-orange-900/20 rounded-lg border border-orange-600/30 transform translate-y-8">
                    <span class="text-4xl mb-2">🥉</span>
                    <span class="font-mono font-bold text-orange-400 text-lg">3rd Place</span>
                    <span class="font-mono font-bold text-white text-xl mt-2">₦{{ number_format($event->third_prize) }}</span>
                </div>
            </div>
        </div>

        @if($event->sponsor)
        <div class="mt-8 bg-blue-900/10 border border-blue-500/20 rounded-xl p-6 text-center">
            <p class="text-blue-400 font-mono text-xs uppercase mb-2">Powered By</p>
            <h3 class="text-2xl font-bold text-white">{{ $event->sponsor }}</h3>
        </div>
        @endif
    </div>
    @endif


</div>