@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="container">
    <h2>Detail Pemesanan Saya</h2>
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle bg-white">
            <thead>
                <tr>
                    <th>Kode Pemesanan</th>
                    <th>Nama Tim</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Lapangan</th>
                    <th>DP</th>
                    <th>Sisa Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedPemesanan as $kodePemesanan => $pemesans)
                    @foreach($pemesans as $pesan)
                        <tr>
                            @if ($loop->first) <!-- Hanya tampilkan data kode pemesanan sekali -->
                                <td rowspan="{{ count($pemesans) }}">{{ $pesan->kode_pemesanan }}</td>
                                <td rowspan="{{ count($pemesans) }}">{{ $pesan->nama_tim }}</td>
                                <td rowspan="{{ count($pemesans) }}">{{ $pesan->tanggal }}</td>
                                <td rowspan="{{ count($pemesans) }}">{{ $pesan->jam_mulai }}</td>
                                <td rowspan="{{ count($pemesans) }}">{{ $pesan->jam_selesai }}</td>
                                <td rowspan="{{ count($pemesans) }}">{{ $pesan->jadwal->lapangan }}</td>
                                <td rowspan="{{ count($pemesans) }}">Rp{{ number_format($pesan->dp, 0, ',', '.') }}</td>
                                <td rowspan="{{ count($pemesans) }}">Rp{{ number_format($pesan->sisa_bayar, 0, ',', '.') }}</td>
                                <td rowspan="{{ count($pemesans) }}">
                                    <span class="badge {{ $pesan->status == 'lunas' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($pesan->status) }}
                                    </span>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
