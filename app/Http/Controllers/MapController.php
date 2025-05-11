<?php
// app/Http/Controllers/MapController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Pastikan ini ditambahkan

class MapController extends Controller
{
    // Tampilkan map dengan marker user yang aktif
    public function index()
    {
        $users = User::where('location_active', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('map.index', compact('users'));
    }

    // Simpan lokasi user
    public function updateLocation(Request $request)
    {
        $user = Auth::user();

        // Format nomor WA
        $whatsappNumber = $request->whatsapp_number;
        if (substr($whatsappNumber, 0, 1) === '0') {
            $whatsappNumber = '62' . substr($whatsappNumber, 1);
        }

        // Simpan data
        User::updateOrCreate(
            ['id' => $user->id],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'whatsapp_number' => $whatsappNumber,
                'location_active' => $request->location_active == 'on' ? true : false,
            ]
        );

        // Tentukan pesan sukses berdasarkan status lokasi
        $message = $request->location_active == 'on'
            ? 'Lokasi berhasil diaktifkan.'
            : 'Lokasi berhasil dimatikan.';

        return back()->with('success', $message);
    }
}
