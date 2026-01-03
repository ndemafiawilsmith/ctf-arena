<div class="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg overflow-hidden">
    <div class="p-4 border-b border-[#00ff41]/20 flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#00ff41]"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
        <h3 class="font-mono font-bold text-white">
            GLOBAL_RANKINGS
        </h3>
        <span class="ml-auto text-gray-400 font-mono text-xs">
            {{ count($users) }} players
        </span>
    </div>

    <div class="max-h-[500px] overflow-y-auto">
        @if (empty($users))
            <div class="p-8 text-center text-gray-400 font-mono">
                No scores yet. Be the first!
            </div>
        @else
            <div class="divide-y divide-[#00ff41]/10">
                @foreach ($users as $index => $user)
                    @php
                        $rank = $index + 1;
                        $rankBg = '';
                        switch ($rank) {
                            case 1:
                                $rankBg = 'bg-gradient-to-r from-yellow-500/20 to-transparent border-yellow-500/30';
                                break;
                            case 2:
                                $rankBg = 'bg-gradient-to-r from-gray-400/20 to-transparent border-gray-400/30';
                                break;
                            case 3:
                                $rankBg = 'bg-gradient-to-r from-amber-600/20 to-transparent border-amber-600/30';
                                break;
                            default:
                                $rankBg = 'bg-black/30 border-[#00ff41]/10';
                                break;
                        }
                    @endphp
                    <div class="flex items-center gap-4 p-4 transition-colors hover:bg-[#00ff41]/5 {{ $rankBg }}">
                        <div class="w-8 flex justify-center">
                            @switch($rank)
                                @case(1)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-400"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path></svg>
                                    @break
                                @case(2)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-300"><path d="M12 22c-3.33 0-4-1.5-4-3.5 0-2 2-3 4-3s4 1 4 3.5c0 2-1 3.5-4 3.5Z"></path><path d="M12 15c-3.33 0-4-1.5-4-3.5C8 9.5 9.5 8 12 8s4 1.5 4 3.5c0 2-1 3.5-4 3.5Z"></path><path d="M12 8c-3.33 0-4-1.5-4-3.5C8 2.5 9.5 1 12 1s4 1.5 4 3.5c0 2-1 3.5-4 3.5Z"></path></svg>
                                    @break
                                @case(3)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600"><path d="m12.39 1.4-4.24 4.24"></path><path d="m12.39 12.39 4.24 4.24"></path><path d="M19.07 4.93 4.93 19.07"></path><path d="M4.93 4.93 19.07 19.07"></path></svg>
                                    @break
                                @default
                                    <span class="text-gray-500 font-mono text-lg w-6 text-center">{{ $rank }}</span>
                            @endswitch
                        </div>

                        <div class="w-10 h-10 rounded-full bg-[#00ff41]/20 flex items-center justify-center overflow-hidden">
                            @if ($user['avatar_url'])
                                <img src="{{ $user['avatar_url'] }}" alt="" class="w-full h-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#00ff41]"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="font-mono font-bold text-white truncate">
                                {{ $user['username'] }}
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="font-mono font-bold text-[#00ff41] text-lg">
                                {{ $user['total_score'] }}
                            </div>
                            <div class="font-mono text-xs text-gray-500">points</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
