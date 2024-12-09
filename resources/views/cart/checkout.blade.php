@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Finalisation de l'achat</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Résumé de votre panier</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Livre</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->book->title }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->book->price, 2) }} €</td>
                                <td>{{ number_format($item->book->price * $item->quantity, 2) }} €</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Détails du paiement</div>
                <div class="card-body">
                @if(isset($subtotal))
                <p><strong>Sous-total :</strong> {{ number_format($subtotal, 2) }} $</p>
            @endif
            @if(isset($taxes))
                <p><strong>Taxes :</strong> {{ number_format($taxes, 2) }} $</p>
            @endif
            @if(isset($discounts))
                <p><strong>Remises :</strong> -{{ number_format($discounts, 2) }} $</p>
            @endif
            @if(isset($total))
                <h4><strong>Total :</strong> {{ number_format($total, 2) }} $</h4>
            @endif

                    <hr>

                    <h5 class="mb-3">Choisissez votre méthode de paiement</h5>

                    <div class="mb-3">
                        <button id="paypal-button" class="btn btn-primary btn-block">Payer avec PayPal</button>
                    </div>

                    <div class="mb-3">
                        <button id="stripe-button" class="btn btn-info btn-block">Payer avec Stripe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Configuration PayPal
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '{{ $total }}'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Gérer la confirmation du paiement
                window.location.href = '{{ route("payment.success") }}';
            });
        }
    }).render('#paypal-button');

    // Configuration Stripe
    var stripe = Stripe('{{ env("STRIPE_KEY") }}');
    var elements = stripe.elements();
    var card = elements.create('card');

    document.getElementById('stripe-button').addEventListener('click', function(e) {
    e.preventDefault();
    stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Gérer les erreurs
            console.error(result.error.message);
        } else {
            // Créer un formulaire caché et le soumettre
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("payment.checkout") }}';

            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            var tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = 'stripeToken';
            tokenInput.value = result.token.id;
            form.appendChild(tokenInput);

            var amountInput = document.createElement('input');
            amountInput.type = 'hidden';
            amountInput.name = 'amount';
            amountInput.value = '{{ $total * 100 }}';
            form.appendChild(amountInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
@endsection

