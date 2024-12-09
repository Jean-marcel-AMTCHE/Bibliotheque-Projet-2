@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nouveautés</h1>
    @foreach($newBooks as $book)
        <div class="book-item">
            <img src="{{ asset('storage/'.$book->cover_image) }}" alt="{{ $book->title }}" style="max-width: 100px;">
            <h3>{{ $book->title }}</h3>
            <p>Auteur: {{ $book->author }}</p>
            <p>{{ Str::limit($book->summary, 100) }}</p>
            <p>Prix: {{ $book->price }}</p>
            @if($book->created_at->diffInDays(now()) <= 10)
                <span class="badge badge-new">Nouveau</span>
            @endif
            <a href="{{ route('books.show', $book->id) }}">Voir détails</a>
            <form action="{{ route('cart.add', $book) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Ajouter au panier</button>
</form>
        </div>
    @endforeach
</div>
@endsection

