<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- User ID Section with Copy Button -->
            <div class="p-4 sm:p-8 bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-[#00ff41] font-mono">
                                {{ __('User ID') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-400 font-mono">
                                {{ __("Your unique identifier for dynamic challenges.") }}
                            </p>
                        </header>

                        <div class="mt-4 flex items-center gap-4" x-data="{ copied: false }">
                            <code class="bg-[#00ff41]/10 px-4 py-2 rounded border border-[#00ff41]/30 font-mono text-[#00ff41] font-bold select-all">
                                {{ auth()->id() }}
                            </code>

                            <button
                                @click="navigator.clipboard.writeText('{{ auth()->id() }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="inline-flex items-center px-4 py-2 bg-transparent border border-[#00ff41]/50 rounded-md font-mono font-bold text-xs text-[#00ff41] uppercase tracking-widest hover:bg-[#00ff41]/10 focus:outline-none focus:ring-2 focus:ring-[#00ff41] focus:ring-offset-2 focus:ring-offset-[#0d0015] transition ease-in-out duration-150">
                                <span x-show="!copied">COPY_ID</span>
                                <span x-show="copied" class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    COPIED!
                                </span>
                            </button>
                        </div>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>