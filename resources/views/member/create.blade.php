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
            <form id="bookingFormMember" autocomplete="off" class="p-6">
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
                                    <label for="tanggal_{{ $i }}"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                    <input type="date" name="tanggal[]" id="tanggal_{{ $i }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                        onchange="updateAvailableHoursMember({{ $i }})">
                                </div>
                                <div>
                                    <label for="jam_mulai_{{ $i }}"
                                        class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                                    <select name="jam_mulai[]" id="jam_mulai_{{ $i }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                        onchange="updateJamSelesaiMember({{ $i }})">
                                        <option value="">Pilih Jam Mulai</option>
                                        @for ($hour = 7; $hour <= 22; $hour++)
                                            <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="jam_selesai_{{ $i }}"
                                        class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                                    <select name="jam_selesai[]" id="jam_selesai_{{ $i }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                        <option value="">Pilih Jam Selesai</option>
                                    </select>
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
                        <input type="number" name="dp" id="dpInput" min="400000"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                            required placeholder="Minimal DP Rp 400.000">
                        
                        <!-- Tambahkan div untuk informasi biaya -->
                        <div id="biayaInfoContainer" class="mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200" style="display: none;">
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">DP yang dibayar:</span>
                                    <span id="dpAmount" class="font-medium">0</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Biaya tambahan (0.7%):</span>
                                    <span id="biayaTambahanAmount" class="font-medium text-emerald-600">0</span>
                                </div>
                                <div class="border-t border-gray-200 mt-2 pt-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-800 font-medium">Total yang dibayar:</span>
                                        <span id="totalAmount" class="font-bold text-emerald-700">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end space-x-2">
                    <button type="button" id="btnPesanMember"
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


<!-- script Snap.js ke production -->
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<!-- script Snap.js ke sandbox -->
{{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"> --}}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnPesan = document.getElementById('btnPesanMember');
        if (!btnPesan) return;

        btnPesan.addEventListener('click', async function() {
            // Ambil data form
            let tanggal = Array.from(document.querySelectorAll('input[name="tanggal[]"]')).map(e => e.value);
            let jam_mulai = Array.from(document.querySelectorAll('select[name="jam_mulai[]"]')).map(e => e.value);
            let jam_selesai = Array.from(document.querySelectorAll('select[name="jam_selesai[]"]')).map(e => e.value);
            let lapangan = document.querySelector('select[name="lapangan"]').value;
            let nama_tim = document.querySelector('input[name="nama_tim"]').value;
            let no_telepon = document.querySelector('input[name="no_telepon"]').value;
            let dp = parseInt(document.querySelector('input[name="dp"]').value);

            // Validasi minimal satu jadwal terisi
            let validJadwal = false;
            for (let i = 0; i < tanggal.length; i++) {
                if (tanggal[i] && jam_mulai[i] && jam_selesai[i]) {
                    validJadwal = true;
                    break;
                }
            }
            if (!validJadwal) {
                Swal.fire('Gagal!', 'Minimal satu jadwal harus diisi lengkap.', 'error');
                return;
            }

            // Validasi field utama
            if (!lapangan || !nama_tim || !no_telepon || !dp) {
                Swal.fire('Gagal!', 'Semua field wajib diisi.', 'error');
                return;
            }
            if (dp < 20000) {
                Swal.fire('Gagal!', 'Minimal DP Rp 400.000!', 'error');
                return;
            }

            // --- VALIDASI HARI LIBUR (SENIN) UNTUK SETIAP JADWAL YANG DIISI ---
            for (let i = 0; i < tanggal.length; i++) {
                if (tanggal[i] && jam_mulai[i] && jam_selesai[i]) {
                    let res = await fetch("/pemesanan/validateSchedule", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: JSON.stringify({
                            tanggal: tanggal[i],
                            lapangan: lapangan,
                            jam_mulai: jam_mulai[i],
                            jam_selesai: jam_selesai[i]
                        }),
                    });
                    let data = await res.json();
                    if (!data.success) {
                        Swal.fire('Gagal!', data.message || 'Jadwal tidak tersedia.', 'error');
                        return;
                    }
                }
            }
            // --- END VALIDASI HARI LIBUR ---

            // Hitung biaya tambahan
            const biayaTambahan = Math.ceil(dp * 0.007); // Hitung biaya tambahan 0.7%
            const totalBayar = dp + biayaTambahan; // Total yang akan ditampilkan ke Snap Midtrans

            Swal.fire({
                icon: 'info',
                title: 'Mohon Tunggu',
                text: `Sedang memproses pembayaran...`,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Kirim data ke backend via AJAX
            fetch("/pemesanan/member", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({
                    tanggal: tanggal,
                    lapangan: lapangan,
                    jam_mulai: jam_mulai,
                    jam_selesai: jam_selesai,
                    nama_tim: nama_tim,
                    no_telepon: no_telepon,
                    dp: dp
                }),
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
                        Swal.fire('Berhasil!', 'Pembayaran berhasil.', 'success')
                            .then(() => {
                                window.location.href = "{{ route('pemesanan.detail') }}?success=member";
                            });
                    },
                    onPending: function(result) {
                        Swal.fire('Menunggu Pembayaran', 'Pembayaran sedang dalam proses.', 'info');
                    },
                    onError: function(result) {
                        Swal.fire('Gagal!', 'Pembayaran gagal. Coba lagi!', 'error')
                            .then(() => {
                                window.location.href = "{{ route('pemesanan.detail') }}?error=1";
                            });
                    }
                });
            })
            .catch(error => {
                Swal.close();
                Swal.fire('Gagal!', error.message, 'error');
                console.error("Error:", error);
            });
        });

        window.updateAvailableHoursMember = function(index) {
            const tanggal = document.querySelector(`input[name="tanggal[]"][id="tanggal_${index}"]`).value;
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
                    const jamMulaiSelect = document.querySelector(
                        `select[name="jam_mulai[]"][id="jam_mulai_${index}"]`);
                    const jamSelesaiSelect = document.querySelector(
                        `select[name="jam_selesai[]"][id="jam_selesai_${index}"]`);

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
                                option.title =
                                    `Jam ${option.value} sudah dipesan oleh tim lain`;
                            }
                        });

                        // Disable jam selesai yang konflik
                        Array.from(jamSelesaiSelect.options).forEach(option => {
                            if (!option.value) return;
                            const hour = parseInt(option.value.split(':')[0]);
                            if (hour > startHour && hour <= endHour) {
                                option.disabled = true;
                                option.title =
                                    `Jam ${option.value} sudah dipesan oleh tim lain`;
                            }
                        });
                    });
                });
        }

        // Fungsi format rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        // Fungsi update biaya tambahan
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
            if (dp > 0) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        // Event listener untuk input DP
        const dpInput = document.getElementById('dpInput');
        dpInput.addEventListener('input', updateBiayaTambahan);

        // Inisialisasi - sembunyikan container biaya
        document.getElementById('biayaInfoContainer').style.display = 'none';

        // Tambahkan fungsi ini di dalam script yang sudah ada
        function updateJamSelesaiMember(index) {
            const jamMulaiSelect = document.querySelector(`select[name="jam_mulai[]"][id="jam_mulai_${index}"]`);
            const jamSelesaiSelect = document.querySelector(`select[name="jam_selesai[]"][id="jam_selesai_${index}"]`);
            const selectedJamMulai = jamMulaiSelect.value;

            // Reset jam selesai
            jamSelesaiSelect.innerHTML = '<option value="">Pilih Jam Selesai</option>';

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
        }

        // Tambahkan event listener untuk setiap jam mulai
        for (let i = 0; i < 4; i++) {
            const jamMulaiSelect = document.querySelector(`select[name="jam_mulai[]"][id="jam_mulai_${i}"]`);
            if (jamMulaiSelect) {
                jamMulaiSelect.addEventListener('change', () => updateJamSelesaiMember(i));
            }
        }
    });
</script>