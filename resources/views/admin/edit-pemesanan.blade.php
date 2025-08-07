@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-md shadow-md">
        <h2 class="text-2xl font-bold mb-4">
            <i class="fas fa-edit mr-2"></i> Ubah Jadwal Pemesanan
        </h2>

        <form action="{{ route('admin.updatePemesanan', $pemesanan->id) }}" method="POST">
            @csrf
        

            <div class="mb-4">
                <label for="tanggal" class="block font-medium">
                    <i class="fas fa-calendar-alt mr-2"></i> Tanggal
                </label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $pemesanan->tanggal) }}"
                    class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="lapangan" class="block font-medium">
                    <i class="fas fa-futbol mr-2"></i> Lapangan
                </label>
                <select name="lapangan" class="w-full px-4 py-2 border rounded-md" required>
                    <option value="1" {{ old('lapangan', $pemesanan->lapangan) == 1 ? 'selected' : '' }}>Lapangan 1</option>
                    <option value="2" {{ old('lapangan', $pemesanan->lapangan) == 2 ? 'selected' : '' }}>Lapangan 2</option>
                    <option value="3" {{ old('lapangan', $pemesanan->lapangan) == 3 ? 'selected' : '' }}>Lapangan 3</option>
                    <option value="4" {{ old('lapangan', $pemesanan->lapangan) == 4 ? 'selected' : '' }}>Lapangan 4</option>
                    <option value="5" {{ old('lapangan', $pemesanan->lapangan) == 5 ? 'selected' : '' }}>Lapangan 5</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="jam_mulai" class="block font-medium">
                    <i class="fas fa-clock mr-2"></i> Jam Mulai
                </label>
               <select name="jam_mulai" id="jam_mulai"
                    class="w-full border px-3 py-2 rounded @error('jam_mulai') border-red-500 @enderror" required>
                    <option value="" disabled>Pilih Jam Mulai</option>
                    @for ($i = 7; $i <= 22; $i++)
                        <option value="{{ sprintf('%02d:00', $i) }}"
                            {{ sprintf('%02d:00', $i) == old('jam_mulai', $pemesanan->jam_mulai) ? 'selected' : '' }}>
                            {{ sprintf('%02d:00', $i) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label for="jam_selesai" class="block font-medium">
                    <i class="fas fa-clock mr-2"></i> Jam Selesai
                </label>
              <select name="jam_selesai" id="jam_selesai"
                    class="w-full border px-3 py-2 rounded @error('jam_selesai') border-red-500 @enderror" required>
                    <option value="" disabled>Pilih Jam Selesai</option>
                    @for ($i = 8; $i <= 23; $i++)
                        <option value="{{ sprintf('%02d:00', $i) }}"
                            {{ sprintf('%02d:00', $i) == old('jam_selesai', $pemesanan->jam_selesai) ? 'selected' : '' }}>
                            {{ sprintf('%02d:00', $i) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label for="nama_tim" class="block font-medium">
                    <i class="fas fa-user mr-2"></i> Nama Tim
                </label>
                <input type="text" name="nama_tim" value="{{ old('nama_tim', $pemesanan->nama_tim) }}"
                    class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="no_telepon" class="block font-medium">
                    <i class="fas fa-phone mr-2"></i> Nomor Telepon
                </label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', $pemesanan->no_telepon) }}"
                    class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.data-pemesanan') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                    <i class="fas fa-ban mr-2"></i> Batal
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
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

    <script>
        // Validasi tanggal agar tidak bisa pilih tanggal yang sudah lewat
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalInput = document.querySelector('input[name="tanggal"]');
            if (tanggalInput) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const formattedDate = today.toISOString().split('T')[0];
                tanggalInput.setAttribute('min', formattedDate);

                tanggalInput.addEventListener('input', function() {
                    const selectedDate = new Date(this.value);
                    selectedDate.setHours(0, 0, 0, 0);
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
        });

        function updateAvailableHours() {
            const tanggal = document.querySelector('input[name="tanggal"]').value;
            const lapangan = document.querySelector('select[name="lapangan"]').value;
            const currentPemesananId = "{{ $pemesanan->id }}"; // Untuk mengecualikan pemesanan saat ini
            
            if (!tanggal || !lapangan) return;

            fetch('/admin/pemesanan/getBookedSchedules', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    tanggal, 
                    lapangan,
                    current_id: currentPemesananId 
                })
            })
            .then(response => response.json())
            .then(bookedSchedules => {
                const jamMulaiSelect = document.querySelector('select[name="jam_mulai"]');
                const jamSelesaiSelect = document.querySelector('select[name="jam_selesai"]');

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

        // Tambahkan event listeners
        document.querySelector('input[name="tanggal"]').addEventListener('change', updateAvailableHours);
        document.querySelector('select[name="lapangan"]').addEventListener('change', updateAvailableHours);

        // Panggil fungsi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', updateAvailableHours);
    </script>
@endsection

