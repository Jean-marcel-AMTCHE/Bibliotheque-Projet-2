@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Historique des Transactions</h1>
    
    @if($transactions->count() > 0)
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>Méthode de Paiement</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ number_format($transaction->amount, 2) }} $</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ ucfirst($transaction->payment_method) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($transaction->status == 'completed')
                                            <span class="badge bg-success">Complété</span>
                                        @elseif($transaction->status == 'pending')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($transaction->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
    {{ $transactions->links() }}
</div>
    @else
        <div class="text-center">
            <p class="lead">Aucune transaction trouvée.</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary mt-3">
                <i class="fas fa-book me-2"></i>Parcourir les livres
            </a>
        </div>
    @endif
</div>

<style>
    .card {
        border: none;
        border-radius: 15px;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .btn {
        border-radius: 20px;
        padding: 8px 20px;
    }
    .btn-sm {
        padding: 5px 10px;
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

