<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Pending Top-up Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Student</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Amount</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Reference / Notes</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Requested At</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($pendingTransactions as $transaction)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-4">
                                        <p class="text-sm font-bold text-gray-800">{{ $transaction->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $transaction->user->email }}</p>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span class="text-sm font-black text-canteen-600">
                                            ₱{{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4">
                                        @if($transaction->reference_number)
                                            <p class="text-xs font-bold text-blue-600 mb-1">REF: {{ $transaction->reference_number }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 italic">{{ $transaction->description }}</p>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-500">
                                        {{ $transaction->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-8 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-xl text-xs transition-all shadow-sm">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-xl text-xs transition-all shadow-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-12 text-center text-gray-400 font-medium">
                                        No pending requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-8 bg-gray-50/30">
                    {{ $pendingTransactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
