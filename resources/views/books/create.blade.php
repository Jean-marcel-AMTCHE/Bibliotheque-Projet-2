@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h1 class="mb-0">Ajouter un nouveau livre</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Auteur</label>
                            <input type="text" class="form-control" id="author" name="author" required value="{{ old('author') }}">
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Année de publication</label>
                            <input type="number" class="form-control" id="year" name="year" required value="{{ old('year') }}">
                        </div>
                        <div class="mb-3">
                            <label for="summary" class="form-label">Résumé</label>
                            <textarea class="form-control" id="summary" name="summary" rows="4" required>{{ old('summary') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Prix</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required value="{{ old('price') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Image de couverture</label>
                            <input type="file" class="form-control" id="cover_image" name="cover_image">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="promotion" name="promotion" value="1" {{ old('promotion') ? 'checked' : '' }}>
                            <label class="form-check-label" for="promotion">En promotion</label>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>Ajouter le livre
                            </button>
                        </div>
                    </form>
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
    .card-header {
        background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
    }
    .btn-primary {
        background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(to right, #5a0fb0 0%, #1e63d6 100%);
    }
    .btn-secondary {
        background: linear-gradient(to right, #808080 0%, #606060 100%);
        border: none;
    }
    .btn-secondary:hover {
        background: linear-gradient(to right, #707070 0%, #505050 100%);
    }
    .form-control:focus, .form-check-input:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 0.2rem rgba(37, 117, 252, 0.25);
    }
</style>
@endsection