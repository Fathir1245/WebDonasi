<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-4">
                        Create New Campaign
                    </a>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($campaigns as $campaign)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <!-- Campaign Image -->
                                <div class="relative h-48 w-full">
                                    @if($campaign->image)
                                        <img src="{{ asset('storage/' . $campaign->image) }}" 
                                             alt="{{ $campaign->title }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <!-- Category Badge -->
                                    @if($campaign->category)
                                        <div class="absolute top-2 right-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                {{ $campaign->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Campaign Content -->
                                <div class="p-6">
                                    <h5 class="text-lg font-semibold mb-2 text-gray-900">{{ $campaign->title }}</h5>
                                    <p class="text-gray-600 mb-4">{{ Str::limit($campaign->description, 100) }}</p>
                                    
                                    <!-- Progress Bar -->
                                    <div class="mb-4">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-600">Progress</span>
                                            <span class="font-medium text-emerald-600">{{ $campaign->progress_percentage }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Campaign Stats -->
                                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                        <div>
                                            <p class="text-gray-500">Raised</p>
                                            <p class="font-semibold text-emerald-600">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Target</p>
                                            <p class="font-semibold text-gray-900">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</p>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2 mt-4">
                                        <a href="{{ route('campaigns.show', $campaign->id) }}" 
                                           class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            View
                                        </a>
                                        @if(auth()->check() && (auth()->user()->is_admin || auth()->id() === $campaign->user_id))
                                            <a href="{{ route('campaigns.edit', $campaign->id) }}" 
                                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Edit
                                            </a>
                                            <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-full inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" 
                                                        onclick="return confirm('Are you sure you want to delete this campaign?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
