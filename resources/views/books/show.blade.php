@extends('layouts.app')

@section('title', $book['title'])

@section('content')
<div class="container">
    <div class="book-details">
        <div class="book-header">
            <h1>{{ $book['title'] }}</h1>
            <div class="book-actions">
                <form action="{{ route('books.destroy', $book['id']) }}" method="POST" class="inline-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                        Supprimer
                    </button>
                </form>
                <a href="{{ route('home') }}" class="btn">Retour</a>
            </div>
        </div>

        <div class="book-content">
            <div class="book-image-container">
                @if(isset($book['image']) && $book['image'])
                    <img src="{{ asset('storage/'.$book['image']) }}" alt="{{ $book['title'] }}" class="book-image">
                @else
                    <img src="{{ asset('images/default-book.jpg') }}" alt="Default" class="book-image">
                @endif
            </div>

            <div class="book-info">
                <div class="info-group">
                    <p><strong>Auteur:</strong> {{ $book['author'] }}</p>
                    <p><strong>Année de publication:</strong> {{ date('Y', strtotime($book['year'])) }}</p>
                    <p><strong>Prix:</strong> {{ $book['price'] }}$</p>
                    <p><strong>Date d'ajout:</strong> {{ $book['created_at'] }}</p>
                    <p><strong>Dernière modification:</strong> {{ $book['updated_at'] }}</p>
                </div>
                
                <div class="book-summary">
                    <h2>Résumé</h2>
                    <p>{{ $book['summary'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.book-details {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.book-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #eee;
}

.book-header h1 {
    color: #2c3e50;
    font-size: 2rem;
    margin: 0;
}

.book-content {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
}

.book-image-container {
    width: 100%;
}

.book-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.book-info {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.info-group p {
    margin: 0.5rem 0;
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.book-summary {
    padding-top: 1rem;
}

.book-summary h2 {
    color: #2c3e50;
    margin-bottom: 1rem;
}

.inline-form {
    display: inline-block;
}

.book-actions {
    display: flex;
    gap: 1rem;
}

@media (max-width: 768px) {
    .book-content {
        grid-template-columns: 1fr;
    }
    
    .book-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .book-actions {
        justify-content: center;
    }
}
</style>
@endsection

