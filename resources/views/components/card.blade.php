@props(['campaign'])

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
    <div class="relative">
        @if($campaign->image)
            <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif
        
        <!-- Category Badge -->
        <div class="absolute top-3 left-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                {{ $campaign->category->name }}
            </span>
        </div>
        
        <!-- Days Left Badge -->
        <div class="absolute top-3 right-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ $campaign->remaining_days }} days left
            </span>
        </div>
    </div>
    
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
            <a href="{{ route('campaigns.show', $campaign) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">
                {{ $campaign->title }}
            </a>
        </h3>
        
        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
            {{ Str::limit($campaign->description, 120) }}
        </p>
        
        <div class="mb-4">
            <div class="flex justify-between text-sm mb-1">
                <span class="font-medium text-gray-700 dark:text-gray-300">Progress</span>
                <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $campaign->progress_percentage }}%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
            </div>
        </div>
        
        <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400 mb-4">
            <span>Raised: <strong class="text-emerald-600 dark:text-emerald-400">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</strong></span>
            <span>Target: <strong>Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</strong></span>
        </div>
        
        <div class="flex justify-between items-center">
            <div class="text-xs text-gray-500 dark:text-gray-400">
                by {{ $campaign->user->name }}
            </div>
            <a href="{{ route('campaigns.show', $campaign) }}" class="inline-flex items-center px-3 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                View Details
            </a>
        </div>
    </div>
</div>
