@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-4 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold mb-4">Ubah Jadwal Pemesanan</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pemesanan.update', $pemesanan->kode_pemesanan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="tanggal" class="block text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="w-full border px-3 py-2 rounded" value="{{ old('tanggal', $pemesanan->tanggal) }}" required>
        </div>

        <div class="mb-4">
            <label for="lapangan" class="block text-gray-700">Lapangan</label>
            <select name="lapangan" id="lapangan" class="w-full border px-3 py-2 rounded" required>
                @php
                    $lapangans = [1, 2, 3, 4, 5];
                @endphp
                @foreach ($lapangans as $lapangan)
                    <option value="{{ $lapangan }}" {{ $lapangan == $pemesanan->jadwal->lapangan ? 'selected' : '' }}>
                        Lapangan {{ $lapangan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="jam_mulai" class="block text-gray-700">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="w-full border px-3 py-2 rounded" value="{{ old('jam_mulai', $pemesanan->jam_mulai) }}" required>
        </div>

        <div class="mb-4">
            <label for="jam_selesai" class="block text-gray-700">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="w-full border px-3 py-2 rounded" value="{{ old('jam_selesai', $pemesanan->jam_selesai) }}" required>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('pemesanan.detail') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</a>
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
