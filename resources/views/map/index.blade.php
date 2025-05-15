@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <div class="container mt-4">
        <div class="row g-4">
            {{-- CARD UNTUK FORM --}}
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <strong>Status Tanding</strong>
                    </div>
                    <div class="card-body">
                        <form id="locationForm" method="POST" action="{{ route('map.update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Masukan No WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" name="whatsapp_number"
                                        value="{{ auth()->user()->tanding?->whatsapp_number }}" class="form-control"
                                        placeholder="081234567890" required>
                                </div>
                                <small class="form-text text-muted">Nomor WhatsApp ini akan ditampilkan di titik lokasi
                                    Anda, agar lawan main dapat menghubungi Anda.</small>
                            </div>

                            {{-- Tambahan: Upload logo tim --}}
                            <div class="mb-3">
                                <input type="file" name="logo_tim" class="form-control" accept="image/*">
                                <label class="form-label form-text text-muted">Masukan Logo Tim anda agar ditampilkan di Titik Lokasi</label>
                                @if (auth()->user()->tanding?->logo_tim)
                                    <img src="{{ asset('storage/' . auth()->user()->tanding->logo_tim) }}" alt="Logo Tim"
                                        class="img-thumbnail mt-2" width="100">
                                @endif
                            </div>

                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <input type="hidden" id="location_active" name="location_active">

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success" onclick="submitForm(true)">
                                    <i class="bi bi-geo-fill me-1"></i> Aktifkan Lokasi & Siap Tanding
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="submitForm(false)">
                                    <i class="bi bi-geo-alt-slash me-1"></i> Nonaktifkan Lokasi
                                </button>
                            </div>
                        </form>


                        {{-- STATUS --}}
                        <div class="alert alert-{{ auth()->user()->tanding?->location_active ? 'success' : 'secondary' }}"
                            role="alert">
                            Status:
                            <strong>{{ auth()->user()->tanding?->location_active ? 'Siap Tanding' : 'Tidak Aktif' }}</strong>
                        </div>

                    </div>
                </div>
            </div>

            {{-- CARD UNTUK MAP --}}
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <strong>Peta Lokasi Tim</strong>
                    </div>
                    <div class="card-body p-0">
                        <div id="map" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        mapboxgl.accessToken = '{{ env('MAPBOX_KEY') }}';

        // Ambil lokasi saat halaman dimuat
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;

            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [position.coords.longitude, position.coords.latitude],
                zoom: 11
            });

            const users = @json($users);
            users.forEach(user => {
                const popup = new mapboxgl.Popup().setHTML(`
                <strong>${user.user.name}</strong><br>
                <a href="https://wa.me/${user.whatsapp_number}" target="_blank">Chat WhatsApp</a>
            `);

                const el = document.createElement('div');
                el.className = 'custom-marker';
                el.style.backgroundImage = `url('/storage/${user.logo_tim}')`;
                el.style.backgroundSize = 'cover';
                el.style.width = '60px';
                el.style.height = '60px';
                el.style.borderRadius = '50%';
                el.style.border = user.id === {{ auth()->id() }} ? '3px solid #007bff' :
                    '';

                new mapboxgl.Marker(el)
                    .setLngLat([user.longitude, user.latitude])
                    .setPopup(popup)
                    .addTo(map);

            });

        }, function() {
            Swal.fire('Gagal Mengambil Lokasi', 'Pastikan Anda mengizinkan akses lokasi.', 'error');
        });

        function submitForm(statusAktif) {
            document.getElementById('location_active').value = statusAktif ? 'on' : '';
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mengambil lokasi dan menyimpan data...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            setTimeout(() => document.getElementById('locationForm').submit(), 1000);
        }

        // Jika sukses dari session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        @endif
    </script>
@endsection
