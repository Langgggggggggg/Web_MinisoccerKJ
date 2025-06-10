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

            <!-- Tanggal -->
            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700">
                    <i class="fas fa-calendar-alt mr-2"></i> Tanggal
                </label>
                <input type="date" name="tanggal" id="tanggal"
                    class="w-full border px-3 py-2 rounded @error('tanggal') border-red-500 @enderror"
                    value="{{ old('tanggal', $pemesanan->tanggal) }}" 
                    min="{{ date('Y-m-d') }}" required>
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lapangan -->
            <div class="mb-4">
                <label for="lapangan" class="block text-gray-700">
                    <i class="fas fa-futbol mr-2"></i> Lapangan
                </label>
                <select name="lapangan" id="lapangan"
                    class="w-full border px-3 py-2 rounded @error('lapangan') border-red-500 @enderror" required>
                    @php
                        $lapangans = [1, 2, 3, 4, 5];
                    @endphp
                    @foreach ($lapangans as $lap)
                        <option value="{{ $lap }}"
                            {{ $lap == old('lapangan', $pemesanan->lapangan) ? 'selected' : '' }}>
                            Lapangan {{ $lap }}
                        </option>
                    @endforeach
                </select>
                @error('lapangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Mulai -->
            <div class="mb-4">
                <label for="jam_mulai" class="block text-gray-700">
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
                @error('jam_mulai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Selesai -->
            <div class="mb-4">
                <label for="jam_selesai" class="block text-gray-700">
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
                @error('jam_selesai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Tim -->
            <div class="mb-4">
                <label for="nama_tim" class="block text-gray-700">
                    <i class="fas fa-users mr-2"></i> Nama Tim
                </label>
                <input type="text" name="nama_tim" id="nama_tim"
                    class="w-full border px-3 py-2 rounded @error('nama_tim') border-red-500 @enderror"
                    value="{{ old('nama_tim', $pemesanan->nama_tim) }}" required>
                @error('nama_tim')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- No Telepon -->
            <div class="mb-4">
                <label for="no_telepon" class="block text-gray-700">
                    <i class="fas fa-phone mr-2"></i> No Telepon
                </label>
                <input type="text" name="no_telepon" id="no_telepon"
                    class="w-full border px-3 py-2 rounded @error('no_telepon') border-red-500 @enderror"
                    value="{{ old('no_telepon', $pemesanan->no_telepon) }}" required>
                @error('no_telepon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol aksi -->
            <div class="flex justify-end">
                <a href="{{ route('pemesanan.detail') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2 flex items-center">
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
    
    <script>
        function updateAvailableHours() {
            const tanggal = document.querySelector('input[name="tanggal"]').value;
            const lapangan = document.querySelector('select[name="lapangan"]').value;
            const currentKodePemesanan = '{{ $pemesanan->kode_pemesanan }}';
            
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
                        option.title = '';
                    }
                });
                Array.from(jamSelesaiSelect.options).forEach(option => {
                    if (option.value) {
                        option.disabled = false;
                        option.title = '';
                    }
                });

                // Disable jam yang sudah dipesan (kecuali jadwal pemesanan saat ini)
                bookedSchedules.forEach(schedule => {
                    if (schedule.kode_pemesanan !== currentKodePemesanan) {
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
                    }
                });
            });
        }

        // Add event listeners
        document.querySelector('input[name="tanggal"]').addEventListener('change', updateAvailableHours);
        document.querySelector('select[name="lapangan"]').addEventListener('change', updateAvailableHours);

        // Initial load
        updateAvailableHours();
    </script>

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
