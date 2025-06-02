<div class="relative">
    <a href="{{ route('campaigns.show', $campaign) }}">
        <img class="rounded-xl w-full" src="{{ asset('storage/' . $campaign->image) }}" alt="">
    </a>

    <!-- Category Badge -->
    @if($campaign->category)
    <div class="absolute top-3 left-3">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
            {{ $campaign->category->name }}
        </span>
    </div>
    @endif

    <div class="mt-2">
        <a href="{{ route('campaigns.show', $campaign) }}">
            <h2 class="text-lg font-semibold">{{ $campaign->title }}</h2>
        </a>
        <p class="mt-1 text-gray-500">
            {{ Str::limit($campaign->description, 50) }}
        </p>

        <div class="mt-4 flex justify-between items-center">
            <div>
                <span class="text-sm font-medium text-gray-700">${{ $campaign->goal }}</span>
                <span class="text-sm text-gray-500">Goal</span>
            </div>

            <div>
                <span class="text-sm font-medium text-gray-700">{{ $campaign->donations()->sum('amount') }}</span>
                <span class="text-sm text-gray-500">Raised</span>
            </div>
        </div>

        <x-progress-bar :value="$campaign->donations()->sum('amount')" :max="$campaign->goal" />
    </div>
</div>
