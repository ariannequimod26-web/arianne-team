<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $pendingTransactions = Transaction::where('status', 'pending')
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('admin.transactions.index', compact('pendingTransactions'));
    }

    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaction is not pending.');
        }

        $transaction->update(['status' => 'completed']);
        $transaction->user->increment('balance', $transaction->amount);

        return back()->with('success', "Approved ₱{$transaction->amount} for {$transaction->user->name}.");
    }

    public function reject(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaction is not pending.');
        }

        $transaction->update(['status' => 'cancelled']);

        return back()->with('success', "Rejected transaction for {$transaction->user->name}.");
    }
}
