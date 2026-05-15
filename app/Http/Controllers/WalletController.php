<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $transactions = $user->transactions()
            ->latest()
            ->paginate(10);

        return view('wallet.index', compact('user', 'transactions'));
    }

    public function requestTopup(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'reference' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255'
        ]);

        auth()->user()->topUp(
            $validated['amount'],
            $validated['description'] ?? 'Balance Top-up Request',
            'pending',
            $validated['reference']
        );

        return back()->with('success', 'Top-up request submitted! Please wait for admin approval.');
    }
}
