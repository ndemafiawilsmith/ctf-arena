<section>
    <header>
        <h2 class="text-lg font-medium text-[#00ff41] font-mono">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400 font-mono">
            {{ __("View your account's profile information.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-300 font-mono" />
            <div style="color:white;" class="mt-1 block w-full py-2 px-3 text-gray-100 bg-[#0d0015] border border-[#00ff41]/20 rounded-md font-mono">
                {{ $user->name }}
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300 font-mono" />
            <div style="color:white;" class="mt-1 block w-full py-2 px-3 text-gray-100 bg-[#0d0015] border border-[#00ff41]/20 rounded-md font-mono">
                {{ $user->email }}
            </div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </form>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>