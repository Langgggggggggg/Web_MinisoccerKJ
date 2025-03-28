@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[27rem] md:w-full xl:w-full">
        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600">
                    <tr class="text-white">
                        <th class="px-4 py-2 border-b">Nama Tim</th>
                        <th class="px-4 py-2 border-b">Point</th>
                        <th class="px-4 py-2 border-b">Nominal Cashback</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rewards as $reward)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b">{{ $reward->nama_tim }}</td>
                            <td class="px-4 py-2 border-b">{{ $reward->point }}</td>
                            <td class="px-4 py-2 border-b">Rp{{ number_format($reward->idr, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('reward.download-invoice', $reward->id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded">
                                    Cetak Invoice
                                </a>
                                <button onclick="openModal({{ $reward->id }})"
                                    class="bg-green-500 text-white px-3 py-1 rounded ml-2">
                                    Lihat Invoice
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-gray-500">Anda belum memiliki point</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="invoiceModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white p-6 rounded shadow-lg w-[40rem] relative">
            <button id="closeModal" class="bg-red-500 text-white px-2 py-1 rounded absolute top-2 right-2">X</button>
            <div id="modalContent">
                <!-- Konten invoice akan dimuat di sini -->
            </div>
        </div>
    </div>

    <script>
        function openModal(rewardId) {
            fetch(`/reward-points/invoice/${rewardId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('modalContent').innerHTML = html;
                    document.getElementById('invoiceModal').style.display = "flex";
                });
        }

        function closeModal() {
            document.getElementById('invoiceModal').style.display = "none";
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("closeModal").addEventListener("click", closeModal);
        });
    </script>
@endsection
