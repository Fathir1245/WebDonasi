<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="relative min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                                DonateHub
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @if (Route::has('login'))
                            <div class="space-x-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400">Dashboard</a>
                                    <a href="{{ route('campaigns.index') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400">Campaigns</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400">Log in</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section with Carousel -->
        <div class="relative bg-emerald-600 dark:bg-emerald-800" 
             x-data="{ 
                activeSlide: 0,
                slides: [
                    'gambar.jpg',
                    'gambar1.jpeg',
                    'gambar2.jpeg',
                    'gambar.jpeg'
                ],
                interval: null,
                init() {
                    this.interval = setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length
                    }, 5000)
                },
                stopSlideshow() {
                    clearInterval(this.interval)
                }
             }"
             x-init="init()"
             @mouseover="stopSlideshow()"
             @mouseout="init()">
            
            <!-- Carousel Images -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" 
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 transform scale-105"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-1000"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute inset-0">
                    <img :src="'/storage/' + slide" alt="Hero Background" class="w-full h-full object-cover opacity-20">
                    <div class="absolute inset-0 bg-emerald-600 dark:bg-emerald-800 mix-blend-multiply"></div>
                </div>
            </template>
            
            <!-- Hero Content -->
            <div class="relative max-w-7xl h-[40rem] mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 z-10">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Make a difference today</h1>
                <p class="mt-6 text-xl text-emerald-100 max-w-3xl">Support causes you care about and help create positive change in the world. Every donation, no matter how small, can make a big impact.</p>
                <div class="mt-10">
                    @auth
                        <a href="{{ route('campaigns.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            Browse Campaigns
                        </a>
                        <a href="{{ route('campaigns.create') }}" class="ml-4 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-emerald-800 bg-opacity-60 hover:bg-opacity-70 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            Start a Campaign
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            Browse Campaigns
                        </a>
                        <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-emerald-800 bg-opacity-60 hover:bg-opacity-70 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            Join Now
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Featured Campaigns Section -->
        <div class="py-12 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                        Featured Campaigns
                    </h2>
                    <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400 sm:mt-4">
                        Discover campaigns that need your support right now
                    </p>
                </div>

                <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach(App\Models\Campaign::where('status', 'active')->latest()->take(3)->get() as $campaign)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-[1.02]">
                            <div class="relative h-48 overflow-hidden">
                                @if($campaign->image)
                                    <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                    <h3 class="text-white font-bold text-lg truncate">{{ $campaign->title }}</h3>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <div class="mb-4">
                                    <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-2">{{ $campaign->description }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Progress</span>
                                        <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $campaign->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                        <div class="bg-emerald-500 h-2.5 rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between text-sm mb-4">
                                    <div>
                                        <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                                        <span class="text-gray-500 dark:text-gray-400"> raised</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Target: </span>
                                        <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        <span class="inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $campaign->remaining_days }} days left
                                        </span>
                                    </div>
                                    @auth
                                        <a href="{{ route('campaigns.show', $campaign) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300">
                                            View Details
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300">
                                            Login to View
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    @auth
                        <a href="{{ route('campaigns.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            View All Campaigns
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            Login to View All Campaigns
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- How It Works Section -->
        <div class="py-12 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                        How It Works
                    </h2>
                    <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400 sm:mt-4">
                        Simple steps to make a difference
                    </p>
                </div>

                <div class="mt-12">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-xl font-medium text-gray-900 dark:text-white">Create a Campaign</h3>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-400">
                                Sign up and create a campaign for a cause you care about. Set a target amount and deadline.
                            </p>
                        </div>

                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-xl font-medium text-gray-900 dark:text-white">Receive Donations</h3>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-400">
                                Share your campaign with friends, family, and social networks to gather support and donations.
                            </p>
                        </div>

                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-xl font-medium text-gray-900 dark:text-white">Make an Impact</h3>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-400">
                                Use the funds to make a real difference for your cause and share updates with your supporters.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex justify-center md:justify-start">
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                            DonateHub
                        </a>
                    </div>
                    <div class="mt-8 md:mt-0">
                        <p class="text-center text-base text-gray-500 dark:text-gray-400">
                            &copy; {{ date('Y') }} DonateHub. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
