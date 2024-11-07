@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="container">
    <h1>Bibliothèque AJM</h1>
    
    <div class="search-section">
        <form action="{{ route('books.search') }}" method="GET" class="search-form">
            <div class="search-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" 
                       placeholder="Rechercher par titre..." 
                       value="{{ request('title') }}">
            </div>

            <div class="search-group">
                <label for="author">Auteur</label>
                <input type="text" id="author" name="author" 
                       placeholder="Rechercher par auteur..." 
                       value="{{ request('author') }}">
            </div>

            <div class="search-group">
                <label for="year">Année</label>
                <select id="year" name="year">
                    <option value="">Toutes les années</option>
                    @for($i = date('Y'); $i >= 1900; $i--)
                        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="search-buttons">
                <button type="submit" class="btn">Rechercher</button>
                <a href="{{ route('home') }}" class="btn btn-reset">Réinitialiser</a>
            </div>
        </form>
    </div>

    <div class="action-buttons">
        <a href="{{ route('books.create') }}" class="btn">Ajouter un livre</a>
    </div>

    @if($books && count($books) > 0)
        <div class="books-grid">
            @foreach($books as $book)
            <div class="book-card">
                @if(isset($book['image']) && $book['image'])
                    <img src="{{ asset('storage/'.$book['image']) }}" alt="{{ $book['title'] }}" class="book-image">
                @else
                    <img src="{{ asset('images/default-book.jpg') }}" alt="Default" class="book-image">
                @endif
                <div class="book-content">
                    <h2>{{ $book['title'] }}</h2>
                    <div class="book-info">
                        <p><span>Auteur:</span> <span>{{ $book['author'] }}</span></p>
                        <p><span>Année:</span> <span>{{ date('Y', strtotime($book['year'])) }}</span></p>
                        <p><span>Prix:</span> <span>{{ $book['price'] }}$</span></p>
                    </div>
                    <div class="book-actions">
                        <a href="{{ route('books.show', $book['id']) }}" class="btn">Détails</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="no-results">
            <p>Aucun livre ne correspond à votre recherche.</p>
        </div>
    @endif
</div>

<style>
.search-section {
    background-color: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.search-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.search-group {
    display: flex;
    flex-direction: column;
}

.search-group label {
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #2c3e50;
}

.search-group input,
.search-group select {
    padding: 0.8rem;
    border: 2px solid #e1e1e1;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.search-group input:focus,
.search-group select:focus {
    border-color: #3498db;
    outline: none;
}

.search-buttons {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
}

.btn-reset {
    background-color: #95a5a6;
}

.btn-reset:hover {
    background-color: #7f8c8d;
}

.no-results {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-top: 2rem;
}

.action-buttons {
    margin: 2rem 0;
}

@media (max-width: 768px) {
    .search-form {
        grid-template-columns: 1fr;
    }
    
    .search-buttons {
        flex-direction: column;
    }
    
    .search-buttons .btn {
        width: 100%;
    }
}
</style>
@endsection

