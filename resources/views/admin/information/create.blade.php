@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="max-w-3xl mx-auto  px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8 flex items-center gap-2">
        <i class="fas fa-newspaper text-emerald-600"></i>
        Tambah Informasi Baru
    </h1>

    <form action="{{ route('admin.information.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md space-y-6">
        @csrf

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">
                <i class="fas fa-heading mr-1 text-emerald-500"></i> Judul
            </label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:text-white" required>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">
                <i class="fas fa-list-alt mr-1 text-emerald-500"></i> Kategori
            </label>
            <select name="category"
                class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:text-white" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Pengumuman">📢 Pengumuman</option>
                <option value="Event">🎉 Event</option>
                <option value="Tips">💡 Tips</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">
                <i class="fas fa-align-left mr-1 text-emerald-500"></i> Isi Informasi
            </label>
            <textarea name="content" rows="6"
                class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:text-white" required>{{ old('content') }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">
                <i class="fas fa-image mr-1 text-emerald-500"></i> Thumbnail (opsional)
            </label>
            <input type="file" name="thumbnail"
                class="block w-full text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0 file:text-sm file:font-semibold
                file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
        </div>

        <div class="pt-4 flex items-center justify-between">
            <button type="submit"
                class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
            <a href="{{ route('admin.information.index') }}"
                class="text-gray-600 hover:underline dark:text-gray-300">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection

