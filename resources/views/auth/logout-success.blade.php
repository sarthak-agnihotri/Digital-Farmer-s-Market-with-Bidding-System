<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Successfully Logged Out') }} - {{ __('Farmer Market') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-green-100 via-emerald-200 to-lime-100 min-h-screen">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">

            <!-- Success Container -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 border border-green-200">

                <!-- Success Animation -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-6 animate-bounce">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Message -->
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-3">
                    {{ __('Successfully Logged Out') }}
                </h2>

                <p class="text-center text-gray-600 mb-8 leading-relaxed">
                    {{ __('Your session has ended securely. All your data has been cleared and you have been logged out of all devices.') }}
                </p>

                <!-- Session Terminated Info -->
                <div class="bg-green-50 border border-green-300 rounded-lg p-4 mb-8">
                    <div class="flex gap-3">
                        <span class="text-2xl">✓</span>
                        <div>
                            <p class="font-semibold text-green-800 mb-2">{{ __('Session Terminated') }}</p>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>✓ {{ __('All cookies cleared') }}</li>
                                <li>✓ {{ __('Session data removed') }}</li>
                                <li>✓ {{ __('CSRF tokens regenerated') }}</li>
                                <li>✓ {{ __('You are now a guest') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">

                    <!-- Login Button -->
                    <a href="{{ route('login') }}"
                       class="px-4 py-3 rounded-lg bg-green-500 text-white font-semibold hover:bg-green-600 transition duration-200 text-center transform hover:scale-105 shadow-lg">
                        🔐 {{ __('Log Back In') }}
                    </a>

                    <!-- Home Button -->
                    <a href="{{ route('products.index') }}"
                       class="px-4 py-3 rounded-lg border-2 border-green-300 text-green-700 font-semibold hover:bg-green-50 transition duration-200 text-center">
                        🌾 {{ __('Browse Products') }}
                    </a>

                </div>

                <!-- Footer -->
                <p class="text-center text-xs text-gray-500 mt-8 border-t border-gray-200 pt-6">
                    {{ __('Thank you for using Farmer Market! 👋') }}
                </p>

            </div>

            <!-- Security Note -->
            <div class="mt-8 text-center text-sm text-gray-700 bg-white/50 backdrop-blur rounded-lg p-4">
                <p>🔒 <span class="font-semibold">{{ __('Security Tip:') }}</span> {{ __('Always logout when using shared devices.') }}</p>
            </div>

        </div>
    </div>

</body>
</html>
