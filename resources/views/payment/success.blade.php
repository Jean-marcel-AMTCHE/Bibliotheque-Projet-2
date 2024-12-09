@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Paiement réussi</div>
                <div class="card-body">
                    <h2 class="text-success">Votre paiement a été traité avec succès!</h2>
                    <p>Merci pour votre achat. Votre commande sera traitée sous peu.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

