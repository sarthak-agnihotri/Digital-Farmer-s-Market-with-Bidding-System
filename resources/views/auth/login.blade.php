<x-guest-layout>
    <div class="min-h-screen bg-slate-100 flex items-center justify-center px-6 py-10">
        
        <div class="w-full max-w-[1200px] overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-black/5">
            
            <div class="grid lg:grid-cols-2">

                <!-- LEFT PANEL -->
                <div class="hidden lg:flex flex-col justify-between bg-[radial-gradient(circle_at_top_right,_rgba(4,120,87,0.95),_rgba(16,185,129,0.85))] px-16 py-16 text-white">
                    
                    <div class="space-y-6">
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-100">
                            Modern Farmer Marketplace
                        </span>

                        <div class="space-y-4">
                            <h2 class="text-4xl font-bold leading-tight">
                                A professional website login
                            </h2>
                            <p class="max-w-md text-sm text-emerald-100/85">
                                Securely access your dashboard, manage products, and stay connected with buyers from a polished marketplace website.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4 rounded-2xl bg-white/10 p-5">
                            <span class="text-2xl">🌱</span>
                            <div>
                                <p class="font-semibold">Fresh product control</p>
                                <p class="text-sm text-emerald-100/75">
                                    Manage listings easily from your dashboard.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 rounded-2xl bg-white/10 p-5">
                            <span class="text-2xl">🛒</span>
                            <div>
                                <p class="font-semibold">Professional storefront</p>
                                <p class="text-sm text-emerald-100/75">
                                    Deliver a smooth buying experience.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="text-sm text-emerald-100/80">
                        Website-first design optimized for desktop experience.
                    </div>
                </div>

                <!-- RIGHT PANEL -->
                <div class="px-10 py-12 sm:px-14 sm:py-16 flex items-center">
                    
                    <div class="w-full max-w-md mx-auto">

                        <div class="mb-10">
                            <span class="inline-flex rounded-full bg-emerald-100 px-4 py-1 text-sm font-semibold text-emerald-800">
                                Sign in securely
                            </span>

                            <h1 class="mt-6 text-4xl font-bold text-slate-900">
                                Welcome back.
                            </h1>

                            <p class="mt-3 text-base text-slate-600">
                                Log in to manage your marketplace and orders.
                            </p>
                        </div>

                        <x-auth-session-status 
                            class="mb-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800" 
                            :status="session('status')" 
                        />

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- EMAIL -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-emerald-400 focus:outline-none">
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                            </div>

                            <!-- PASSWORD -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Password</label>
                                <input type="password" name="password" required
                                    class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-emerald-400 focus:outline-none">
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                            </div>

                            <!-- OPTIONS -->
                            <div class="flex items-center justify-between text-sm text-slate-600">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                                    Remember me
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-emerald-600 font-semibold hover:underline">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- BUTTON -->
                            <button type="submit"
                                class="w-full rounded-xl bg-emerald-700 py-3 text-white font-semibold hover:bg-emerald-800 transition shadow-lg shadow-emerald-500/20">
                                Log in
                            </button>
                        </form>

                        <p class="mt-8 text-center text-sm text-slate-600">
                            Don’t have an account?
                            <a href="{{ route('register') }}" class="text-emerald-700 font-semibold hover:underline">
                                Create one now
                            </a>
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>