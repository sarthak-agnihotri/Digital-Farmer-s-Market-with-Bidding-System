@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">
    <div class="bg-white shadow sm:rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">{{ __('ui.notifications') }}</h1>
                <p class="text-sm text-gray-500">{{ __('ui.new_product_alert') }}</p>
            </div>
            <a href="{{ route('notifications.markAllAsRead') }}" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700">
                {{ __('ui.mark_all_read') }}
            </a>
        </div>

        @if($notifications->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-slate-500">
                No notifications yet.
            </div>
        @else
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="rounded-3xl border {{ $notification->read_at ? 'border-slate-200 bg-white' : 'border-green-200 bg-emerald-50' }} p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $notification->data['title'] ?? __('ui.new_product_alert') }}</h3>
                                <p class="text-sm text-slate-600">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            @if(! $notification->read_at)
                                <span class="rounded-full bg-green-600 px-3 py-1 text-xs font-semibold text-white">New</span>
                            @endif
                        </div>
                        <div class="mt-3 text-sm text-slate-700">
                            <p>{{ __('ui.category') }}: {{ $notification->data['category'] ?? '-' }}</p>
                            <p>{{ __('ui.price') }}: ₹{{ $notification->data['price'] ?? '-' }}</p>
                        </div>
                        <a href="{{ route('products.show', $notification->data['product_id'] ?? '#') }}" class="mt-3 inline-flex text-green-600 hover:underline text-sm">View Product</a>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
