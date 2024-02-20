<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div>
                        <h3>{{ $product->name }}</h3>
                        <p>{{ $product->description }}</p>
                        <p>Price: ₹{{ $product->price }}</p>
                        <!-- Add Stripe credit card form here -->
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>



<form action="{{ route('products.processPayment', $product->id) }}" method="post" id="payment-form" class="max-w-md mx-auto">
    @csrf
    <div id="card-element" class="bg-white border rounded p-4 mb-4"></div>

    <!-- Used to display form errors -->
    <div id="card-errors" role="alert" class="text-red-600"></div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Pay Now</button>
</form>


<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();

    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    const cardErrors = document.getElementById('card-errors');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const { token, error } = await stripe.createToken(cardElement);

        if (error) {
            // Display error to the user
            cardErrors.textContent = error.message;
        } else {
            // Add the token to the form and submit
            const tokenInput = document.createElement('input');
            tokenInput.setAttribute('type', 'hidden');
            tokenInput.setAttribute('name', 'stripeToken');
            tokenInput.setAttribute('value', token.id);
            form.appendChild(tokenInput);
            form.submit();
        }
    });
</script>




