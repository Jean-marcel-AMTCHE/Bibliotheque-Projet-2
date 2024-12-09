<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $messages = $user->messages()->latest()->paginate(10);
        return view('user.index', compact('messages'));
    }
}
