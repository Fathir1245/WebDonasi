<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Make a Donation</h1>
                    
                    <div class="mb-6">
                        <div class="flex items-center space-x-4">
                            @if($campaign->image)
                                <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="h-16 w-16 object-cover rounded-lg">
                            @endif
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $campaign->title }}</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">by {{ $campaign->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('donations.store', $campaign) }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Donation Amount (Rp)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">Rp</span>
                                </div>
                                <input type="number" name="amount" id="amount" value="{{ old('amount', 50000) }}" min="1000" step="1000" class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" required>
                            </div>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message (Optional)</label>
                            <textarea name="message" id="message" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="relative">
                                    <input type="radio" name="payment_method" id="credit_card" value="credit_card" class="peer hidden" checked>
                                    <label for="credit_card" class="block p-4 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200 dark:peer-checked:ring-emerald-800 hover:border-gray-400 dark:hover:border-gray-600">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-400 peer-checked:text-emerald-600 dark:peer-checked:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-white">Credit Card</span>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="relative">
                                    <input type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" class="peer hidden">
                                    <label for="bank_transfer" class="block p-4 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200 dark:peer-checked:ring-emerald-800 hover:border-gray-400 dark:hover:border-gray-600">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-400 peer-checked:text-emerald-600 dark:peer-checked:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                            </svg>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-white">Bank Transfer</span>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="relative">
                                    <input type="radio" name="payment_method" id="e-wallet" value="e-wallet" class="peer hidden">
                                    <label for="e-wallet" class="block p-4 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200 dark:peer-checked:ring-emerald-800 hover:border-gray-400 dark:hover:border-gray-600">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-400 peer-checked:text-emerald-600 dark:peer-checked:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-white">E-Wallet</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Complete Donation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>