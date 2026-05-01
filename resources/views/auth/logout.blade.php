<x-guest-layout>
    <div class="mx-auto w-full max-w-4xl translate-y-9 rounded-[2rem] bg-white/80 backdrop-blur-md p-8 shadow-2xl ring-1 ring-slate-200">

        <!-- HEADER -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center rounded-full bg-red-100 px-4 py-2 text-2xl shadow-sm mb-4">
                ⚠️
            </div>
            <h2 class="text-3xl font-bold text-slate-900 mb-3">{{ __('Confirm Logout') }}</h2>
            <p class="text-slate-600 max-w-xl mx-auto">
                {{ __('Are you sure you want to end your session? You can return to the dashboard if you change your mind.') }}
            </p>
        </div>

        <!-- ✅ FIXED GRID (EQUAL COLUMNS) -->
        <div class="grid gap-6 lg:grid-cols-2">

            <!-- LEFT -->
            <div class="space-y-6">

                <!-- USER INFO -->
                <div class="rounded-3xl bg-emerald-50/70 border border-emerald-100 p-6 shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-600 text-2xl font-bold text-white shadow-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">{{ __('Logged in as') }}</p>
                            <p class="text-lg font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- ROLE -->
                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-6 shadow text-center">
                    @if(auth()->user()->isAdmin())
                        <span class="inline-flex rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                            👨‍💼 Admin
                        </span>
                    @elseif(auth()->user()->isFarmer())
                        <span class="inline-flex rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                            🌾 Farmer
                        </span>
                    @elseif(auth()->user()->isConsumer())
                        <span class="inline-flex rounded-full bg-purple-100 px-4 py-2 text-sm font-semibold text-purple-700">
                            🛒 Consumer
                        </span>
                    @endif
                </div>

                <!-- LOGOUT DETAILS -->
                <div class="rounded-3xl bg-amber-50 border border-amber-200 p-6 shadow">
                    <p class="font-semibold text-amber-900 mb-3">{{ __('What will happen?') }}</p>
                    <ul class="space-y-2 text-sm text-amber-800">
                        <li>✓ {{ __('Your session will end immediately') }}</li>
                        <li>✓ {{ __('All active sessions will be terminated') }}</li>
                        <li>✓ {{ __('Session data will be securely cleared') }}</li>
                        <li>✓ {{ __('You will need to login again') }}</li>
                    </ul>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="space-y-6 flex flex-col justify-between">

                <!-- SESSION INFO -->
                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-6 shadow">
                    <p class="text-sm font-semibold text-slate-700 mb-4">Session Information</p>

                    <div class="space-y-3 text-sm text-slate-600">
                        <div class="flex justify-between">
                            <span>Session:</span>
                            <span class="text-xs text-slate-400">Hidden for security</span>
                        </div>

                        <div class="flex justify-between">
                            <span>IP Address:</span>
                            <span class="font-mono text-xs text-slate-500">
                                {{ request()->ip() }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span>Last Activity:</span>
                            <span class="text-xs text-slate-500">
                                {{ now()->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- BUTTONS (FIXED ALIGNMENT) -->
                <div class="flex gap-4 w-full">
                    
                    <a href="{{ route('dashboard') }}"
                       class="flex-1 rounded-2xl border border-slate-300 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:scale-105">
                        {{ __('← Go Back') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 hover:scale-105">
                            {{ __('Yes, Logout 🚪') }}
                        </button>
                    </form>

                </div>

                <!-- FOOTER -->
                <p class="text-center text-xs text-slate-500">
                    {{ __('Your privacy is important to us. All session data will be securely cleared.') }}
                </p>

            </div>
        </div>
    </div>
</x-guest-layout>