@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Paiement annulé</div>
                <div class="card-body">
                    <h2 class="text-warning">Votre paiement a été annulé</h2>
                    <p>Si vous avez rencontré des problèmes, n'hésitez pas à nous contacter.</p>
                    <a href="{{ route('cart') }}" class="btn btn-primary">Retour au panier</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

