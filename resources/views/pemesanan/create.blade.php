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
                <div class="flex justify-end mt-2">
                    <button type="button" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 text-sm"
                        onclick="toggleModal('hargaModal')">
                        💰 Lihat Daftar Harga
                    </button>
                </div>
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
                            <select name="jam_mulai" id="jam_mulai"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                <option value="" disabled selected>Pilih Jam Mulai</option>
                                @for ($i = 7; $i <= 22; $i++)
                                    <option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="jam_selesai" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-clock mr-2"></i> Jam Selesai:
                            </label>
                            <select name="jam_selesai" id="jam_selesai"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                <option value="" disabled selected>Pilih Jam Selesai</option>
                                @for ($i = 8; $i <= 23; $i++)
                                    <option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }}</option>
                                @endfor
                            </select>
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
    <div id="hargaModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative flex flex-col">
            <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-800" onclick="toggleModal('hargaModal')">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="text-xl font-bold mb-4 text-emerald-600">Daftar Harga Lapangan</h2>

            <div class="mb-4">
                <h3 class="font-semibold text-gray-700">Jam 07.00 - 17.00</h3>
                <ul class="list-disc list-inside text-sm text-gray-600">
                    <li>Lapangan 1, 2, 3: Rp 300.000</li>
                    <li>Lapangan 4, 5: Rp 350.000</li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-gray-700">Jam 17.00 - 23.00</h3>
                <ul class="list-disc list-inside text-sm text-gray-600">
                    <li>Lapangan 1, 2, 3: Rp 400.000</li>
                    <li>Lapangan 4, 5: Rp 450.000</li>
                </ul>
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
                jam_mulai: document.querySelector('select[name="jam_mulai"]').value,
                jam_selesai: document.querySelector('select[name="jam_selesai"]').value,
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

            const [jamMulaiHour, jamMulaiMinute] = formData.jam_mulai.split(":").map(Number);
            const [jamSelesaiHour, jamSelesaiMinute] = formData.jam_selesai.split(":").map(Number);

            // Cek menit jam mulai
            if (jamMulaiMinute !== 0) {
                const contohJamMulai = `${jamMulaiHour.toString().padStart(2, '0')}:00`;
                Swal.fire({
                    icon: 'error',
                    title: 'Jam Mulai Tidak Valid',
                    text: `Jam mulai yang Anda masukkan adalah ${formData.jam_mulai}. Jam mulai harus tepat di menit 00, misalnya ${contohJamMulai}.`,
                });
                return;
            }

            // Cek menit jam selesai
            if (jamSelesaiMinute !== 0) {
                const contohJamSelesai = `${jamSelesaiHour.toString().padStart(2, '0')}:00`;
                Swal.fire({
                    icon: 'error',
                    title: 'Jam Selesai Tidak Valid',
                    text: `Jam selesai yang Anda masukkan adalah ${formData.jam_selesai}. Jam selesai harus tepat di menit 00, misalnya ${contohJamSelesai}.`,
                });
                return;
            }

            // Cek urutan jam
            if (jamSelesaiHour <= jamMulaiHour) {
                Swal.fire({
                    icon: 'error',
                    title: 'Durasi Tidak Valid',
                    text: `Jam mulai: ${formData.jam_mulai} dan jam selesai: ${formData.jam_selesai}. Jam selesai harus lebih besar dari jam mulai.`,
                });
                return;
            }

            // Hitung durasi seperti biasa
            const jamMulai = jamMulaiHour;
            const jamSelesai = jamSelesaiHour;
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

        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        function updateAvailableHours() {
            const tanggal = document.querySelector('input[name="tanggal"]').value;
            const lapangan = document.querySelector('select[name="lapangan"]').value;
            
            if (!tanggal || !lapangan) return;

            fetch('/pemesanan/getBookedSchedules', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ tanggal, lapangan })
            })
            .then(response => response.json())
            .then(bookedSchedules => {
                const jamMulaiSelect = document.querySelector('select[name="jam_mulai"]');
                const jamSelesaiSelect = document.querySelector('select[name="jam_selesai"]');

                // Reset semua options
                Array.from(jamMulaiSelect.options).forEach(option => {
                    if (option.value) {
                        option.disabled = false;
                        option.title = ''; // Reset tooltip
                    }
                });
                Array.from(jamSelesaiSelect.options).forEach(option => {
                    if (option.value) {
                        option.disabled = false;
                        option.title = ''; // Reset tooltip
                    }
                });

                // Disable jam yang sudah dipesan
                bookedSchedules.forEach(schedule => {
                    const startHour = parseInt(schedule.start.split(':')[0]);
                    const endHour = parseInt(schedule.end.split(':')[0]);

                    // Disable jam mulai yang konflik
                    Array.from(jamMulaiSelect.options).forEach(option => {
                        if (!option.value) return;
                        const hour = parseInt(option.value.split(':')[0]);
                        if (hour >= startHour && hour < endHour) {
                            option.disabled = true;
                            option.title = `Jam ${option.value} sudah dipesan oleh tim lain`;
                        }
                    });

                    // Disable jam selesai yang konflik
                    Array.from(jamSelesaiSelect.options).forEach(option => {
                        if (!option.value) return;
                        const hour = parseInt(option.value.split(':')[0]);
                        if (hour > startHour && hour <= endHour) {
                            option.disabled = true;
                            option.title = `Jam ${option.value} sudah dipesan oleh tim lain`;
                        }
                    });
                });
            });
        }

        // Tambahkan event listeners
        document.querySelector('input[name="tanggal"]').addEventListener('change', updateAvailableHours);
        document.querySelector('select[name="lapangan"]').addEventListener('change', updateAvailableHours);
    </script>
@endsection
