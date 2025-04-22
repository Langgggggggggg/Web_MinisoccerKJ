@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="max-w-xl mx-auto p-4 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold mb-4">
        <i class="fas fa-edit mr-2"></i> Ubah Jadwal Pemesanan
    </h2>

    <form action="{{ route('pemesanan.update', $pemesanan->kode_pemesanan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="tanggal" class="block text-gray-700"><i class="fas fa-calendar-alt mr-2"></i> Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="w-full border px-3 py-2 rounded" value="{{ old('tanggal', $pemesanan->tanggal) }}" required>
        </div>

        <div class="mb-4">
            <label for="lapangan" class="block text-gray-700"><i class="fas fa-futbol mr-2"></i> Lapangan</label>
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
            <label for="jam_mulai" class="block text-gray-700"><i class="fas fa-clock mr-2"></i> Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="w-full border px-3 py-2 rounded" value="{{ old('jam_mulai', $pemesanan->jam_mulai) }}" required>
        </div>

        <div class="mb-4">
            <label for="jam_selesai" class="block text-gray-700"><i class="fas fa-clock mr-2"></i> Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="w-full border px-3 py-2 rounded" value="{{ old('jam_selesai', $pemesanan->jam_selesai) }}" required>
        </div>

        <!-- Field nama_tim -->
        <div class="mb-4">
            <label for="nama_tim" class="block text-gray-700"><i class="fas fa-user mr-2"></i> Nama Tim</label>
            <input type="text" name="nama_tim" id="nama_tim" class="w-full border px-3 py-2 rounded" value="{{ old('nama_tim', $pemesanan->nama_tim) }}" required>
        </div>

        <!-- Field no_telepon -->
        <div class="mb-4">
            <label for="no_telepon" class="block text-gray-700"><i class="fas fa-phone mr-2"></i> No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="w-full border px-3 py-2 rounded" value="{{ old('no_telepon', $pemesanan->no_telepon) }}" required>
        </div>

        <!-- Hapus field DP karena tidak perlu diupdate -->
        
        <div class="flex justify-end">
            <a href="{{ route('pemesanan.detail') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 flex items-center">
                <i class="fas fa-ban mr-2"></i> Batal
            </a>
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded flex items-center">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
  <!-- Sweet Alert CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if (session('error'))
      <script>
          Swal.fire({
              icon: 'error',
              title: 'Gagal!',
              text: "{{ session('error') }}"
          });
      </script>
  @endif
@endsection

