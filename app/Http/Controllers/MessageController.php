<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->paginate(10);
        return view('messages.index', compact('messages'));
    }

    public function markAsRead(Message $message)
   {
       $message->read = true;
       $message->save();
       return redirect()->back()->with('success', 'Message marqué comme lu');
   }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('messages.index')->with('success', 'Message supprimé avec succès.');
    }
}

