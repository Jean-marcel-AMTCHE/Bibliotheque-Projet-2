@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Détails de la Transaction</h1>
    
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Informations de la Transaction</h5>
                    <p><strong>ID de Transaction:</strong> {{ $transaction->id }}</p>
                    <p><strong>Date:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Montant Total:</strong> {{ number_format($transaction->amount, 2) }} €</p>
                    <p><strong>Méthode de Paiement:</strong> {{ ucfirst($transaction->payment_method) }}</p>
                    <p><strong>Statut:</strong> 
                        @if($transaction->status == 'completed')
                            <span class="badge bg-success">Complété</span>
                        @elseif($transaction->status == 'pending')
                            <span class="badge bg-warning text-dark">En attente</span>
                        @else
                            <span class="badge bg-danger">{{ ucfirst($transaction->status) }}</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Livres Achetés</h5>
                    <ul class="list-group">
                        @foreach($transaction->books as $book)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $book->title }}
                                <span class="badge bg-primary rounded-pill">{{ number_format($book->price, 2) }} €</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            @if($transaction->discount)
                <div class="mt-4">
                    <h5 class="card-title">Remise Appliquée</h5>
                    <p><strong>Code de Remise:</strong> {{ $transaction->discount->code }}</p>
                    <p><strong>Montant de la Remise:</strong> {{ number_format($transaction->discount->amount, 2) }} €</p>
                </div>
            @endif
            
            @if(auth()->user()->isAdmin())
                <div class="mt-4">
                    <h5 class="card-title">Actions Administrateur</h5>
                    @if($transaction->status != 'refunded')
                        <form action="{{ route('transactions.refund', $transaction) }}" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Êtes-vous sûr de vouloir rembourser cette transaction ?')">
                                <i class="fas fa-undo me-1"></i>Rembourser
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="{{ route('payment.history') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Retour à l'historique
        </a>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 15px;
    }
    .btn {
        border-radius: 20px;
        padding: 8px 20px;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.7em;
        border-radius: 10px;
    }
</style>
@endsection

