<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="mb-6 p-4 bg-[#00ff41]/5 border border-[#00ff41]/20 rounded-lg">
                        <h3 class="font-bold text-lg mb-2 text-[#00ff41] font-mono">Dynamic Challenge Identity</h3>
                        <p class="text-sm text-gray-400 mb-3 font-mono">
                            Some challenges are dynamic and require you to generate a unique flag on the target machine.
                            Use the ID below when prompted.
                        </p>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold text-gray-400 font-mono">User ID:</span>
                            <code class="bg-[#0d0015] px-3 py-1 rounded border border-[#00ff41]/30 font-mono text-[#00ff41] font-bold select-all">
                                {{ auth()->id() }}
                            </code>
                        </div>
                    </div>

                    <div class="font-mono text-[#00ff41]">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>