@extends('layouts.app')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <div class="min-h-screen px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit Informasi
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Perbarui informasi dengan mengisi form di bawah ini</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <form action="{{ route('admin.information.update', $information->id) }}" method="POST"
                    enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Main Grid Layout -->
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                        
                        <!-- Left Column - Basic Information -->
                        <div class="xl:col-span-2 space-y-6">
                            
                            <!-- Title and Category Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Title Field -->
                                <div class="space-y-2">
                                    <label for="title" class="block text-sm font-semibold text-gray-700">
                                        Judul Informasi
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="title" name="title" value="{{ old('title', $information->title) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out hover:border-gray-400"
                                        placeholder="Masukkan judul informasi..." required>
                                    @error('title')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category Field -->
                                <div class="space-y-2">
                                    <label for="category" class="block text-sm font-semibold text-gray-700">
                                        Kategori
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="category" name="category"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out hover:border-gray-400 appearance-none bg-white"
                                            required>
                                            <option value="" disabled>Pilih kategori informasi</option>
                                            <option value="Pengumuman" {{ $information->category == 'Pengumuman' ? 'selected' : '' }}>📢 Pengumuman</option>
                                            <option value="Event" {{ $information->category == 'Event' ? 'selected' : '' }}>🎉 Event</option>
                                            <option value="Tips" {{ $information->category == 'Tips' ? 'selected' : '' }}>💡 Tips</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            {{-- <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                                            </svg> --}}
                                        </div>
                                    </div>
                                    @error('category')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Content Field -->
                            <div class="space-y-2">
                                <label for="content" class="block text-sm font-semibold text-gray-700">
                                    Isi Informasi
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea id="content" name="content" rows="12"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out hover:border-gray-400 resize-vertical"
                                    placeholder="Tulis isi informasi secara detail..." required>{{ old('content', $information->content) }}</textarea>
                                @error('content')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column - Thumbnail Section -->
                        <div class="xl:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-6 h-fit sticky top-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Thumbnail Informasi
                                </h3>

                                <!-- Current Thumbnail -->
                                @if ($information->thumbnail)
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">Thumbnail Saat Ini</label>
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $information->thumbnail) }}"
                                                alt="Current thumbnail"
                                                class="w-full h-48 object-cover rounded-lg shadow-md border border-gray-200 mb-3">
                                            {{-- <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                                <div class="flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm font-medium text-green-800">Thumbnail tersedia</span>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-6">
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                            <div class="flex items-center justify-center">
                                                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-sm font-medium text-yellow-800">Tidak ada thumbnail</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Upload New Thumbnail -->
                                <div class="space-y-2">
                                    <label for="thumbnail" class="block text-sm font-medium text-gray-700">
                                        {{ $information->thumbnail ? 'Ganti Thumbnail (opsional)' : 'Upload Thumbnail' }}
                                    </label>
                                    <div class="mt-1 flex justify-center px-4 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition duration-200">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                    <span>Upload gambar</span>
                                                    <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/*">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                        </div>
                                    </div>
                                    @error('thumbnail')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="border-t border-gray-200 mt-8 pt-6">
                        <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center space-y-3 sm:space-y-0">
                            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 ease-in-out transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Update Informasi
                                </button>
                                <a href="{{ route('admin.information.index') }}"
                                    class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200 ease-in-out shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection