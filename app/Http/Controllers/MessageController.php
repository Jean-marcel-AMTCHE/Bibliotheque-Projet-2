<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function index()
    {
        if (!Storage::exists('messages.json')) {
            Storage::put('messages.json', json_encode([]));
        }
        
        $messages = json_decode(Storage::get('messages.json'), true) ?? [];
        return view('messages.index', compact('messages'));
    }
}