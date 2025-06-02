<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Campaign Image -->
                        <div class="lg:col-span-1">
                            <div class="rounded-lg overflow-hidden shadow-md">
                                @if($campaign->image)
                                    <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-auto object-cover">
                                @else
                                    <div class="w-full h-64 bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Campaign Details</h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600 dark:text-gray-300">Category:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            <a href="{{ route('campaigns.index', ['category' => $campaign->category->slug]) }}" 
                                               class="text-emerald-600 hover:text-emerald-700">
                                                {{ $campaign->category->name }}
                                            </a>
                                        </span>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600 dark:text-gray-300">Created by:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $campaign->user->name }}</span>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600 dark:text-gray-300">Created on:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $campaign->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600 dark:text-gray-300">Deadline:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $campaign->deadline->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Days left:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $campaign->remaining_days }}</span>
                                    </div>
                                </div>
                            </div>

                            @if(auth()->check() && auth()->id() === $campaign->user_id)
                                <div class="mt-6 space-y-3">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('campaigns.edit', $campaign) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this campaign?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                    
                                    @if($campaign->canRequestWithdrawal())
                                        <a href="{{ route('withdrawals.create', $campaign) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-purple-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Request Withdrawal
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('withdrawals.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        View Withdrawals
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Campaign Info -->
                        <div class="lg:col-span-2">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $campaign->title }}</h1>
                            
                            <div class="mb-6">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Progress</span>
                                    <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $campaign->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                    <div class="bg-emerald-500 h-4 rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-emerald-50 dark:bg-emerald-900/30 rounded-lg p-4 text-center">
                                    <p class="text-sm text-emerald-600 dark:text-emerald-400 mb-1">Raised</p>
                                    <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4 text-center">
                                    <p class="text-sm text-blue-600 dark:text-blue-400 mb-1">Target</p>
                                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">About this campaign</h3>
                                <div class="prose prose-emerald max-w-none dark:prose-invert">
                                    <p class="text-gray-700 dark:text-gray-300">{{ $campaign->description }}</p>
                                </div>
                            </div>
                            
                            @auth
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Support this campaign</h3>
                                    <a href="{{ route('donations.create', $campaign) }}" class="w-full inline-flex justify-center items-center px-4 py-3 bg-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Donate Now
                                    </a>
                                </div>
                            @else
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Want to support this campaign?</h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">Please log in to make a donation.</p>
                                    <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Log In to Donate
                                    </a>
                                </div>
                            @endauth
                            
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Recent Donations</h3>
                                @if($campaign->donations->isEmpty())
                                    <p class="text-gray-600 dark:text-gray-400">No donations yet. Be the first to donate!</p>
                                @else
                                    <div class="space-y-4">
                                        @foreach($campaign->donations->take(5) as $donation)
                                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <p class="font-medium text-gray-900 dark:text-white">{{ $donation->user->name }}</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $donation->created_at->diffForHumans() }}</p>
                                                    </div>
                                                    <p class="font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                                                </div>
                                                @if($donation->message)
                                                    <p class="mt-2 text-gray-700 dark:text-gray-300 text-sm italic">"{{ $donation->message }}"</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Comments</h2>
                    
                    <!-- Comment Form -->
                    @auth
                        <div class="mb-8">
                            <form action="{{ route('comments.store', $campaign) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Leave a comment</label>
                                    <textarea 
                                        name="content" 
                                        id="content" 
                                        rows="3" 
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                        placeholder="Share your thoughts about this campaign..."
                                        required
                                    >{{ old('content') }}</textarea>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Post Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mb-8 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-600 dark:text-gray-400">Please <a href="{{ route('login') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline">log in</a> to leave a comment.</p>
                        </div>
                    @endauth
                    
                    <!-- Comments List -->
                    <div class="space-y-6">
                        @forelse($campaign->comments()->with('user')->latest()->get() as $comment)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-semibold text-lg">
                                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    
                                    @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->is_admin))
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 dark:hover:text-red-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="mt-3 text-gray-700 dark:text-gray-300">
                                    <p>{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">No comments yet. Be the first to share your thoughts!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
