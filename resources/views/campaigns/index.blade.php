<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Active Campaigns</h1>
                @auth
                    <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create Campaign
                    </a>
                @endauth
            </div>

            <!-- Category Filter -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('campaigns.index') }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 
                              {{ !request('category') ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        All Categories
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('campaigns.index', ['category' => $category->slug]) }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 
                                  {{ request('category') === $category->slug ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ $category->name }}
                            <span class="ml-1 text-xs opacity-75">({{ $category->campaigns_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>

            @if(session('success'))
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            @endif

            @if($campaigns->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-gray-600 dark:text-gray-300 text-lg">
                            {{ request('category') ? 'No campaigns found in this category.' : 'No active campaigns found.' }}
                        </p>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Be the first to create one!</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($campaigns as $campaign)
                        <x-card :campaign="$campaign" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $campaigns->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
