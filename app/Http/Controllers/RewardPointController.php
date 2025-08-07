<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RewardPoint;
use App\Models\Pemesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RewardPointController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rewards = RewardPoint::where('user_id', $user->id)->get();

        return view('reward.index', compact('rewards'));
    }
    private function hitungTotalBermain($idr)
    {
        $hasil = [
            'lapangan_1_3' => 0,
            'lapangan_4_5' => 0,
        ];

        // Coba pecah cashback menjadi kombinasi bermain di Lapangan 1-3 dan 4-5
        for ($lapangan_4_5 = 0; $lapangan_4_5 <= ($idr / 40_000); $lapangan_4_5++) {
            $sisa = $idr - ($lapangan_4_5 * 40_000);

            if ($sisa % 30_000 == 0) {
                $hasil['lapangan_1_3'] = $sisa / 30_000;
                $hasil['lapangan_4_5'] = $lapangan_4_5;
                return $hasil; // Ambil kombinasi pertama yang valid
            }
        }

        return $hasil; // Jika tidak ada kombinasi valid, kembalikan 0 semua
    }
    public function invoice($id)
    {
        $reward = RewardPoint::with('user')->findOrFail($id);

        // if ($reward->point < 10) {
        //     return redirect()->back()->with('error', 'Anda harus memiliki minimal 10 point untuk mencetak invoice');
        // }

        // Hitung total bermain di setiap lapangan
        $totalBermain = $this->hitungTotalBermain($reward->idr);

        return view('reward.invoice', compact('reward', 'totalBermain'));
    }
    public function downloadInvoice($id)
    {
        try {
            $reward = RewardPoint::findOrFail($id);

            if ($reward->point < 1) {
                return redirect()->back()->with('error', 'Anda harus memiliki minimal 10 point untuk mencetak invoice');
            }

            $totalBermain = $this->hitungTotalBermain($reward->idr);
            
            $pdf = Pdf::loadView('reward.invoice', compact('reward', 'totalBermain'));
            $pdf->setPaper('a4', 'portrait');
            ini_set('memory_limit', '256M');

            return $pdf->download('invoice_' . $reward->kode_voucher . '.pdf', [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice_' . $reward->kode_voucher . '.pdf"'
            ]);

        } catch (\Exception $e) {
            Log::error('PDF Download Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return dengan redirect dan flash message
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengunduh invoice. Silakan coba lagi.');
        }
    }
}

