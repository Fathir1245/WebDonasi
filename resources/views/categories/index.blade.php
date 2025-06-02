<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kategori Kampanye') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Kategori
            </a>
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

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($categories as $category)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('categories.show', $category) }}" class="hover:text-blue-600">
                                        {{ $category->name }}
                                    </a>
                                </h3>
                                
                                @if($category->description)
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($category->description, 100) }}</p>
                                @endif
                                
                                <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                    <span>{{ $category->campaigns_count }} kampanye</span>
                                    <span>{{ $category->created_at->format('d M Y') }}</span>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('categories.show', $category) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                        Lihat Kampanye
                                    </a>
                                    <a href="{{ route('categories.edit', $category) }}" class="text-yellow-600 hover:text-yellow-800 text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">Belum ada kategori yang dibuat.</p>
                                <a href="{{ route('categories.create') }}" class="text-blue-600 hover:text-blue-800">
                                    Buat kategori pertama
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
