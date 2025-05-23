@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 flex items-center gap-2">
            <i class="fas fa-newspaper text-black"></i>
            Tambah Informasi Baru
        </h1>
    </div>

    <!-- Form Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <form action="{{ route('admin.information.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Title Field -->
                    <div class="form-group">
                        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">
                            <i class="fas fa-heading mr-2 text-black"></i>
                            Judul
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            value="{{ old('title') }}"
                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-3 
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                   dark:bg-gray-900 dark:text-white transition-colors duration-200" 
                            required
                            placeholder="Masukkan judul informasi">
                    </div>

                    <!-- Category Field -->
                    <div class="form-group">
                        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">
                            <i class="fas fa-list-alt mr-2 text-black"></i>
                            Kategori
                        </label>
                        <select 
                            name="category"
                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-3 
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                   dark:bg-gray-900 dark:text-white transition-colors duration-200" 
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Pengumuman" {{ old('category') == 'Pengumuman' ? 'selected' : '' }}>
                                📢 Pengumuman
                            </option>
                            <option value="Event" {{ old('category') == 'Event' ? 'selected' : '' }}>
                                🎉 Event
                            </option>
                            <option value="Tips" {{ old('category') == 'Tips' ? 'selected' : '' }}>
                                💡 Tips
                            </option>
                        </select>
                    </div>

                    <!-- Thumbnail Field -->
                    <div class="form-group">
                        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">
                            <i class="fas fa-image mr-2 text-black"></i>
                            Thumbnail 
                            {{-- <span class="text-sm font-normal text-gray-500"></span> --}}
                        </label>
                        <div class="relative">
                            <input 
                                type="file" 
                                name="thumbnail"
                                accept="image/*"
                                class="block w-full text-sm text-gray-600 dark:text-gray-300 
                                       file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                       file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 
                                       hover:file:bg-emerald-100 dark:file:bg-emerald-900 dark:file:text-emerald-300
                                       cursor-pointer transition-colors duration-200">
                            <p class="text-xs text-gray-500 mt-1">
                                Format: JPG, PNG, GIF. Maksimal 2MB
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Content Field -->
                    <div class="form-group">
                        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">
                            <i class="fas fa-align-left mr-2 text-black"></i>
                            Isi Informasi
                        </label>
                        <textarea 
                            name="content" 
                            rows="10"
                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-3 
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                   dark:bg-gray-900 dark:text-white transition-colors duration-200 resize-vertical" 
                            required
                            placeholder="Tulis isi informasi di sini...">{{ old('content') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Minimal 10 karakter
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-center justify-end gap-4">
                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-semibold 
                               px-6 py-3 rounded-lg shadow-md transition-all duration-200 
                               hover:shadow-lg transform hover:-translate-y-0.5
                               focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Informasi
                    </button>

                    <!-- Back Button -->
                    <button 
                        type="button"
                        onclick="window.location.href='{{ route('admin.information.index') }}'"
                        class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium 
                               px-6 py-3 rounded-lg shadow-md transition-all duration-200 
                               hover:shadow-lg transform hover:-translate-y-0.5
                               focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection