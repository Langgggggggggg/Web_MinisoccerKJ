@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold mb-6">Edit Informasi</h1>

    <form action="{{ route('admin.information.update', $information->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title', $information->title) }}"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label class="block font-medium mb-1">Kategori</label>
            <select name="category" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="Pengumuman" {{ $information->category == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                <option value="Event" {{ $information->category == 'Event' ? 'selected' : '' }}>Event</option>
                <option value="Tips" {{ $information->category == 'Tips' ? 'selected' : '' }}>Tips</option>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Isi Informasi</label>
            <textarea name="content" rows="6"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('content', $information->content) }}</textarea>
        </div>

        <div>
            <label class="block font-medium mb-1">Thumbnail Saat Ini</label>
            @if($information->thumbnail)
                <img src="{{ asset('storage/' . $information->thumbnail) }}" class="w-32 rounded shadow mb-3">
            @else
                <p class="text-sm text-gray-500 italic">Tidak ada thumbnail</p>
            @endif

            <label class="block font-medium mt-2 mb-1">Ganti Thumbnail (opsional)</label>
            <input type="file" name="thumbnail" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0 file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Update</button>
            <a href="{{ route('admin.information.index') }}" class="ml-4 text-gray-600 hover:underline">Kembali</a>
        </div>
    </form>
</div>
@endsection
