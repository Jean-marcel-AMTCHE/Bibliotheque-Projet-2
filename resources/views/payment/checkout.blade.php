@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Finaliser le paiement</div>
                <div class="card-body">
                    <h2>Total à payer : ${{ number_format($total, 2) }}</h2>
                    
                    <h3>Payer avec PayPal</h3>
                    <form action="{{ route('payment.paypal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $total }}">
                        <button type="submit" class="btn btn-primary">Payer avec PayPal</button>
                    </form>

                    <hr>

                    <h3>Payer avec Stripe</h3>
                    <form action="{{ route('payment.stripe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $total }}">
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ config('stripe.key') }}"
                            data-amount="{{ $total * 100 }}"
                            data-name="Achat de livres"
                            data-description="Paiement pour vos livres"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="auto"
                            data-currency="usd">
                        </script>
                    </form>

                    @if(session('coupon'))
                        <hr>
                        <h3>Coupon appliqué : {{ session('coupon')->code }}</h3>
                        <p>Réduction : ${{ number_format(session('coupon')->discount, 2) }}</p>
                    @endif

                    <hr>
                    <h3>Appliquer un coupon</h3>
                    <form action="{{ route('apply.coupon') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="coupon_code" class="form-control" placeholder="Code du coupon">
                        </div>
                        <button type="submit" class="btn btn-secondary">Appliquer le coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

