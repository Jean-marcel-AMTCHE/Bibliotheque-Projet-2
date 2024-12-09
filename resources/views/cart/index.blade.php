@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Votre Panier</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if($cartItems->count() > 0)
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Livre</th>
                                <th>Prix</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/'.$item->book->cover_image) }}" alt="{{ $item->book->title }}" class="img-thumbnail me-3" style="width: 50px;">
                                            {{ $item->book->title }}
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->book->price, 1) }} $</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ number_format($item->quantity * $item->book->price, 1) }} $</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-primary">
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td colspan="2"><strong>{{ number_format($total, 1) }} $</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Continuer les achats
                    </a>
                    <form action="{{ route('payment.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-credit-card me-2"></i>Procéder au paiement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="text-center">
            <p class="lead">Votre panier est vide.</p>
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
</style>
@endsection

