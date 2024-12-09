<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function show(Transaction $transaction)
{
    return view('transactions.show', compact('transaction'));
}

public function history()
{
    $transactions = Transaction::where('user_id', auth()->id())
                               ->orderBy('created_at', 'desc')
                               ->paginate(10); // Paginer les résultats

    return view('payment.history', compact('transactions'));
}

}
