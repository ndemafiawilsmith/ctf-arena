<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->name }} - CTF Arena</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0d0015] text-white">

    <div class="min-h-screen">
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
                            {{ count($challenges) }} challenges • 0 solved
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-black/30 border border-[#00ff41]/30 rounded-lg px-6 py-3">
                            <div class="text-gray-400 font-mono text-xs">YOUR_SCORE</div>
                            <div class="text-[#00ff41] font-mono text-2xl font-bold flex items-center gap-2">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H5c-.55 0-1-.45-1-1v-2.34"></path><path d="M14 14.66V17c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-2.34"></path><path d="M18 9a4 4 0 0 0-4-4h-4a4 4 0 0 0-4 4"></path><path d="M12 14.66L12 9"></path></svg>
                                {{ $stats['total_points'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex flex-wrap gap-2">
                @foreach ($categories as $cat)
                    <button
                        onclick="filterCategory('{{ $cat }}')"
                        class="px-4 py-2 rounded font-mono text-sm transition-all flex items-center gap-2 category-btn {{ $cat === 'All' ? 'bg-[#00ff41] text-black' : 'bg-black/30 text-gray-400 hover:text-white border border-[#00ff41]/20 hover:border-[#00ff41]/50' }}"
                        data-category="{{ $cat }}"
                    >
                        @switch($cat)
                            @case('All') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> @break
                            @case('Web') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg> @break
                            @case('Pwn') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg> @break
                            @case('Forensics') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg> @break
                            @case('Crypto') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg> @break
                            @case('Reverse') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg> @break
                            @case('Misc') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> @break
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
                        // Placeholder for solved status until Solve model is integrated
                        $solved = false; 
                        $difficultyColor = match($challenge->difficulty) {
                            'easy' => 'text-green-400 border-green-400/30',
                            'medium' => 'text-yellow-400 border-yellow-400/30',
                            'hard' => 'text-orange-400 border-orange-400/30',
                            'insane' => 'text-red-400 border-red-400/30',
                            default => 'text-gray-400 border-gray-400/30'
                        };
                    @endphp
                    <div class="challenge-card relative bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border rounded-lg overflow-hidden transition-all {{ $solved ? 'border-[#00ff41]/50 shadow-lg shadow-[#00ff41]/10' : 'border-[#00ff41]/20 hover:border-[#00ff41]/40' }}" data-category="{{ $challenge->category }}">
                        @if ($solved)
                            <div class="absolute top-3 right-3 text-[#00ff41]">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </div>
                        @endif

                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-[#00ff41]">
                                     @switch($challenge->category)
                                        @case('Web') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg> @break
                                        @case('Pwn') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg> @break
                                        @case('Forensics') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg> @break
                                        @case('Crypto') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg> @break
                                        @case('Reverse') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg> @break
                                        @case('Misc') <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> @break
                                    @endswitch
                                </span>
                                <span class="text-gray-400 font-mono text-xs">{{ $challenge->category }}</span>
                                <span class="ml-auto px-2 py-0.5 rounded border font-mono text-xs {{ $difficultyColor }}">
                                    {{ strtoupper($challenge->difficulty) }}
                                </span>
                            </div>

                            <h3 class="text-lg font-mono font-bold mb-2 {{ $solved ? 'text-[#00ff41]' : 'text-white' }}">
                                {{ $challenge->title }}
                            </h3>

                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ $challenge->description }}
                            </p>

                            <div class="flex items-center justify-between mb-4">
                                <div class="text-[#00ff41] font-mono font-bold text-xl">
                                    {{ $challenge->points }} pts
                                </div>
                                <a
                                    href="{{ $challenge->external_link }}"
                                    class="flex items-center gap-2 px-3 py-1.5 bg-purple-600/20 text-purple-400 rounded font-mono text-xs hover:bg-purple-600/30 transition-colors"
                                >
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    START_HACKING
                                </a>
                            </div>

                            @if (!$solved)
                                <div class="flex gap-2">
                                    <input
                                        type="text"
                                        placeholder="flag{...}"
                                        class="flex-1 bg-black/50 border border-[#00ff41]/30 rounded px-3 py-2 text-white font-mono text-sm focus:border-[#00ff41] focus:outline-none"
                                        onkeydown="if(event.key === 'Enter') submitFlag('{{ $challenge->id }}', this.nextElementSibling)"
                                    />
                                    <button onclick="submitFlag('{{ $challenge->id }}', this)" class="px-4 py-2 bg-[#00ff41] text-black rounded font-mono text-sm font-bold hover:bg-[#00ff41]/80 transition-colors flex items-center gap-1">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
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
            
            <div id="no-challenges" class="hidden text-center py-12">
                 <p class="text-gray-400 font-mono">No challenges found in this category</p>
            </div>
        </div>
    </div>

    <script>
        async function submitFlag(challengeId, btnElement) {
            const container = btnElement.closest('.challenge-card');
            const input = container.querySelector('input[type="text"]');
            const flag = input.value.trim();
            const originalBtnContent = btnElement.innerHTML;

            if (!flag) return;

            // Loading State
            btnElement.disabled = true;
            btnElement.innerHTML = '<svg class="animate-spin h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            try {
                const response = await fetch(`/challenges/${challengeId}/submit`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ flag: flag })
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    // Success UI
                    // 1. Change card border/shadow
                    container.classList.remove('border-[#00ff41]/20', 'hover:border-[#00ff41]/40');
                    container.classList.add('border-[#00ff41]/50', 'shadow-lg', 'shadow-[#00ff41]/10');
                    
                    // 2. Add solved icon
                    const solvedIcon = document.createElement('div');
                    solvedIcon.className = 'absolute top-3 right-3 text-[#00ff41]';
                    solvedIcon.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
                    container.appendChild(solvedIcon);

                    // 3. Update Title Color
                    container.querySelector('h3').classList.remove('text-white');
                    container.querySelector('h3').classList.add('text-[#00ff41]');

                    // 4. Replace Input with Solved Badge
                    const inputGroup = input.parentElement;
                    inputGroup.innerHTML = `
                        <div class="w-full bg-[#00ff41]/10 border border-[#00ff41]/30 rounded px-3 py-2 text-[#00ff41] font-mono text-sm text-center animate-pulse">
                            SOLVED + ${data.points} pts
                        </div>
                    `;

                    // Play success sound (optional, maybe later)

                } else {
                    // Error Handling
                    btnElement.disabled = false;
                    btnElement.innerHTML = originalBtnContent;
                    
                    // Shake animation logic
                    input.classList.add('border-red-500', 'animate-shake');
                    setTimeout(() => {
                        input.classList.remove('border-red-500', 'animate-shake');
                    }, 500);

                    // Optional: Show toast or text error
                    alert(data.message || 'Incorrect flag');
                }

            } catch (error) {
                console.error('Error:', error);
                btnElement.disabled = false;
                btnElement.innerHTML = originalBtnContent;
                alert('Something went wrong. Please try again.');
            }
        }

        function filterCategory(category) {
            // Update active button state
            document.querySelectorAll('.category-btn').forEach(btn => {
                if(btn.dataset.category === category) {
                    btn.classList.remove('bg-black/30', 'text-gray-400', 'border-transparent');
                    btn.classList.add('bg-[#00ff41]', 'text-black');
                } else {
                    btn.classList.add('bg-black/30', 'text-gray-400');
                    btn.classList.remove('bg-[#00ff41]', 'text-black');
                }
            });

            // Filter Grid
            let visibleCount = 0;
            document.querySelectorAll('.challenge-card').forEach(card => {
                if (category === 'All' || card.dataset.category === category) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

             // Show/Hide Empty State
            const noChallengesMsg = document.getElementById('no-challenges');
            if (visibleCount === 0) {
                noChallengesMsg.classList.remove('hidden');
            } else {
                noChallengesMsg.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
