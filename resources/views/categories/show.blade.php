<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $category->name }}
            </h2>
            @if(auth()->check() && auth()->user()->is_admin)
                <div class="flex space-x-2">
                    <a href="{{ route('categories.edit', $category) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit Kategori
                    </a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                            Hapus Kategori
                        </button>
                    </form>
                </div>
            @endif
        </div>
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

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Detail Kategori -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Kategori</h3>
                        <p class="text-gray-600">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
                        <div class="mt-2 text-sm text-gray-500">
                            Dibuat pada: {{ $category->created_at->format('d M Y H:i') }}
                        </div>
                    </div>

                    <!-- Daftar Kampanye -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Kampanye</h3>
                        
                        @if($category->campaigns->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($category->campaigns as $campaign)
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                                        <!-- Preview Foto Kampanye -->
                                        <div class="relative h-48 w-full">
                                            @if($campaign->image)
                                                <img src="{{ asset('storage/' . $campaign->image) }}" 
                                                     alt="{{ $campaign->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-400">Tidak ada gambar</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="p-6">
                                            <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                                <a href="{{ route('campaigns.show', $campaign) }}" class="hover:text-blue-600">
                                                    {{ $campaign->title }}
                                                </a>
                                            </h4>
                                            
                                            @if($campaign->description)
                                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($campaign->description, 100) }}</p>
                                            @endif
                                            
                                            <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                                <span>Target: Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                                                <span>{{ $campaign->created_at->format('d M Y') }}</span>
                                            </div>
                                            
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                                @php
                                                    $progress = ($campaign->current_amount / $campaign->target_amount) * 100;
                                                    $progress = min($progress, 100);
                                                @endphp
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                                            </div>
                                            
                                            <div class="flex justify-between text-sm text-gray-500 mb-4">
                                                <span>Terkumpul: Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                                                <span>{{ number_format($progress, 1) }}%</span>
                                            </div>
                                            
                                            <a href="{{ route('campaigns.show', $campaign) }}" 
                                               class="block text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">Belum ada kampanye dalam kategori ini.</p>
                                @if(auth()->check())
                                    <a href="{{ route('campaigns.create') }}" class="text-blue-600 hover:text-blue-800">
                                        Buat kampanye pertama
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="mt-6">
                        <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800">
                            ← Kembali ke Daftar Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 