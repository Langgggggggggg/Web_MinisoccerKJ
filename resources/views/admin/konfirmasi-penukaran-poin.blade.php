@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg">

        <h2 class="text-2xl font-bold mb-4">
            <i class="fas fa-gift mr-2"></i>Konfirmasi Penukaran Poin
        </h2>

        <!-- Form Pencarian Kode Voucher -->
        <form action="{{ route('admin.konfirmasi-penukaran-poin.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="kode_voucher" class="block text-gray-700 font-semibold">Masukkan Kode Voucher:</label>
                <input type="text" name="kode_voucher" id="kode_voucher" required class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                <i class="fas fa-check-circle"></i> Konfirmasi Penukaran Poin
            </button>
        </form>
    </div>

    <!-- Sweet Alert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}"
            });
        </script>
    @endif

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
