<div class="min-h-screen flex flex-col pt-16"> {{-- pt-16 to account for fixed header if applicable or just spacing --}}
    <div class="flex-grow flex items-center justify-center p-6 bg-[#0d0015]">
        <div class="max-w-4xl w-full bg-[#1a0b2e] border border-[#00ff41]/20 rounded-xl overflow-hidden shadow-2xl flex flex-col md:flex-row relative">
            
            {{-- Back Button --}}
            <a href="{{ route('ctf-events') }}" class="absolute top-4 left-4 z-10 p-2 bg-black/50 text-white rounded-full hover:bg-[#00ff41] hover:text-black transition-colors">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>

            <!-- Event Image -->
            <div class="w-full md:w-1/2 bg-black relative">
                @if($event->cover_image_url)
                    <img src="{{ \Illuminate\Support\Str::startsWith($event->cover_image_url, ['http://', 'https://']) ? $event->cover_image_url : \Illuminate\Support\Facades\Storage::url($event->cover_image_url) }}" alt="{{ $event->name }}" class="w-full h-full object-cover opacity-80">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-900 to-black">
                        <span class="text-4xl">🔒</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-[#1a0b2e] via-transparent to-transparent md:bg-gradient-to-r"></div>
            </div>

            <!-- Checkout Details -->
            <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
                <div class="mb-6">
                    <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 rounded text-xs font-mono">PREMIUM ACCESS</span>
                </div>
                
                <h1 class="text-3xl font-mono font-bold text-white mb-4">{{ $event->name }}</h1>
                <div class="text-gray-400 text-sm mb-6 prose prose-invert">
                    {!! \Illuminate\Support\Str::markdown($event->description) !!}
                </div>

                <div class="flex items-center justify-between border-t border-b border-[#00ff41]/10 py-4 mb-8">
                    <span class="text-gray-400 font-mono">Total Price</span>
                    <span class="text-2xl font-bold text-[#00ff41] font-mono">${{ number_format($event->price, 2) }}</span>
                </div>

                @if($event->is_rewarded)
                    <div class="mb-8 bg-[#0d0015] border border-[#00ff41]/20 rounded-lg p-4">
                        <h3 class="text-[#00ff41] font-mono font-bold mb-3 text-sm border-b border-[#00ff41]/20 pb-2 flex items-center gap-2">
                             <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                             PRIZE POOL
                        </h3>
                        <div class="space-y-2 text-sm font-mono">
                            <div class="flex justify-between">
                                <span class="text-yellow-500">🥇 1st Place</span>
                                <span class="text-white">{{ $event->first_prize }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">🥈 2nd Place</span>
                                <span class="text-white">{{ $event->second_prize }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-orange-400">🥉 3rd Place</span>
                                <span class="text-white">{{ $event->third_prize }}</span>
                            </div>
                        </div>
                         @if($event->sponsor)
                            <div class="mt-4 pt-3 border-t border-[#00ff41]/20 text-center">
                                <span class="text-xs text-blue-400 uppercase">Sponsored By</span>
                                <span class="block text-white font-bold">{{ $event->sponsor }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <button
                    wire:click="pay"
                    wire:loading.attr="disabled"
                    class="w-full py-4 bg-[#00ff41] text-black font-mono font-bold text-lg rounded hover:bg-[#00ff41]/90 transition-all flex items-center justify-center gap-2 group"
                >
                    <span wire:loading.remove>PAY SECURELY NOW</span>
                    <span wire:loading class="animate-pulse">PROCESSING...</span>
                    <svg wire:loading.remove width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
                <p class="text-center text-gray-500 text-xs mt-4 flex items-center justify-center gap-1">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    Secured by Paystack
                </p>
            </div>
        </div>
    </div>
    
    <x-footer />
</div>
