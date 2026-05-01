@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">
                    {{ __('🎉 Welcome to Digital Farmer Market!') }}
                </h1>
                <p class="text-xl text-green-100 mb-6">
                    {{ __('Let\'s get you started on your fresh produce journey') }}
                </p>
                <div class="bg-white/10 backdrop-blur rounded-lg p-4 inline-block">
                    <p class="text-lg">
                        👋 {{ __('Hi') }} <strong>{{ auth()->user()->name }}</strong>!
                        {{ __('You\'re logged in as a') }} <strong>{{ ucfirst(auth()->user()->role) }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ __('ui.getting_started') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('Track setup progress and finish your first key actions.') }}</p>
                </div>
                <div class="text-right">
                    <span class="text-sm font-semibold text-green-600">{{ $progress }}% Complete</span>
                </div>
            </div>
            <div class="mt-5 h-3 w-full overflow-hidden rounded-full bg-slate-200">
                <div class="h-full rounded-full bg-green-500 transition-all duration-500" style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <!-- Getting Started Steps -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    {{ __('🚀 Your Quick Start Guide') }}

            <div class="space-y-6">
                @foreach($steps as $step)
                    <div class="flex items-start space-x-4 p-6 rounded-xl border-l-4 {{ $step['complete'] ? 'bg-emerald-50 border-emerald-500' : 'bg-slate-50 border-slate-300' }}">
                        <div class="bg-white p-3 rounded-full shadow-sm">
                            <span class="text-2xl">{{ $step['complete'] ? '✅' : '🚀' }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $step['title'] }}</h3>
                            <p class="text-gray-600 mb-3">{{ $step['description'] }}</p>
                            <div class="text-sm font-medium {{ $step['complete'] ? 'text-green-700' : 'text-slate-500' }}">
                                {{ $step['complete'] ? __('Completed') : __('Pending') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Platform Benefits -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    {{ __('🌟 Why Choose Our Platform?') }}

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl">
                    <div class="text-4xl mb-4">🌱</div>
                    <h3 class="font-semibold text-gray-800 mb-2">{{ __('Fresh & Local') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Direct from farm to table') }}</p>
                </div>

                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="font-semibold text-gray-800 mb-2">{{ __('Fair Pricing') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Competitive bidding system') }}</p>
                </div>

                <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl">
                    <div class="text-4xl mb-4">🤝</div>
                    <h3 class="font-semibold text-gray-800 mb-2">{{ __('Community') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Support local farmers') }}</p>
                </div>
            </div>
        </div>

        <!-- Complete Setup Button -->
        <div class="text-center">
            <form method="POST" action="{{ route('getting-started.complete') }}">
                @csrf
                <button type="submit"
                        class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-12 py-4 rounded-full font-bold text-xl hover:from-green-700 hover:to-emerald-700 transition transform hover:scale-105 shadow-2xl">
                    {{ __('🚀 I\'m Ready to Start!') }}
                {{ __('This will take you to your personalized dashboard') }}
            </p>
        </div>
    </div>
</div>
@endsection