<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\NotifikasiHelper;

class RefundAdminController extends Controller
{
    public function index()
    {
        $refunds = Refund::with(['user', 'pemesanan'])->latest()->get();
        return view('admin.refunds.index', compact('refunds'));
    }

    public function show($id)
    {
        $refund = Refund::with(['user', 'pemesanan'])->findOrFail($id);
        return view('admin.refunds.show', compact('refund'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $refund = Refund::with('pemesanan')->findOrFail($id);
        $pemesanan = $refund->pemesanan;

        if (!$pemesanan) {
            return back()->with('error', 'Data pemesanan tidak ditemukan.');
        }

        // Upload bukti transfer
        $path = $request->file('bukti_transfer')->store('refunds', 'public');

        // Update refund status dan simpan bukti
        $refund->update([
            'status' => 'disetujui',
            'bukti_transfer' => $path,
        ]);

        // Kirim notifikasi WhatsApp
        NotifikasiHelper::kirimNotifikasiRefundDiSetujui($refund);

        // Hapus pemesanan
        $pemesanan->delete();

        return redirect()->route('admin.refunds.index')->with('success', 'Refund disetujui dan data pemesanan telah dihapus.');
    }



    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string'
        ]);

        $refund = Refund::findOrFail($id);
        $refund->update([
            'status' => 'ditolak',
            'alasan' => $request->alasan
        ]);

        return redirect()->route('admin.refunds.index')->with('success', 'Refund ditolak.');
    }
}
