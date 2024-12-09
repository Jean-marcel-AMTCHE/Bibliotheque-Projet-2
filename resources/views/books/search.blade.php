<form action="{{ route('books.search') }}" method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            <input type="text" name="title" class="form-control" placeholder="Titre" value="{{ request('title') }}">
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" name="author" class="form-control" placeholder="Auteur" value="{{ request('author') }}">
        </div>
        <div class="col-md-2 mb-3">
            <input type="number" name="year" class="form-control" placeholder="Année" value="{{ request('year') }}">
        </div>
        <div class="col-md-2 mb-3">
            <input type="number" name="min_price" class="form-control" placeholder="Prix min" value="{{ request('min_price') }}">
        </div>
        <div class="col-md-2 mb-3">
            <input type="number" name="max_price" class="form-control" placeholder="Prix max" value="{{ request('max_price') }}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Rechercher</button>
</form>

