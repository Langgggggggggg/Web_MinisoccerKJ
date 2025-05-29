@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-emerald-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Form Pemesanan Lapangan (Member)</h2>
            </div>

            <form id="bookingFormMember" action="{{ route('pemesanan.storeMember') }}" method="POST" class="p-6">
                @csrf

                <!-- Pilihan Lapangan -->
                <div class="mb-6">
                    <label for="lapangan" class="block text-sm font-medium text-gray-700 mb-2">Lapangan</label>
                    <select name="lapangan"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                        required>
                        <option value="1">Lapangan 1</option>
                        <option value="2">Lapangan 2</option>
                        <option value="3">Lapangan 3</option>
                        <option value="4">Lapangan 4</option>
                        <option value="5">Lapangan 5</option>
                    </select>
                </div>

                <!-- Jadwal -->
                <div class="space-y-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Jadwal Pemesanan</h3>

                    @for ($i = 0; $i < 4; $i++)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 hover:bg-gray-100 transition">
                            <h4 class="text-md font-medium text-emerald-700 mb-3">Jadwal {{ $i + 1 }}</h4>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="tanggal[]"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                    <input type="date" name="tanggal[]"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                </div>

                                <div>
                                    <label for="jam_mulai[]" class="block text-sm font-medium text-gray-700 mb-1">Jam
                                        Mulai</label>
                                    <input type="time" name="jam_mulai[]"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                </div>

                                <div>
                                    <label for="jam_selesai[]" class="block text-sm font-medium text-gray-700 mb-1">Jam
                                        Selesai</label>
                                    <input type="time" name="jam_selesai[]"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Informasi Tim -->
                <div class="space-y-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Informasi Tim</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_tim" class="block text-sm font-medium text-gray-700 mb-1">Nama Tim</label>
                            <input type="text" name="nama_tim"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                required>
                        </div>

                        <div>
                            <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
                            <input type="text" name="no_telepon"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                required>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran -->
                <div class="mb-8">
                    <label for="dp" class="block text-sm font-medium text-gray-700 mb-1">DP (Minimal 400.000)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="dp"
                            class="w-full pl-12 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                            required>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="prosesPembayaranMember()"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        Pesan Sekarang
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
    function prosesPembayaranMember() {
        let formData = {
            tanggal: document.querySelector('input[name="tanggal[]"]').value,
            lapangan: document.querySelector('select[name="lapangan"]').value,
            jam_mulai: document.querySelector('input[name="jam_mulai[]"]').value,
            jam_selesai: document.querySelector('input[name="jam_selesai[]"]').value,
            nama_tim: document.querySelector('input[name="nama_tim"]').value,
            no_telepon: document.querySelector('input[name="no_telepon"]').value,
            dp: parseInt(document.querySelector('input[name="dp"]').value),
        };

        const [jamMulaiHour, jamMulaiMinute] = formData.jam_mulai.split(":").map(Number);
        const [jamSelesaiHour, jamSelesaiMinute] = formData.jam_selesai.split(":").map(Number);

        // Validasi menit jam mulai
        if (jamMulaiMinute !== 0) {
            const contohJamMulai = `${jamMulaiHour.toString().padStart(2, '0')}:00`;
            Swal.fire({
                icon: 'error',
                title: 'Jam Mulai Tidak Valid',
                text: `Jam mulai yang Anda masukkan adalah ${formData.jam_mulai}. Jam mulai harus tepat di menit 00, misalnya ${contohJamMulai}.`,
            });
            return;
        }

        // Validasi menit jam selesai
        if (jamSelesaiMinute !== 0) {
            const contohJamSelesai = `${jamSelesaiHour.toString().padStart(2, '0')}:00`;
            Swal.fire({
                icon: 'error',
                title: 'Jam Selesai Tidak Valid',
                text: `Jam selesai yang Anda masukkan adalah ${formData.jam_selesai}. Jam selesai harus tepat di menit 00, misalnya ${contohJamSelesai}.`,
            });
            return;
        }

        // Validasi urutan jam
        if (jamSelesaiHour <= jamMulaiHour) {
            Swal.fire({
                icon: 'error',
                title: 'Durasi Tidak Valid',
                text: `Jam selesai harus lebih besar dari jam mulai. Anda mengisi jam mulai: ${formData.jam_mulai}, jam selesai: ${formData.jam_selesai}.`,
            });
            return;
        }

        // Validasi durasi harus kelipatan 1 jam
        const durasi = jamSelesaiHour - jamMulaiHour;
        if (durasi % 1 !== 0) {
            Swal.fire({
                icon: 'error',
                title: 'Durasi Tidak Valid',
                text: `Durasi sewa harus genap per jam (1 jam, 2 jam, dst). Saat ini Anda mengisi dari ${formData.jam_mulai} sampai ${formData.jam_selesai} yang berdurasi ${durasi} jam.`,
            });
            return;
        }

        // Validasi DP minimal
        if (formData.dp < 400000) {
            Swal.fire({
                icon: 'error',
                title: 'DP yang Anda bayar kurang',
                text: 'Minimal DP yang harus dibayar adalah Rp 400.000!',
            });
            return;
        }

        // Jika semua valid, lanjutkan
        lanjutkanPembayaranMember(formData);


    }

    function lanjutkanPembayaranMember(formData) {
        Swal.fire({
            icon: 'info',
            title: 'Mohon Tunggu',
            text: 'Sedang memproses pembayaran...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch("/pemesanan/validateSchedule", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify(formData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    return fetch("/pemesanan/getSnapToken", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            dp: formData.dp,
                            nama_tim: formData.nama_tim,
                            no_telepon: formData.no_telepon
                        })
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                    throw new Error('Jadwal tidak tersedia');
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                snap.pay(data.snapToken, {
                    onSuccess: function(result) {
                        document.getElementById('bookingFormMember').submit();
                    },
                    onPending: function(result) {
                        Swal.fire('Menunggu Pembayaran', 'Pembayaran sedang dalam proses.', 'info');
                    },
                    onError: function(result) {
                        Swal.fire('Gagal!', 'Pembayaran gagal. Coba lagi!', 'error');
                    }
                });
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }
</script>
