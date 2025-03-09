<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pemesanan
        </h2>
    </x-slot>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="card-title">Form Pemesanan Lapangan</h2>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/pemesanan/store" method="POST" id="bookingForm">
                    @csrf

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal:</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="lapangan" class="form-label">Lapangan:</label>
                        <select name="lapangan" class="form-select" required>
                            <option value="" disabled selected>Pilih Lapangan</option>
                            <option value="1">Lapangan 1</option>
                            <option value="2">Lapangan 2</option>
                            <option value="3">Lapangan 3</option>
                            <option value="4">Lapangan 4</option>
                            <option value="5">Lapangan 5</option>
                        </select>
                    </div>


                    <div class="mb-3 w-25">
                        <label for="jam_mulai" class="form-label">Jam Mulai:</label>
                        <input type="time" name="jam_mulai" class="form-control" required>
                    </div>

                    <div class="mb-3 w-25">
                        <label for="jam_selesai" class="form-label">Jam Selesai:</label>
                        <input type="time" name="jam_selesai" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_tim" class="form-label">Nama Tim:</label>
                        <input type="text" name="nama_tim" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_tim" class="form-label">No_telepon</label>
                        <input type="text" name="no_telepon" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="dp" class="form-label">DP (Rp):</label>
                        <input type="number" name="dp" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" onclick="processPayment()">Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        function processPayment() {
            let dpAmount = document.querySelector('input[name="dp"]').value; // Ambil nilai DP

            // Kirim permintaan ke server untuk mendapatkan snapToken
            fetch("/pemesanan/getSnapToken", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        dp: dpAmount,
                        nama_tim: document.querySelector('input[name="nama_tim"]').value,
                        no_telepon: document.querySelector('input[name="no_telepon"]').value,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            console.log("Success:", result);
                            document.getElementById('bookingForm').submit();
                        },
                        onPending: function(result) {
                            console.log("Pending:", result);
                            alert("Menunggu pembayaran...");
                        },
                        onError: function(result) {
                            console.log("Error:", result);
                            alert("Pembayaran gagal! Cek console log untuk detail.");
                        }
                    });
                })
                .catch(error => console.error("Error:", error));
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
