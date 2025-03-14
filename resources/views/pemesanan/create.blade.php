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
                            <input type="date" name="tanggal"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                        </div>

                        <div>
                            <label for="lapangan" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-futbol mr-2"></i> Lapangan:
                            </label>
                            <select name="lapangan"
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
                            <input type="time" name="jam_mulai"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                        </div>

                        <div>
                            <label for="jam_selesai" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-clock mr-2"></i> Jam Selesai:
                            </label>
                            <input type="time" name="jam_selesai"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="nama_tim" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-user mr-2"></i> Nama Tim:
                        </label>
                        <input type="text" name="nama_tim"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-phone mr-2"></i> No Telepon:
                        </label>
                        <input type="text" name="no_telepon"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="dp" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-dollar-sign mr-2"></i> DP (Rp):
                        </label>
                        <input type="number" name="dp" min="100000" id="dpInput"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Minimal DP Rp 100.000" required>
                        <span id="dpWarning" class="text-red-500 text-sm mt-2 hidden">Minimal DP Rp 100.000!</span>

                    </div>

                    <div class="mb-6">
                        <button type="button"
                            class="w-full bg-emerald-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-emerald-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50"
                            onclick="processPayment()">
                            <i class="fas fa-check-circle mr-2"></i> Pesan
                        </button>
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
                dp: document.querySelector('input[name="dp"]').value,
            };
    
            // Cek jika DP kurang dari 100000
            if (formData.dp < 100000) {
                Swal.fire({
                    icon: 'error',
                    title: 'DP yang anda bayar kurang',
                    text: 'Minimal DP yang harus dibayar adalah Rp 100.000!',
                });
                return; // Berhenti proses jika DP kurang
            }
    
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
