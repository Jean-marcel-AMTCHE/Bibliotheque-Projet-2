@extends('layouts.app')

@section('title', 'Nouveautés')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Nouveautés</h1>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($newBooks as $book)
            <div class="col">
                <div class="card h-100 shadow-sm hover-card">
                    <img src="{{ asset('storage/'.$book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 300px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $book->author }}</h6>
                        <p class="card-text flex-grow-1">{{ Str::limit($book->summary, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">{{ number_format($book->price, 2) }} $</span>
                            @if($book->created_at->diffInDays(now()) <= 10)
                                <span class="badge bg-success">Nouveau</span>
                            @endif
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary">
                                <i class="fas fa-info-circle me-1"></i>Voir détails
                            </a>
                            <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fas fa-cart-plus me-1"></i>Ajouter au panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .btn {
        border-radius: 20px;
        padding: 8px 15px;
    }
    .badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.9em;
        padding: 0.5em 0.7em;
    }
</style>
@endsection

