@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif


<h3>Filter Products</h3>

<form method="GET" action="{{ route('products.index') }}">
    
    <label>Category:</label>
    <select name="category">
        <option value="">-- Select Category --</option>
        <option value="Fruits" {{ request('category') == 'Fruits' ? 'selected' : '' }}>Fruits</option>
        <option value="Vegetables" {{ request('category') == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
        <option value="Grains" {{ request('category') == 'Grains' ? 'selected' : '' }}>Grains</option>
    </select>

    <label>Max Price:</label>
    <input type="number" name="price" placeholder="Max Price" value="{{ request('price') }}">

    <button type="submit">Filter</button>

</form>

<hr>

<h2>All Products</h2>

@forelse($products as $product)

<div style="border:1px solid black; padding:10px; margin:10px;">

    <p><strong>Name:</strong> {{ $product->name }}</p>
    <p><strong>Category:</strong> {{ $product->category }}</p>
    <p><strong>Price:</strong> ₹{{ $product->price }}</p>
    <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
    <p><strong>Is Bidding:</strong> {{ $product->is_bidding ? 'Yes' : 'No' }}</p>

    <!--  Highest Bid -->
    <p><strong>Highest Bid:</strong> 
        {{ $product->bids->max('bid_amount') ?? 'No bids yet' }}
    </p>

    <!--  Bidding Status -->
    @if($product->bidding_end_time)
        <p>
            <strong>Status:</strong>
            {{ now()->greaterThan($product->bidding_end_time) ? 'Closed' : 'Open' }}
        </p>
    @endif

    <!--  Bidding Form -->
    @if($product->is_bidding && (!$product->bidding_end_time || now()->lessThan($product->bidding_end_time)))
        <form method="POST" action="{{ route('bids.store') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="number" name="bid_amount" placeholder="Enter your bid" required>
            <button type="submit">Place Bid</button>
        </form>
    @endif

    <!--  Winner Display -->
    @php
        $highestBid = $product->bids->sortByDesc('bid_amount')->first();
    @endphp

    @if($product->bidding_end_time && now()->greaterThan($product->bidding_end_time))
        <p style="color:green;">
            <strong>Winner:</strong> 
            {{ $highestBid && $highestBid->user ? $highestBid->user->name : 'No bids' }}
        </p>
    @endif

</div>

@empty
    <p style="color: red;">No products found.</p>
@endforelse