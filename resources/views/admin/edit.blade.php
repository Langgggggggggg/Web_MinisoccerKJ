@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-user-edit mr-3"></i> Edit Profil Admin
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.update', $admin->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div>
                <label for="name" class=" text-gray-700 flex items-center">
                    <i class="fas fa-user mr-2 text-gray-500"></i> Nama
                </label>
                <input type="text" id="name" name="name" value="{{ $admin->name }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition" required>
            </div>

            <!-- Username -->
            <div>
                <label for="username" class=" text-gray-700 flex items-center">
                    <i class="fas fa-id-badge mr-2 text-gray-500"></i> Username
                </label>
                <input type="text" id="username" name="username" value="{{ $admin->username }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class=" text-gray-700 flex items-center">
                    <i class="fas fa-envelope mr-2 text-gray-500"></i> Email
                </label>
                <input type="email" id="email" name="email" value="{{ $admin->email }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition" required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class=" text-gray-700 flex items-center">
                    <i class="fas fa-lock mr-2 text-gray-500"></i> Password (Kosongkan jika tidak ingin mengubah)
                </label>
                <input type="password" id="password" name="password" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class=" text-gray-700 flex items-center">
                    <i class="fas fa-lock mr-2 text-gray-500"></i> Konfirmasi Password
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
            </div>

            <!-- Tombol Simpan & Kembali -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.data-admin') }}" 
                    class="flex items-center px-5 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>

                <button type="submit" 
                    class="flex items-center px-5 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
