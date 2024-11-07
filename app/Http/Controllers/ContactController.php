<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        if (!Storage::exists('messages.json')) {
            Storage::put('messages.json', json_encode([]));
        }

        $messages = json_decode(Storage::get('messages.json'), true) ?? [];

        $messages[] = [
            'id' => count($messages) + 1,
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => now()->format('Y-m-d H:i:s')
        ];

        Storage::put('messages.json', json_encode($messages));

        return redirect()->route('contact')->with('success', 'Message envoyé avec succès');
    }
}