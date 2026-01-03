@props(['event'])

<div
    class="group relative bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg overflow-hidden hover:border-[#00ff41]/50 transition-all duration-300 hover:shadow-lg hover:shadow-[#00ff41]/10">
    <div class="relative h-48 overflow-hidden">
        <img src="{{ \Illuminate\Support\Str::startsWith($event['cover_image_url'] ?? '', ['http://', 'https://']) ? ($event['cover_image_url'] ?? '') : \Illuminate\Support\Facades\Storage::url($event['cover_image_url'] ?? '') }}" alt="{{ $event['name'] ?? '' }}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        <div class="absolute inset-0 bg-gradient-to-t from-[#0d0015] via-transparent to-transparent"></div>

        @php
        $now = now();
        $startTime = \Carbon\Carbon::parse($event['start_time'] ?? null);
        $endTime = \Carbon\Carbon::parse($event['end_time'] ?? null);
        $isLive = $now->between($startTime, $endTime);
        $isUpcoming = $now->lt($startTime);
        $isEnded = $now->gt($endTime);

        $status = '';
        $statusColor = '';
        $statusTextColor = '';

        if ($isLive) {
        $status = 'LIVE';
        $statusColor = 'bg-[#00ff41]';
        $statusTextColor = 'text-black';
        } elseif ($isUpcoming) {
        $status = 'UPCOMING';
        $statusColor = 'bg-yellow-500';
        $statusTextColor = 'text-black';
        } else {
        $status = 'ENDED';
        $statusColor = 'bg-gray-600';
        $statusTextColor = 'text-white';
        }
        @endphp

        <!-- Status Badge -->
        <div
            class="absolute top-3 left-3 px-3 py-1 rounded {{ $statusColor }} {{ $statusTextColor }} font-mono text-xs font-bold flex items-center gap-1">
            @if ($isLive)
            <span class="w-2 h-2 bg-black rounded-full animate-pulse"></span>
            @endif
            {{ $status }}
        </div>

        <!-- Price Badge -->
        @if (isset($event['is_paid']) && $event['is_paid'])
        <div
            class="absolute top-3 right-3 px-3 py-1 rounded bg-purple-600 text-white font-mono text-xs font-bold flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            {{ $event['price'] ?? '' }}
        </div>
        @else
        <div
            class="absolute top-3 right-3 px-3 py-1 rounded bg-[#00ff41]/20 text-[#00ff41] font-mono text-xs font-bold">
            FREE
        </div>
        @endif

    </div>

    <div class="p-5">
        <h3 class="text-xl font-mono font-bold text-white mb-2 group-hover:text-[#00ff41] transition-colors">
            {{ $event['name'] ?? '' }}
        </h3>
        <div class="text-gray-400 text-sm mb-4 line-clamp-2 prose prose-invert prose-sm">
            {!! \Illuminate\Support\Str::markdown($event['description'] ?? '') !!}
        </div>

        <div class="flex flex-wrap gap-3 mb-4 text-xs font-mono text-gray-500">
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                {{ $startTime->toFormattedDateString() }}
            </div>
            @if ($isUpcoming)
            <div class="flex items-center gap-1 text-yellow-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Starts in {{ $startTime->diffForHumans(null, true) }}
            </div>
            @endif
            @if (isset($event['max_participants']) && $event['max_participants'])
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                {{ $event['max_participants'] }} spots
            </div>
            @endif
            @if ($event['is_rewarded'])
            <div class="flex items-center gap-1 text-[#00ff41] border border-[#00ff41]/30 bg-[#00ff41]/10 px-2 py-0.5 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
                <span>REWARDS</span>
            </div>
            @endif


        </div>

        @php
        $hasAccess = (isset($event['is_paid']) && !$event['is_paid']) || (auth()->check() && $event->accesses->isNotEmpty());
        $checkoutUrl = route('event.checkout', $event['id']);
        $boardUrl = route('challenge-board', $event['id']);
        @endphp

        <button @if ($isEnded) disabled @endif
            @if (!$isEnded)
            @if ($hasAccess)
            onclick="window.location.href = '{{ $boardUrl }}'"
            @else
            onclick="window.location.href = '{{ $checkoutUrl }}'"
            @endif
            @endif
            class="w-full py-3 rounded font-mono font-bold text-sm transition-all flex items-center justify-center gap-2
            {{ $isEnded
                ? 'bg-gray-700 text-gray-400 cursor-not-allowed'
                : ($hasAccess
                    ? 'bg-[#00ff41] text-black hover:bg-[#00ff41]/80'
                    : 'bg-yellow-500 text-black hover:bg-yellow-400') }}">
            @if ($isEnded)
            EVENT_ENDED
            @elseif ($hasAccess)
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 9.9-1"></path>
            </svg>
            ENTER_EVENT
            @else
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            UNLOCK_ACCESS @if($event['price'] > 0) - ${{ number_format($event['price']) }} @endif
            @endif
        </button>
    </div>
</div>