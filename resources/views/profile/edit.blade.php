@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-[360px_1fr]">

                <!-- Profile Summary -->
                <section class="space-y-6">
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <div class="flex items-center gap-4">
                            <div class="h-16 w-16 rounded-2xl bg-green-100 text-green-700 flex items-center justify-center text-3xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                <p class="mt-2 text-sm">
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4 text-sm text-slate-600">
                            <p><strong>{{ __('Member since:') }}</strong> {{ $memberSince ?? '-' }}</p>
                            <p>
                                <strong>{{ __('Email status:') }}</strong>
                                @if ($user->email_verified_at)
                                    <span class="text-green-600">{{ __('Verified') }}</span>
                                @else
                                    <span class="text-yellow-600">{{ __('Unverified') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        @if($user->isFarmer())
                            <div class="bg-white shadow sm:rounded-lg p-5">
                                <p class="text-sm text-gray-500">{{ __('Your Products') }}</p>
                                <p class="mt-2 text-3xl font-semibold text-green-700">{{ $productCount }}</p>
                                <a href="{{ route('dashboard') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                    {{ __('Manage Products') }}
                                </a>
                            </div>
                        @endif

                        @if($user->isConsumer())
                            <div class="bg-white shadow sm:rounded-lg p-5">
                                <p class="text-sm text-gray-500">{{ __('Your Bids') }}</p>
                                <p class="mt-2 text-3xl font-semibold text-blue-700">{{ $bidCount }}</p>
                                <a href="{{ route('consumer.bids') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                    {{ __('View Bids') }}
                                </a>
                            </div>
                        @endif

                        @if($user->isAdmin())
                            <div class="bg-white shadow sm:rounded-lg p-5">
                                <p class="text-sm text-gray-500">{{ __('Pending Products') }}</p>
                                <p class="mt-2 text-3xl font-semibold text-orange-700">{{ $pendingProducts }}</p>
                                <a href="{{ route('admin.products') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700">
                                    {{ __('Review Products') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Profile Forms -->
                <section class="space-y-6">
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="bg-white shadow sm:rounded-lg p-6">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="bg-white shadow sm:rounded-lg p-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
