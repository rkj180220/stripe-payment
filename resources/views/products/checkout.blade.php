<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('products.processPayment', [$product]) }}" method="POST" id="subscribe-form">
                        <div class="mb-6">
                            <div class="flex">
                                <div class="flex-1 bg-gray-200 p-4 rounded-md shadow-md">
                                    <div class="text-2xl font-bold">₹{{ $product->price }}</div>
                                    <input id="card-holder-name" type="hidden" name="price"
                                           value="{{ $product->price }}">
                                </div>
                            </div>
                        </div>
                        <label for="card-holder-name">Card Holder Name:{{$user->name}} </label>
                        <input id="card-holder-name" type="hidden"
                               value="{{ $user->name }}" disabled>
                        @csrf
                        <div class="mb-6">
                            <label for="card-element">Credit or debit card</label>
                            <div id="card-element" class="w-full"></div>
                            <div class="error-msg" id="card-errors" role="alert"></div>
                        </div>
                        <div class="stripe-errors"></div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="mb-6 text-center">
                            <button type="button" id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-lg btn-success btn-block">SUBMIT</button>
                        </div>
                    </form>
                    <script src="https://js.stripe.com/v3/"></script>
                    <script>
                        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
                        var elements = stripe.elements();
                        var style = {
                            base: {
                                color: '#32325d',
                                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                fontSmoothing: 'antialiased',
                                fontSize: '16px',
                                '::placeholder': {
                                    color: '#aab7c4'
                                }
                            },
                            invalid: {
                                color: '#fa755a',
                                iconColor: '#fa755a'
                            }
                        };
                        var card = elements.create('card', {hidePostalCode: true, style: style});
                        card.mount('#card-element');
                        console.log(document.getElementById('card-element'));
                        card.addEventListener('change', function(event) {
                            var displayError = document.getElementById('card-errors');
                            if (event.error) {
                                displayError.textContent = event.error.message;
                            } else {
                                displayError.textContent = '';
                            }
                        });
                        const cardHolderName = document.getElementById('card-holder-name');
                        const cardButton = document.getElementById('card-button');
                        const clientSecret = cardButton.dataset.secret;    cardButton.addEventListener('click', async (e) => {
                            console.log("attempting");
                            const { setupIntent, error } = await stripe.confirmCardSetup(
                                clientSecret, {
                                    payment_method: {
                                        card: card,
                                        billing_details: { name: cardHolderName.value }
                                    }
                                }
                            );        if (error) {
                                var errorElement = document.getElementById('card-errors');
                                errorElement.textContent = error.message;
                            }
                            else {
                                paymentMethodHandler(setupIntent.payment_method);
                            }
                        });
                        function paymentMethodHandler(payment_method) {
                            var form = document.getElementById('subscribe-form');
                            var hiddenInput = document.createElement('input');
                            hiddenInput.setAttribute('type', 'hidden');
                            hiddenInput.setAttribute('name', 'payment_method');
                            hiddenInput.setAttribute('value', payment_method);
                            form.appendChild(hiddenInput);
                            form.submit();
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>


