@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="container mx-auto">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-emerald-600 text-white p-3">
            <h2 class="text-2xl font-semibold">
                <i class="fas fa-calendar-alt mr-2"></i> Form Pemesanan Lapangan (Admin)
            </h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.pemesanan.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-calendar-alt mr-2"></i> Tanggal:
                        </label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('tanggal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="lapangan" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-futbol mr-2"></i> Lapangan:
                        </label>
                        <select name="lapangan"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="" disabled selected>Pilih Lapangan</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('lapangan') == $i ? 'selected' : '' }}>Lapangan {{ $i }}</option>
                            @endfor
                        </select>
                        @error('lapangan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-clock mr-2"></i> Jam Mulai:
                        </label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('jam_mulai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="jam_selesai" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-clock mr-2"></i> Jam Selesai:
                        </label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('jam_selesai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="nama_tim" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-user mr-2"></i> Nama Tim:
                    </label>
                    <input type="text" name="nama_tim" value="{{ old('nama_tim') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                    @error('nama_tim') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-phone mr-2"></i> No Telepon:
                    </label>
                    <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                    @error('no_telepon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-star mr-2"></i> Jenis Pemesanan:
                    </label>
                    <select name="jenis_pemesanan" id="jenisPemesanan"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required onchange="toggleDpField()">
                        <option value="bayar" {{ old('jenis_pemesanan') == 'bayar' ? 'selected' : '' }}>Berbayar</option>
                        <option value="gratis" {{ old('jenis_pemesanan') == 'gratis' ? 'selected' : '' }}>Gratis</option>
                    </select>
                    @error('jenis_pemesanan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6 {{ old('jenis_pemesanan') === 'gratis' ? 'hidden' : '' }}" id="dpField">
                    <label for="dp" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-dollar-sign mr-2"></i> DP (Rp):
                    </label>
                    <input type="number" name="dp" id="dpInput" min="100000" value="{{ old('dp') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Minimal DP Rp 100.000">
                    <span id="dpWarning" class="text-red-500 text-sm mt-2 hidden">Minimal DP Rp 100.000!</span>
                    @error('dp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <button type="submit"
                        class="w-full bg-emerald-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-emerald-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                        <i class="fas fa-check-circle mr-2"></i> Simpan Pemesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function toggleDpField() {
        const jenisPemesanan = document.getElementById('jenisPemesanan').value;
        const dpField = document.getElementById('dpField');
        const dpInput = document.getElementById('dpInput');

        if (jenisPemesanan === 'gratis') {
            dpField.classList.add('hidden');
            dpInput.value = '';
            dpInput.removeAttribute('required');
        } else {
            dpField.classList.remove('hidden');
            dpInput.setAttribute('required', 'required');
        }
    }

    document.addEventListener('DOMContentLoaded', toggleDpField);
</script>
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
