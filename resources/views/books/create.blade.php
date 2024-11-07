@extends('layouts.app')

@section('title', 'Ajouter un livre')

@section('content')
<div class="container">
    <h1>Ajouter un nouveau livre</h1>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="form">
        @csrf
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="author">Auteur</label>
            <input type="text" id="author" name="author" value="{{ old('author') }}" required>
        </div>

        <div class="form-group">
            <label for="year">Année de publication</label>
            <input type="date" id="year" name="year" value="{{ old('year') }}" required>
        </div>

        <div class="form-group">
            <label for="summary">Résumé</label>
            <textarea id="summary" name="summary" required>{{ old('summary') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Prix</label>
            <input type="text" id="price" name="price" value="{{ old('price') }}" 
                   pattern="\d+(\.\d{2})?" placeholder="0.00" required>
        </div>

        <div class="form-group">
            <label for="image">Image du livre</label>
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
            <img id="image-preview" class="image-preview">
        </div>

        <button type="submit" class="btn">Ajouter le livre</button>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

