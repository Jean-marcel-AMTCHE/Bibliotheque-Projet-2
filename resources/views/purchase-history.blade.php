@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Historique des achats</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                @if(auth()->user()->isAdmin())
                    <th>Utilisateur</th>
                @endif
                <th>Montant</th>
                <th>Méthode de paiement</th>
                <th>ID de transaction</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    @if(auth()->user()->isAdmin())
                        <td>{{ $transaction->user->name }}</td>
                    @endif
                    <td>${{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->payment_method }}</td>
                    <td>{{ $transaction->transaction_id }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transactions->links() }}
</div>
@endsection

