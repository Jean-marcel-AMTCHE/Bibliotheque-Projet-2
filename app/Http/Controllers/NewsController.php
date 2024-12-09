<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $newBooks = Book::where('created_at', '>=', now()->subDays(10))
                        ->latest()
                        ->get();

        return view('news.index', compact('newBooks'));
    }
}

