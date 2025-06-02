<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Request Withdrawal</h1>
                    
                    <!-- Campaign Info -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ $campaign->title }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Total Raised:</span>
                                <p class="font-semibold text-emerald-600">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Total Withdrawn:</span>
                                <p class="font-semibold text-red-600">Rp {{ number_format($campaign->total_withdrawn, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Available for Withdrawal:</span>
                                <p class="font-semibold text-blue-600">Rp {{ number_format($campaign->available_for_withdrawal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('withdrawals.store', $campaign) }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Withdrawal Amount (Rp)
                            </label>
                            <input 
                                type="number" 
                                name="amount" 
                                id="amount" 
                                value="{{ old('amount') }}" 
                                min="1" 
                                max="{{ $campaign->available_for_withdrawal }}"
                                step="1000" 
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" 
                                required
                            >
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Maximum available: Rp {{ number_format($campaign->available_for_withdrawal, 0, ',', '.') }}
                            </p>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Reason for Withdrawal (Optional)
                            </label>
                            <textarea 
                                name="reason" 
                                id="reason" 
                                rows="4" 
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                placeholder="Explain how you plan to use these funds..."
                            >{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                        Important Notice
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Withdrawal requests will be reviewed by our team</li>
                                            <li>Processing may take 3-5 business days</li>
                                            <li>You will be notified once your request is approved or rejected</li>
                                            <li>Funds will be transferred to your registered bank account</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
