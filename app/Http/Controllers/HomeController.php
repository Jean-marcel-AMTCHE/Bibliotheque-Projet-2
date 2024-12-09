<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
       {
           $books = Book::all();
           $promotions = Book::where('promotion', true)->get();
           return view('home', compact('books', 'promotions'));
       }
       public function search(Request $request)
{
    $query = Book::query();

    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->input('title') . '%');
    }

    if ($request->filled('author')) {
        $query->where('author', 'like', '%' . $request->input('author') . '%');
    }

    if ($request->filled('year')) {
        $query->where('year', $request->input('year'));
    }

    if ($request->filled('min_price') && $request->filled('max_price')) {
        $query->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
    }

    $books = $query->get();

    return view('search_results', compact('books'));
}
}
