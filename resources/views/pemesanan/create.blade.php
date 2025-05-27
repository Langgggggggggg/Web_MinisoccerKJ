@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-emerald-600 text-white p-3">
                <h2 class="text-2xl font-semibold">
                    <i class="fas fa-calendar-alt mr-2"></i> Form Pemesanan Lapangan
                </h2>
            </div>
            <div class="p-6">
                <form action="/pemesanan/store" method="POST" id="bookingForm">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-calendar-alt mr-2"></i> Tanggal:
                            </label>
                            <input type="date" name="tanggal" id="tanggal"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required autocomplete="off">
                        </div>

                        <div>
                            <label for="lapangan" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-futbol mr-2"></i> Lapangan:
                            </label>
                            <select name="lapangan" id="lapangan"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                <option value="" disabled selected>Pilih Lapangan</option>
                                <option value="1">Lapangan 1</option>
                                <option value="2">Lapangan 2</option>
                                <option value="3">Lapangan 3</option>
                                <option value="4">Lapangan 4</option>
                                <option value="5">Lapangan 5</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="jam_mulai" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-clock mr-2"></i> Jam Mulai:
                            </label>
                            <input type="time" name="jam_mulai" id="jam_mulai"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required autocomplete="off">
                        </div>

                        <div>
                            <label for="jam_selesai" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-clock mr-2"></i> Jam Selesai:
                            </label>
                            <input type="time" name="jam_selesai" id="jam_selesai"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="nama_tim" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-users mr-2"></i> Nama Tim:
                        </label>
                        <input type="text" name="nama_tim" id="nama_tim"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required autocomplete="off" placeholder="Contoh: Garuda FC">
                    </div>

                    <div class="mb-6">
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-phone mr-2"></i> No Telepon:
                        </label>
                        <input type="tel" name="no_telepon" id="no_telepon"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required autocomplete="off" placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="mb-6">
                        <label for="dp" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-money-bill-wave mr-2"></i> DP (Rp):
                        </label>
                        <input type="number" name="dp" id="dpInput" min="100000"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required placeholder="Minimal DP Rp 100.000">
                        <span id="dpWarning" class="text-red-500 text-sm mt-2 hidden">Minimal DP Rp 100.000!</span>
                    </div>

                    <div class="mb-6 flex justify-end space-x-2">
                        <button type="button"
                            class="bg-emerald-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-emerald-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50"
                            onclick="processPayment()">
                            <i class="fas fa-credit-card mr-2"></i> Pesan
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        function processPayment() {
            let formData = {
                tanggal: document.querySelector('input[name="tanggal"]').value,
                lapangan: document.querySelector('select[name="lapangan"]').value,
                jam_mulai: document.querySelector('input[name="jam_mulai"]').value,
                jam_selesai: document.querySelector('input[name="jam_selesai"]').value,
                nama_tim: document.querySelector('input[name="nama_tim"]').value,
                no_telepon: document.querySelector('input[name="no_telepon"]').value,
                dp: parseInt(document.querySelector('input[name="dp"]').value),
            };

            // Validasi DP minimal
            if (formData.dp < 100000) {
                Swal.fire({
                    icon: 'error',
                    title: 'DP yang anda bayar kurang',
                    text: 'Minimal DP yang harus dibayar adalah Rp 100.000!',
                });
                return;
            }

            // Hitung total biaya sewa berdasarkan lapangan dan jam
            const jamMulai = parseInt(formData.jam_mulai.split(":")[0]);
            const jamSelesai = parseInt(formData.jam_selesai.split(":")[0]);
            const durasi = jamSelesai - jamMulai;

            let hargaPerJam = 0;
            const lap = parseInt(formData.lapangan);

            if ([1, 2, 3].includes(lap)) {
                hargaPerJam = jamMulai < 17 ? 300000 : 350000;
            } else if ([4, 5].includes(lap)) {
                hargaPerJam = jamMulai < 17 ? 400000 : 450000;
            }

            const totalBiaya = hargaPerJam * durasi;

            // Jika DP melebihi total biaya, langsung tolak
            if (formData.dp > totalBiaya) {
                Swal.fire({
                    icon: 'error',
                    title: 'DP Terlalu Besar',
                    html: `Total biaya sewa lapangan adalah <b>Rp ${totalBiaya.toLocaleString()}</b><br>
                   DP yang Anda masukkan: <b>Rp ${formData.dp.toLocaleString()}</b><br><br>
                   DP yang anda masukkan melebihi total biaya sewa lapangan, silahkan masukkan DP yang sesuai.`,
                });
                return;
            }

            // Lanjut proses pembayaran
            lanjutkanPembayaran(formData);
        }

        function lanjutkanPembayaran(formData) {
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
                            document.getElementById('bookingForm').submit();
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
@endsection
