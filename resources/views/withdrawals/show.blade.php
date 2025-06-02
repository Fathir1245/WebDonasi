<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Withdrawal Request Details</h1>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($withdrawal->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($withdrawal->status === 'approved') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($withdrawal->status) }}
                        </span>
                    </div>

                    <!-- Campaign Info -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            <a href="{{ route('campaigns.show', $withdrawal->campaign) }}" class="text-emerald-600 hover:text-emerald-700">
                                {{ $withdrawal->campaign->title }}
                            </a>
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Campaign Target:</span>
                                <p class="font-semibold">Rp {{ number_format($withdrawal->campaign->target_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Total Raised:</span>
                                <p class="font-semibold text-emerald-600">Rp {{ number_format($withdrawal->campaign->current_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Progress:</span>
                                <p class="font-semibold text-blue-600">{{ $withdrawal->campaign->progress_percentage }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Withdrawal Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Request Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm">Amount Requested:</span>
                                    <p class="font-bold text-xl text-purple-600">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm">Requested Date:</span>
                                    <p class="font-medium">{{ $withdrawal->requested_at->format('d M Y, H:i') }}</p>
                                </div>
                                @if($withdrawal->approved_at)
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $withdrawal->status === 'approved' ? 'Approved' : 'Processed' }} Date:</span>
                                    <p class="font-medium">{{ $withdrawal->approved_at->format('d M Y, H:i') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Status Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm">Current Status:</span>
                                    <p class="font-medium">
                                        <span class="px-2 py-1 rounded-full text-sm
                                            @if($withdrawal->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($withdrawal->status === 'approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>
                                    </p>
                                </div>
                                @if($withdrawal->status === 'pending')
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <p>Your withdrawal request is being reviewed by our team. You will be notified once a decision is made.</p>
                                </div>
                                @elseif($withdrawal->status === 'approved')
                                <div class="text-sm text-green-600 dark:text-green-400">
                                    <p>Your withdrawal has been approved! Funds will be transferred to your registered bank account within 3-5 business days.</p>
                                </div>
                                @else
                                <div class="text-sm text-red-600 dark:text-red-400">
                                    <p>Your withdrawal request has been rejected. Please see the reason below.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($withdrawal->reason)
                    <div class="mb-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-3">
                            {{ $withdrawal->status === 'pending' ? 'Reason for Request' : 'Admin Response' }}
                        </h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-700 dark:text-gray-300">{{ $withdrawal->reason }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex justify-between items-center">
                        <a href="{{ route('withdrawals.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Withdrawals
                        </a>

                        @if($withdrawal->isPending())
                        <form action="{{ route('withdrawals.destroy', $withdrawal) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this withdrawal request?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel Request
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
