<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer',
            'summary' => 'required',
            'price' => 'required|numeric',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'promotion' => 'boolean'
        ]);

        $book = new Book($validatedData);
        $book->promotion = $request->has('promotion');

        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = $imagePath;
        }
 
        $book->save();
 
        return redirect()->route('books.index')->with('success', 'Livre ajouté avec succès');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'summary' => 'required',
            'price' => 'required|numeric|min:0',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'promotion' => 'boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($book->cover_image);
            $imagePath = $request->file('cover_image')->store('covers', 'public');
            $validatedData['cover_image'] = $imagePath;
        }

        $book->update($validated);

        return redirect()->route('books.show', $book)->with('success', 'Livre mis à jour avec succès.');
    }

    public function destroy(Book $book)
    {

        Storage::disk('public')->delete($book->cover_image);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Livre supprimé avec succès.');
    }

    public function search(Request $request)
    {
        $query = Book::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        $books = $query->paginate(10);

        return view('books.index', compact('books'));
    }

    public function deleteBook($id)
   {
       $book = Book::findOrFail($id);
       if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
           Storage::disk('public')->delete($book->cover_image);
       }
       $book->delete();
       return redirect()->route('books.index')->with('success', 'Livre supprimé avec succès');
   }

}



