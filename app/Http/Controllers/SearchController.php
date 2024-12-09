<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Recherche par titre
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        // Recherche par auteur
        if ($request->has('author')) {
            $query->where('author', 'like', '%' . $request->input('author') . '%');
        }

        // Recherche par année de publication
        if ($request->has('year')) {
            $query->where('year', $request->input('year'));
        }

        // Recherche par plage de prix
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
        } elseif ($request->has('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        } elseif ($request->has('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $results = $query->paginate(10); // Pagination des résultats

        return view('search_results', ['results' => $results]);
    }
}

