<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach ($challenges as $challenge)
        <div class="bg-[#0a0010] border border-[#00ff41]/20 rounded-lg overflow-hidden shadow-lg hover:shadow-xl hover:border-[#00ff41]/40 transition-all duration-300">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold font-mono text-white">{{ $challenge['title'] }}</h3>
                    <span class="px-3 py-1 bg-blue-400 text-black font-mono text-sm rounded-full">{{ $challenge['category'] }}</span>
                </div>
                <p class="text-gray-400 font-mono text-sm mb-4">{{ $challenge['description'] }}</p>
                <div class="flex justify-between items-center text-sm font-mono text-gray-500">
                    <span>{{ $challenge['points'] }} Points</span>
                    <button class="px-4 py-2 bg-[#00ff41] text-black font-mono rounded-md hover:bg-[#00b32d] transition-colors duration-300">View</button>
                </div>
            </div>
        </div>
    @endforeach
</div>
