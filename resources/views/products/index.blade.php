@foreach($products as $product)
    <div>
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->description }}</p>
        <p>Price: ₹{{ $product->price }}</p>
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Buy Now</a>
    </div>
@endforeach
