<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 flex flex-col">

    <!-- 🌾 LOGO (TOP, NOT CENTERED) -->
    <div class="w-full flex justify-center pt-6">
        <a href="/" class="inline-flex items-center gap-3 rounded-3xl bg-white/80 backdrop-blur-md px-5 py-3 shadow-sm ring-1 ring-slate-200 hover:ring-emerald-300 transition">
            <span class="text-3xl">🌾</span>
            <span class="text-lg font-semibold text-slate-900">Digital Farmer Market</span>
        </a>
    </div>

    <!-- ✅ CENTER ONLY THIS AREA -->
    <div class="flex-1 flex items-center justify-center px-4">
        {{ $slot }}
    </div>

</div>