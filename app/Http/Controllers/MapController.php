<?php
// app/Http/Controllers/MapController.php

namespace App\Http\Controllers;

use App\Models\Tanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini ditambahkan

class MapController extends Controller
{
    // Tampilkan map dengan marker user yang aktif
    public function index()
    {
        $users = Tanding::with('user') // <-- Menambahkan relasi user
            ->where('location_active', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('map.index', compact('users'));
    }


    // Simpan lokasi user
    public function updateLocation(Request $request)
    {
        $user = Auth::user();

        // Validasi logo tim jika ada
        $request->validate([
            'logo_tim' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        // Format nomor WA
        $whatsappNumber = $request->whatsapp_number;
        if (substr($whatsappNumber, 0, 1) === '0') {
            $whatsappNumber = '62' . substr($whatsappNumber, 1);
        }

        // Cek apakah ada file logo_tim diupload
        $logoPath = null;
        if ($request->hasFile('logo_tim')) {
            $logoPath = $request->file('logo_tim')->store('logos', 'public');
        }

        // Ambil data sebelumnya jika ada (untuk update logo kalau tidak upload baru)
        $existingTanding = Tanding::where('user_id', $user->id)->first();

        Tanding::updateOrCreate(
            ['user_id' => $user->id],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'whatsapp_number' => $whatsappNumber,
                'location_active' => $request->location_active == 'on' ? true : false,
                'logo_tim' => $logoPath ?? $existingTanding?->logo_tim,
            ]
        );

        // Pesan sukses
        $message = $request->location_active == 'on'
            ? 'Lokasi berhasil diaktifkan.'
            : 'Lokasi berhasil dimatikan.';

        return back()->with('success', $message);
    }
}
