<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Kategori') }}
            </h2>
            <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Kembali ke Daftar Kategori
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

                    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Kategori -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Kategori')" />
                            <x-text-input id="name" 
                                         name="name" 
                                         type="text" 
                                         class="mt-1 block w-full" 
                                         :value="old('name', $category->name)" 
                                         required 
                                         autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Deskripsi Kategori -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Kategori')" />
                            <textarea id="description" 
                                      name="description" 
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                      rows="4">{{ old('description', $category->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Status Kategori -->
                        <div>
                            <x-input-label for="is_active" :value="__('Status Kategori')" />
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           value="1" 
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Aktif</span>
                                </label>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            <a href="{{ route('categories.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 