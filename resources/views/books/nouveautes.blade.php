@extends('layouts.app')

@section('title', 'Nouveautés')

@section('content')
<div class="container">
    <div class="nouveautes-header">
        <h1>Nouveautés</h1>
        <p class="subtitle">Les livres ajoutés ces 10 derniers jours</p>
    </div>

    @if(count($books) > 0)
        <div class="books-grid">
            @foreach($books as $book)
            <div class="book-card">
                <div class="book-image-wrapper">
                    @if(isset($book['image']) && $book['image'])
                        <img src="{{ asset('storage/'.$book['image']) }}" alt="{{ $book['title'] }}" class="book-image">
                    @else
                        <img src="{{ asset('images/default-book.jpg') }}" alt="Default" class="book-image">
                    @endif
                </div>
                <div class="book-content">
                    <h2>{{ $book['title'] }}</h2>
                    <div class="book-info">
                        <p><span>Auteur:</span> <span>{{ $book['author'] }}</span></p>
                        <p><span>Année:</span> <span>{{ date('Y', strtotime($book['year'])) }}</span></p>
                        <p><span>Prix:</span> <span>{{ $book['price'] }}$</span></p>
                        <p><span>Ajouté le:</span> <span>{{ $book['created_at'] }}</span></p>
                    </div>
                    <div class="book-actions">
                        <a href="{{ route('books.show', $book['id']) }}" class="btn">Détails</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="no-books">
            <p>Aucun nouveau livre n'a été ajouté ces 10 derniers jours.</p>
        </div>
    @endif
</div>

<style>
.nouveautes-header {
    text-align: center;
    margin-bottom: 3rem;
}

.nouveautes-header h1 {
    color: #2c3e50;
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.subtitle {
    color: #666;
    font-size: 1.1rem;
}

.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.book-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.book-card:hover {
    transform: translateY(-5px);
}

.book-image-wrapper {
    height: 200px;
    overflow: hidden;
}

.book-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.book-card:hover .book-image {
    transform: scale(1.05);
}

.book-content {
    padding: 1.5rem;
}

.book-content h2 {
    color: #2c3e50;
    font-size: 1.3rem;
    margin-bottom: 1rem;
    height: 2.6rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.book-info {
    display: grid;
    gap: 0.5rem;
}

.book-info p {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.book-actions {
    margin-top: 1.5rem;
    text-align: right;
}

.no-books {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.no-books p {
    color: #666;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .books-grid {
        grid-template-columns: 1fr;
    }
    
    .nouveautes-header h1 {
        font-size: 2rem;
    }
}
</style>
@endsection

