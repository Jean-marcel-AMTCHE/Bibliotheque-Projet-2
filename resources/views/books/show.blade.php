@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/'.$book->cover_image) }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="{{ $book->title }}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="card-title mb-3">{{ $book->title }}</h1>
                            <h5 class="card-subtitle mb-3 text-muted">par {{ $book->author }}</h5>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="card-text"><strong>Année de publication:</strong> {{ $book->year }}</p>
                                <p class="card-text">
                                    @if($book->promotion)
                                        <span class="text-decoration-line-through text-muted me-2">{{ number_format($book->original_price, 2) }} $</span>
                                        <span class="text-danger h4">{{ number_format($book->price, 2) }} $</span>
                                        <span class="badge bg-danger ms-2">Promotion</span>
                                    @else
                                        <span class="text-primary h4">{{ number_format($book->price, 2) }} $</span>
                                    @endif
                                </p>
                            </div>
                            <hr>
                            <h5 class="card-title mt-4 mb-3">Résumé</h5>
                            <p class="card-text">{{ $book->summary }}</p>
                            
                            <div class="mt-4">
                                @if(Auth::check() && Auth::user()->isAdmin())
                                    <a href="{{ route('books.edit', $book) }}" class="btn btn-warning me-2 mb-2">
                                        <i class="fas fa-edit me-1"></i>Modifier
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger me-2 mb-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                                            <i class="fas fa-trash-alt me-1"></i>Supprimer
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('cart.add', $book) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success me-2 mb-2">
                                        <i class="fas fa-cart-plus me-1"></i>Ajouter au panier
                                    </button>
                                </form>
                                
                                <a href="{{ route('books.index') }}" class="btn btn-secondary mb-2">
                                    <i class="fas fa-arrow-left me-1"></i>Retour à la liste
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    .btn {
        border-radius: 20px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .badge {
        font-size: 0.8em;
        padding: 0.5em 0.7em;
    }
</style>
@endsection

