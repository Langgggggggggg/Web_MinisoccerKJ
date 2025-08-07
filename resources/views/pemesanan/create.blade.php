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
                <form id="bookingForm">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-calendar-alt mr-2"></i> Tanggal:
                            </label>
                            <input type="date" name="tanggal" id="tanggal"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required autocomplete="off" onchange="updateAvailableHours()">
                        </div>

                        <div>
                            <label for="lapangan" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-futbol mr-2"></i> Lapangan:
                            </label>
                            <select name="lapangan" id="lapangan"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required onchange="updateAvailableHours()">
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
                            </select>
                        </div>
                    </div>
                    <!-- Tambahkan tampilan harga di sini -->
                    <div id="hargaInfo" class="mb-6 hidden">
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                            <p class="font-semibold">Total Harga Sewa: <span id="hargaTotalText">Rp 0</span></p>
                            <p class="text-sm" id="hargaPerJamText"></p>
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
                            required placeholder="Minimal DP Rp 100.000" onchange="updateBiayaTambahan()">
    
                        <!-- Tambahkan div untuk informasi biaya -->
                        <div id="biayaInfoContainer" class="mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">DP yang dibayar:</span>
                                    <span id="dpAmount" class="font-medium">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Biaya tambahan (0.7%):</span>
                                    <span id="biayaTambahanAmount" class="font-medium text-emerald-600">Rp 0</span>
                                </div>
                                <div class="border-t border-gray-200 mt-2 pt-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-800 font-medium">Total yang dibayar:</span>
                                        <span id="totalAmount" class="font-bold text-emerald-700">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6 flex justify-end space-x-2">
                        <button type="button"
                            class="bg-emerald-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-emerald-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50"
                            id="btnPesan">
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
    <!-- script Snap.js ke production -->
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <!-- script Snap.js ke sandbox -->
    {{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"> --}}
    </script>
    <script>
        document.getElementById('btnPesan').addEventListener('click', function() {
            // Ambil data form
            let formData = {
                tanggal: document.querySelector('input[name="tanggal"]').value,
                lapangan: document.querySelector('select[name="lapangan"]').value,
                jam_mulai: document.querySelector('select[name="jam_mulai"]').value,
                jam_selesai: document.querySelector('select[name="jam_selesai"]').value,
                nama_tim: document.querySelector('input[name="nama_tim"]').value,
                no_telepon: document.querySelector('input[name="no_telepon"]').value,
                dp: parseInt(document.querySelector('input[name="dp"]').value),
            };

            // Validasi frontend
            if (!formData.tanggal || !formData.lapangan || !formData.jam_mulai || !formData.jam_selesai || !formData.nama_tim || !formData.no_telepon || !formData.dp) {
                Swal.fire('Gagal!', 'Semua field wajib diisi.', 'error');
                return;
            }
            if (formData.dp < 10000) {
                Swal.fire('Gagal!', 'Minimal DP Rp 100.000!', 'error');
                return;
            }

            fetch("/pemesanan/validateSchedule", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({
                    tanggal: formData.tanggal,
                    lapangan: formData.lapangan,
                    jam_mulai: formData.jam_mulai,
                    jam_selesai: formData.jam_selesai
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    Swal.fire('Gagal!', data.message || 'Jadwal tidak tersedia.', 'error');
                    throw new Error(data.message || 'Jadwal tidak tersedia.');
                }

                // Jika valid, lanjut proses booking seperti biasa
                const biayaTambahan = Math.ceil(formData.dp * 0.007); // Hitung biaya tambahan 0.7%
                const totalBayar = formData.dp + biayaTambahan; // Total yang akan ditampilkan ke Snap Midtrans

                Swal.fire({
                    icon: 'info',
                    title: 'Mohon Tunggu',
                    text: `Sedang memproses pembayaran...`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                return fetch("/pemesanan/store", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify(formData),
                })
                .then(async response => {
                    if (!response.ok) {
                        let err = await response.json();
                        throw new Error(err.error || 'Gagal menyimpan pemesanan.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        Swal.fire('Gagal!', data.error || 'Gagal menyimpan pemesanan.', 'error');
                        throw new Error(data.error || 'Gagal menyimpan pemesanan.');
                    }
                    // Setelah tersimpan, lanjut Snap Midtrans
                    return fetch("/pemesanan/getSnapToken", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            order_id: data.kode_pemesanan,
                            dp: totalBayar, // Kirim total bayar ke Snap Midtrans
                            nama_tim: data.nama_tim,
                            no_telepon: data.no_telepon,
                            lapangan: data.lapangan,
                            tanggal: data.tanggal,
                            jam_mulai: data.jam_mulai,
                            jam_selesai: data.jam_selesai,
                        })
                    });
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (!data.snapToken) {
                        Swal.fire('Gagal!', 'Gagal mendapatkan token pembayaran.', 'error');
                        return;
                    }
                    snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            Swal.fire('Berhasil!', 'Pembayaran berhasil.', 'success').then(() => {
                                window.location.href = "{{ route('pemesanan.detail') }}?success=1";
                            });
                        },
                        onPending: function(result) {
                            Swal.fire('Menunggu Pembayaran', 'Pembayaran sedang dalam proses.',
                                'info');
                        },
                        onError: function(result) {
                            Swal.fire('Gagal!', 'Pembayaran gagal. Coba lagi!', 'error').then(
                                () => {
                                    window.location.href =
                                        "{{ route('pemesanan.detail') }}?error=1";
                                });
                        }
                    });
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire('Gagal!', error.message, 'error');
                    console.error("Error:", error);
                });
            })
            .catch(error => {
                // Sudah ditangani di atas
            });
        });

        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function hitungHarga() {
            const lapangan = document.querySelector('select[name="lapangan"]').value;
            const jamMulai = document.querySelector('select[name="jam_mulai"]').value;
            const jamSelesai = document.querySelector('select[name="jam_selesai"]').value;

            if (!lapangan || !jamMulai || !jamSelesai) {
                document.getElementById('hargaInfo').classList.add('hidden');
                return;
            }

            const mulai = parseInt(jamMulai.split(':')[0]);
            const selesai = parseInt(jamSelesai.split(':')[0]);
            let durasi = selesai - mulai;
            if (durasi <= 0) {
                document.getElementById('hargaInfo').classList.add('hidden');
                return;
            }

            let hargaTotal = 0;
            let hargaPerJamArr = [];
            for (let i = 0; i < durasi; i++) {
                let jam = mulai + i;
                let hargaPerJam = 0;
                if (lapangan >= 1 && lapangan <= 3) {
                    hargaPerJam = (jam >= 7 && jam < 17) ? 300000 : 350000;
                } else if (lapangan >= 4 && lapangan <= 5) {
                    hargaPerJam = (jam >= 7 && jam < 17) ? 400000 : 450000;
                }
                hargaTotal += hargaPerJam;
                hargaPerJamArr.push(`Jam ${jam}:00 - ${jam+1}:00 = ${formatRupiah(hargaPerJam)}`);
            }

            document.getElementById('hargaTotalText').innerText = formatRupiah(hargaTotal);
            document.getElementById('hargaPerJamText').innerHTML = hargaPerJamArr.join('<br>');
            document.getElementById('hargaInfo').classList.remove('hidden');
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
                    body: JSON.stringify({
                        tanggal,
                        lapangan
                    })
                })
                .then(response => response.json())
                .then(bookedSchedules => {
                    const jamMulaiSelect = document.getElementById('jam_mulai');
                    const jamSelesaiSelect = document.getElementById('jam_selesai');

                    // Reset semua options
                    Array.from(jamMulaiSelect.options).forEach(option => {
                        if (option.value) {
                            option.disabled = false;
                            option.title = '';
                        }
                    });
                    Array.from(jamSelesaiSelect.options).forEach(option => {
                        if (option.value) {
                            option.disabled = false;
                            option.title = '';
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

        function updateJamSelesai() {
            const jamMulaiSelect = document.getElementById('jam_mulai');
            const jamSelesaiSelect = document.getElementById('jam_selesai');
            const selectedJamMulai = jamMulaiSelect.value;

            // Reset jam selesai
            jamSelesaiSelect.innerHTML = '<option value="" disabled selected>Pilih Jam Selesai</option>';

            if (selectedJamMulai) {
                const jamMulai = parseInt(selectedJamMulai.split(':')[0]);
                
                // Tambahkan opsi jam selesai mulai dari jam berikutnya sampai 23:00
                for (let i = jamMulai + 1; i <= 23; i++) {
                    const option = document.createElement('option');
                    option.value = `${String(i).padStart(2, '0')}:00`;
                    option.textContent = `${String(i).padStart(2, '0')}:00`;
                    jamSelesaiSelect.appendChild(option);
                }
            }

            // Update tampilan harga setelah mengubah jam
            hitungHarga();
        }

        // Event listener untuk select
        ['lapangan', 'jam_mulai', 'jam_selesai'].forEach(id => {
            document.getElementById(id).addEventListener('change', hitungHarga);
        });

        // Tambahkan event listener untuk jam_mulai
        document.getElementById('jam_mulai').addEventListener('change', updateJamSelesai);

        function updateBiayaTambahan() {
            const dpInput = document.getElementById('dpInput');
            const dp = parseInt(dpInput.value) || 0;
            const biayaTambahan = Math.ceil(dp * 0.007);
            const total = dp + biayaTambahan;

            // Update tampilan
            document.getElementById('dpAmount').innerText = `Rp ${formatRupiah(dp)}`;
            document.getElementById('biayaTambahanAmount').innerText = `Rp ${formatRupiah(biayaTambahan)}`;
            document.getElementById('totalAmount').innerText = `Rp ${formatRupiah(total)}`;

            // Tampilkan/sembunyikan container berdasarkan input
            const container = document.getElementById('biayaInfoContainer');
            container.style.display = dp > 0 ? 'block' : 'none';
        }

        // Inisialisasi
        document.getElementById('biayaInfoContainer').style.display = 'none';
        
        // Tambahkan event listener untuk input real-time
        document.getElementById('dpInput').addEventListener('input', updateBiayaTambahan);

        function setMinDate() {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate()); // Menggunakan tanggal hari ini
            
            // Format tanggal ke YYYY-MM-DD
            const formattedDate = tomorrow.toISOString().split('T')[0];
            
            // Set min attribute pada input tanggal
            const tanggalInput = document.getElementById('tanggal');
            tanggalInput.setAttribute('min', formattedDate);
            
            // Disable tanggal yang sudah lewat
            tanggalInput.addEventListener('input', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal Tidak Valid',
                        text: 'Tidak dapat memilih tanggal yang sudah lewat!'
                    });
                    this.value = formattedDate;
                }
            });
        }

        // Panggil fungsi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            setMinDate();
        });
    </script>
@endsection
