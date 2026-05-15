<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('My Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Balance Card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1 bg-canteen-500 rounded-3xl p-8 text-white shadow-xl shadow-canteen-200 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-canteen-100 font-medium mb-1">Current Balance</p>
                        <h3 class="text-4xl font-black">₱{{ number_format($user->balance, 2) }}</h3>
                        <div class="mt-8">
                            <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl text-sm font-bold">
                                {{ $user->student_id ?? 'Student' }}
                            </span>
                        </div>
                    </div>
                    <!-- Decorative Circle -->
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full"></div>
                </div>

                <!-- Top-up Form -->
                <div class="md:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-6">Request Top-up</h4>
                    <form action="{{ route('wallet.topup') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Amount (₱)</label>
                                <input type="number" name="amount" step="0.01" min="1" required class="w-full rounded-2xl border-gray-200 focus:ring-canteen-500 focus:border-canteen-500" placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Reference (Optional)</label>
                                <input type="text" name="reference" class="w-full rounded-2xl border-gray-200 focus:ring-canteen-500 focus:border-canteen-500" placeholder="G-Cash Ref #">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Notes</label>
                            <input type="text" name="description" class="w-full rounded-2xl border-gray-200 focus:ring-canteen-500 focus:border-canteen-500" placeholder="What is this for?">
                        </div>
                        <button type="submit" class="bg-canteen-500 hover:bg-canteen-600 text-white font-bold py-3 px-8 rounded-2xl transition-all shadow-lg shadow-canteen-100">
                            Submit Request
                        </button>
                    </form>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h4 class="text-lg font-bold text-gray-800">Transaction History</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Date</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Description</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Amount</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-4 text-sm text-gray-500">
                                        {{ $transaction->created_at->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="px-8 py-4">
                                        <p class="text-sm font-bold text-gray-800">{{ $transaction->description }}</p>
                                        @if($transaction->reference_number)
                                            <p class="text-xs text-gray-400 font-medium">Ref: {{ $transaction->reference_number }}</p>
                                        @endif
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <span class="text-sm font-black {{ $transaction->type === 'payment' ? 'text-red-500' : 'text-green-500' }}">
                                            {{ $transaction->type === 'payment' ? '-' : '+' }}₱{{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-center">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'completed' => 'bg-green-100 text-green-700',
                                                'cancelled' => 'bg-red-100 text-red-700',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-12 text-center text-gray-400 font-medium">
                                        No transactions yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-8 bg-gray-50/30">
                    {{ $transactions->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
