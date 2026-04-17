<h2>Add Product</h2>
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <label>Product Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Category:</label><br>
    <input type="text" name="category" required><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" required><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" required><br><br>

    <label>
        <input type="checkbox" name="is_bidding"> Enable Bidding
    </label><br><br>

    <label>Buy Now Price:</label><br>
    <input type="number" step="0.01" name="buy_now_price"><br><br>

    <label>Bidding End Time:</label><br>
    <input type="datetime-local" name="bidding_end_time"><br><br>

    <button type="submit">Add Product</button>
</form>