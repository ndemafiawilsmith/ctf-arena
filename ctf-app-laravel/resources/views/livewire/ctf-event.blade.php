<div>
    <h1 class="text-3xl font-bold mb-4">{{ $event->name }}</h1>
    <p class="text-gray-400 mb-8">{{ $event->description }}</p>

    @if ($successMessage)
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">{{ $successMessage }}</div>
    @endif

    @if ($errorMessage)
        <div class="bg-red-500 text-white p-4 rounded-lg mb-4">{{ $errorMessage }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($event->challenges as $challenge)
            <div class="bg-gray-800 rounded-lg shadow-md p-6 {{ in_array($challenge->id, $solvedChallengeIds) ? 'border-2 border-green-500' : '' }}">
                <h2 class="text-xl font-bold mb-2">{{ $challenge->title }}</h2>
                <p class="text-gray-400 mb-4">{{ $challenge->description }}</p>
                <div class="flex justify-between items-center mb-4">
                    <span class="px-3 py-1 bg-gray-700 text-white rounded-full text-sm">{{ $challenge->category }}</span>
                    <span class="font-bold text-lg">{{ $challenge->points }} pts</span>
                </div>
                <p class="capitalize mb-4">Difficulty: <span class="font-semibold {{ $challenge->difficulty === 'easy' ? 'text-green-400' : ($challenge->difficulty === 'medium' ? 'text-yellow-400' : 'text-red-400') }}">{{ $challenge->difficulty }}</span></p>
                @if ($challenge->external_link)
                    <a href="{{ $challenge->external_link }}" target="_blank" class="text-indigo-400 hover:underline mb-4 block">Challenge Link</a>
                @endif

                @if(in_array($challenge->id, $solvedChallengeIds))
                    <p class="text-green-500 font-bold">Solved!</p>
                @else
                    <form wire:submit.prevent="submitFlag({{ $challenge->id }})">
                        <div class="flex">
                            <input wire:model.defer="flag.{{ $challenge->id }}" type="text" class="bg-gray-700 text-white rounded-l-lg p-2 w-full" placeholder="Enter flag">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-r-lg">Submit</button>
                        </div>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
