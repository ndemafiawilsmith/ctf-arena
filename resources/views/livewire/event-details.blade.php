<div class="min-h-screen bg-[#0d0015] font-sans antialiased text-white pt-16">
    <div class="relative h-[400px] w-full overflow-hidden">
        @if ($event->cover_image_url)
            <img src="{{ \Illuminate\Support\Str::startsWith($event->cover_image_url, ['http://', 'https://']) ? $event->cover_image_url : \Illuminate\Support\Facades\Storage::url($event->cover_image_url) }}" alt="{{ $event->name }}" class="w-full h-full object-cover opacity-60" />
        @else
             <div class="w-full h-full bg-gradient-to-br from-purple-900 to-black opacity-60 flex items-center justify-center">
                 <span class="text-6xl">🏆</span>
             </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-[#0d0015] via-transparent to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full p-8 max-w-7xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-mono font-bold text-white mb-4 shadow-lg">{{ $event->name }}</h1>
            <div class="flex items-center gap-4 text-sm font-mono text-gray-300">
                <span class="flex items-center gap-1"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> {{ $event->start_time->format('M d, Y H:i') }}</span>
                @if($event->is_rewarded)
                    <span class="bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 px-2 py-0.5 rounded flex items-center gap-1">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        REWARD_ENABLED
                    </span>
                @endif
                @if($event->sponsor)
                    <span class="bg-blue-500/20 text-blue-400 border border-blue-500/30 px-2 py-0.5 rounded">
                        Sponsored by {{ $event->sponsor }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Rewards Section -->
            @if($event->is_rewarded)
                <div class="bg-gradient-to-r from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-xl p-8 relative overflow-hidden group">
                     <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                     </div>
                     <h2 class="text-2xl font-mono font-bold text-[#00ff41] mb-6 flex items-center gap-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        PRIZE_POOL
                     </h2>

                     <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                         <!-- 2nd Place -->
                         <div class="order-2 md:order-1 flex flex-col items-center justify-end text-center p-4 bg-gray-900/50 rounded-lg border border-gray-600/30 transform translate-y-4">
                             <span class="text-4xl mb-2">🥈</span>
                             <span class="font-mono font-bold text-gray-300 text-lg">2nd Place</span>
                             <span class="font-mono font-bold text-white text-xl mt-2">{{ $event->second_prize }}</span>
                         </div>
                         <!-- 1st Place -->
                         <div class="order-1 md:order-2 flex flex-col items-center justify-end text-center p-6 bg-yellow-900/20 rounded-lg border border-yellow-500/50 shadow-lg shadow-yellow-500/10">
                             <span class="text-6xl mb-4">🥇</span>
                             <span class="font-mono font-bold text-yellow-500 text-xl">1st Place</span>
                             <span class="font-mono font-bold text-white text-3xl mt-2">{{ $event->first_prize }}</span>
                         </div>
                         <!-- 3rd Place -->
                         <div class="order-3 md:order-3 flex flex-col items-center justify-end text-center p-4 bg-orange-900/20 rounded-lg border border-orange-600/30 transform translate-y-8">
                             <span class="text-4xl mb-2">🥉</span>
                             <span class="font-mono font-bold text-orange-400 text-lg">3rd Place</span>
                             <span class="font-mono font-bold text-white text-xl mt-2">{{ $event->third_prize }}</span>
                         </div>
                     </div>
                </div>
            @endif

            <!-- Description -->
            <div class="prose prose-invert max-w-none">
                <h2 class="font-mono text-[#00ff41]">EVENT_BRIEFING</h2>
                {!! \Illuminate\Support\Str::markdown($event->description) !!}
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Sponsor Card -->
             @if($event->is_rewarded && $event->sponsor)
                <div class="bg-blue-900/10 border border-blue-500/20 rounded-xl p-6 text-center">
                    <p class="text-blue-400 font-mono text-xs uppercase mb-2">Powered By</p>
                    <h3 class="text-2xl font-bold text-white">{{ $event->sponsor }}</h3>
                </div>
            @endif

            <!-- Action Card -->
            <div class="bg-[#1a0b2e] border border-[#00ff41]/20 rounded-xl p-6 sticky top-24">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-400 font-mono">Entry Fee</span>
                    @if($event->is_paid)
                        <span class="text-2xl font-bold text-[#00ff41] font-mono">${{ number_format($event->price, 2) }}</span>
                    @else
                        <span class="text-2xl font-bold text-[#00ff41] font-mono">FREE</span>
                    @endif
                </div>

                @php
                    $hasAccess = (isset($event->is_paid) && !$event->is_paid) || (auth()->check() && $event->accesses()->where('user_id', auth()->id())->where('status', 'success')->exists());
                    $isEnded = now()->gt($event->end_time);
                @endphp

                @if($isEnded)
                    <button disabled class="w-full py-3 bg-gray-700 text-gray-400 rounded font-mono font-bold cursor-not-allowed">
                        EVENT ENDED
                    </button>
                @elseif($hasAccess)
                     <a href="{{ route('challenge-board', $event->id) }}" class="block w-full text-center py-3 bg-[#00ff41] text-black rounded font-mono font-bold hover:bg-[#00ff41]/90 transition-colors">
                        ENTER EVENT
                    </a>
                @else
                    <a href="{{ route('event.checkout', $event->id) }}" class="block w-full text-center py-3 bg-yellow-500 text-black rounded font-mono font-bold hover:bg-yellow-400 transition-colors">
                        UNLOCK ACCESS
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <x-footer />
</div>
