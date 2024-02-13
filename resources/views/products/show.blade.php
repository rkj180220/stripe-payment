<div>
    <h3>{{ $product->name }}</h3>
    <p>{{ $product->description }}</p>
    <p>Price: ₹{{ $product->price }}</p>
    <!-- Add Stripe credit card form here -->
</div>

<form action="{{ route('products.show', $product->id) }}" method="post">
    @csrf
    <script src="https://js.stripe.com/v3/"></script>
    <input type="hidden" name="stripeToken" id="stripeToken">
    <button type="submit" class="btn btn-primary" id="submitBtn">Pay Now</button>
</form>

<script>
    var stripe = Stripe('{{ config('services.stripe.key') }}');
    var elements = stripe.elements();

    var card = elements.create('card');
    card.mount('#card-element');

    var form = document.querySelector('form');
    var submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error
                console.log(result.error.message);
            } else {
                // Send the token to your server
                document.getElementById('stripeToken').value = result.token.id;
                form.submit();
            }
        });
    });
</script>

