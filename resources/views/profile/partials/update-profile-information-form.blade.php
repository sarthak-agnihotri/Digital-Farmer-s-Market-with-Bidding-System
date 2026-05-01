<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <x-input-label for="subscribed_to_product_alerts" :value="__('ui.subscribe_alerts')" />
                <label class="inline-flex items-center gap-2">
                    <input id="subscribed_to_product_alerts" name="subscribed_to_product_alerts" type="checkbox" value="1" {{ old('subscribed_to_product_alerts', $user->subscribed_to_product_alerts) ? 'checked' : '' }} class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" />
                    <span class="text-sm text-gray-600">{{ __('Receive notifications when new products are listed in your preferred categories.') }}</span>
                </label>
                <x-input-error class="mt-2" :messages="$errors->get('subscribed_to_product_alerts')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="preferred_language" :value="__('ui.language')" />
                <select id="preferred_language" name="preferred_language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="en" {{ old('preferred_language', $user->preferred_language) === 'en' ? 'selected' : '' }}>{{ __('ui.english') }}</option>
                    <option value="hi" {{ old('preferred_language', $user->preferred_language) === 'hi' ? 'selected' : '' }}>{{ __('ui.hindi') }}</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('preferred_language')" />
            </div>
        </div>

        <div>
            <x-input-label for="preferred_product_categories" :value="__('ui.preferred_categories')" />
            <select id="preferred_product_categories" name="preferred_product_categories[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @foreach(['Fruits', 'Vegetables', 'Grains'] as $category)
                    <option value="{{ $category }}" {{ in_array($category, old('preferred_product_categories', $user->preferred_product_categories ?? [])) ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Choose categories for alert recommendations.</p>
            <x-input-error class="mt-2" :messages="$errors->get('preferred_product_categories')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
