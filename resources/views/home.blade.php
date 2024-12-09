@extends('layouts.app')

@section('title', 'Accueil - Bibliothèque')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Bienvenue à la Bibliothèque AJM</h1>

    @auth
        @if(auth()->user()->isAdmin())
            <div class="text-center mb-4">
                <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle me-2"></i>Ajouter un Livre
                </a>
            </div>
        @endif
    @endauth
    <div class="search-section mb-5 p-4 bg-light rounded shadow-sm">
        <h2 class="text-center mb-4">Recherche de livres</h2>
        <form action="{{ route('books.search') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-6 col-lg-3">
                    <input type="text" name="title" class="form-control" placeholder="Titre">
                </div>
                <div class="col-md-6 col-lg-3">
                    <input type="text" name="author" class="form-control" placeholder="Auteur">
                </div>
                <div class="col-md-4 col-lg-2">
                    <input type="number" name="year" class="form-control" placeholder="Année">
                </div>
                <div class="col-md-4 col-lg-2">
                    <input type="number" name="min_price" class="form-control" placeholder="Prix min">
                </div>
                <div class="col-md-4 col-lg-2">
                    <input type="number" name="max_price" class="form-control" placeholder="Prix max">
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-search me-2"></i>Rechercher
                </button>
            </div>
        </form>
    </div>
    <h2 class="text-center mb-4">Livres disponibles</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        @foreach($books as $book)
            <div class="col">
                <div class="card h-100 shadow-sm hover-card">
                <img src="{{ asset('storage/covers/'.$book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text"><small class="text-muted">Auteur: {{ $book->author }}</small></p>
                        <p class="card-text"><small class="text-muted">Année: {{ $book->year }}</small></p>
                        <p class="card-text flex-grow-1">{{ Str::limit($book->summary, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">{{ $book->price }} $</span>
                            <div>
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-info-circle me-1"></i>Détails
                                </a>
                                <form action="{{ route('cart.add', $book->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-cart-plus me-1"></i>Ajouter au panier
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if(isset($promotions) && $promotions->count() > 0)
        <h2 class="text-center mb-4">Livres en promotion</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($promotions as $promo)
                <div class="col">
                    <div class="card h-100 shadow-sm hover-card border-danger">
                        <div class="ribbon ribbon-top-right"><span>Promo</span></div>
                        <img src="{{ asset('storage/covers/'.$promo->cover_image) }}" class="card-img-top" alt="{{ $promo->title }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $promo->title }}</h5>
                            <p class="card-text"><small class="text-muted">Auteur: {{ $promo->author }}</small></p>
                            <p class="card-text"><small class="text-muted">Année: {{ $promo->year }}</small></p>
                            <p class="card-text flex-grow-1">{{ Str::limit($promo->summary, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strike class="text-muted">{{ $promo->original_price }} </strike>
                                    <span class="h5 text-danger ms-2 mb-0">{{ $promo->price }} $</span>
                                </div>
                                <div>
                                    <a href="{{ route('books.show', $promo->id) }}" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-info-circle me-1"></i>Détails
                                    </a>
                                    <form action="{{ route('cart.add', $promo->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-cart-plus me-1"></i>Ajouter au panier
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<style>
    .hover-card {
        transition: transform 0.3s ease-in-out;
    }
    .hover-card:hover {
        transform: translateY(-5px);
    }
    .ribbon {
        width: 150px;
        height: 150px;
        overflow: hidden;
        position: absolute;
    }
    .ribbon::before,
    .ribbon::after {
        position: absolute;
        z-index: -1;
        content: '';
        display: block;
        border: 5px solid #2980b9;
    }
    .ribbon span {
        position: absolute;
        display: block;
        width: 225px;
        padding: 15px 0;
        background-color: #3498db;
        box-shadow: 0 5px 10px rgba(0,0,0,.1);
        color: #fff;
        font: 700 18px/1 'Lato', sans-serif;
        text-shadow: 0 1px 1px rgba(0,0,0,.2);
        text-transform: uppercase;
        text-align: center;
    }
    .ribbon-top-right {
        top: -10px;
        right: -10px;
    }
    .ribbon-top-right::before,
    .ribbon-top-right::after {
        border-top-color: transparent;
        border-right-color: transparent;
    }
    .ribbon-top-right::before {
        top: 0;
        left: 0;
    }
    .ribbon-top-right::after {
        bottom: 0;
        right: 0;
    }
    .ribbon-top-right span {
        left: -25px;
        top: 30px;
        transform: rotate(45deg);
    }
</style>
@endsection

