@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Liste des Livres</h1>

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title mb-4">Recherche avancée</h5>
            <form action="{{ route('books.search') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="title" class="form-control" placeholder="Titre">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="author" class="form-control" placeholder="Auteur">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="year" class="form-control" placeholder="Année">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="min_price" class="form-control" placeholder="Prix min">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="max_price" class="form-control" placeholder="Prix max">
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(Auth::check() && Auth::user()->isAdmin())
        <div class="text-end mb-4">
            <a href="{{ route('books.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-2"></i>Ajouter un livre
            </a>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($books as $book)
            <div class="col">
                <div class="card h-100 shadow-sm hover-card">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/'.$book->cover_image) }}" class="card-img-top" alt="Couverture de {{ $book->title }}" style="height: 300px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $book->author }}</h6>
                        <p class="card-text"><small class="text-muted">Année: {{ $book->year }}</small></p>
                        <p class="card-text">{{ Str::limit($book->summary, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">{{ number_format($book->price, 2) }} $</span>
                            @if($book->promotion)
                                <span class="badge bg-danger">En promotion</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-info-circle me-2"></i>Voir détails
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $books->links() }}
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease-in-out;
    }
    .hover-card:hover {
        transform: translateY(-5px);
    }
    .btn {
        border-radius: 25px;
    }
    .badge {
        font-size: 0.8em;
        padding: 0.5em 0.7em;
    }
</style>
@endsection

