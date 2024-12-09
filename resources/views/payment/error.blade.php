@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Erreur de paiement</div>
                <div class="card-body">
                    <h2 class="text-danger">Une erreur s'est produite lors du traitement de votre paiement</h2>
                    <p>Veuillez réessayer ou contacter notre service client si le problème persiste.</p>
                    <a href="{{ route('cart') }}" class="btn btn-primary">Retour au panier</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

