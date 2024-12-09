<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->isAdmin()) {
            $transactions = Transaction::with('user')->latest()->paginate(20);
        } else {
            $transactions = $user->transactions()->latest()->paginate(20);
        }

        return view('purchase-history', compact('transactions'));
    }
}

