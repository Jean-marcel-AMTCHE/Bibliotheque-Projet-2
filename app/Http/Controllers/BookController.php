<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    private function getBooks()
    {
        if (!Storage::exists('books.json')) {
            Storage::put('books.json', json_encode(['books' => []]));
            return [];
        }
        
        $jsonContent = Storage::get('books.json');
        $data = json_decode($jsonContent, true);
        return $data['books'] ?? [];
    }

    private function saveBooks($books)
    {
        Storage::put('books.json', json_encode(['books' => $books]));
    }

    public function index()
    {
        $books = $this->getBooks();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|date',
            'summary' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{2})?$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $books = $this->getBooks();
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
        }

        $newBook = [
            'id' => count($books) + 1,
            'title' => $request->title,
            'author' => $request->author,
            'year' => $request->year,
            'summary' => $request->summary,
            'price' => $request->price,
            'image' => $imagePath,
            'created_at' => now()->format('Y-m-d'),
            'updated_at' => now()->format('Y-m-d')
        ];

        $books[] = $newBook;
        $this->saveBooks($books);

        return redirect()->route('home')->with('success', 'Livre ajouté avec succès');
    }

    public function show($id)
    {
        $books = $this->getBooks();
        $book = collect($books)->firstWhere('id', (int)$id);
        
        if (!$book) {
            abort(404);
        }

        return view('books.show', compact('book'));
    }

    public function destroy($id)
    {
        $books = $this->getBooks();
        $book = collect($books)->firstWhere('id', (int)$id);
        
        if ($book && isset($book['image']) && $book['image']) {
            Storage::disk('public')->delete($book['image']);
        }
        
        $books = array_filter($books, function($book) use ($id) {
            return $book['id'] !== (int)$id;
        });
        
        $this->saveBooks(array_values($books));
        
        return redirect()->route('home')->with('success', 'Livre supprimé avec succès');
    }

    public function search(Request $request)
    {
        $books = $this->getBooks();
        
        if ($request->filled('title')) {
            $books = array_filter($books, function($book) use ($request) {
                return stripos($book['title'], $request->title) !== false;
            });
        }

        if ($request->filled('author')) {
            $books = array_filter($books, function($book) use ($request) {
                return stripos($book['author'], $request->author) !== false;
            });
        }

        if ($request->filled('year')) {
            $books = array_filter($books, function($book) use ($request) {
                return date('Y', strtotime($book['year'])) == $request->year;
            });
        }

        return view('books.index', [
            'books' => array_values($books)
        ]);
    }

    public function nouveautes()
    {
        $books = $this->getBooks();
        $recentBooks = array_filter($books, function($book) {
            $created = \Carbon\Carbon::parse($book['created_at']);
            return $created->diffInDays(now()) <= 10;
        });

        return view('books.nouveautes', ['books' => $recentBooks]);
    }
}

