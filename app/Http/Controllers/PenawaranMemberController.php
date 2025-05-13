<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;
use App\Models\Member;
use Carbon\Carbon;

class PenawaranMemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Hitung jumlah pemesanan yang berhasil (status 'lunas')
        $bookingCount = Pemesanan::where('user_id', $user->id)
            ->where('status', 'lunas')
            ->count();

        // Ambil data member jika ada
       $member = Member::where('user_id', $user->id)->latest()->first();


        // Inisialisasi penawaran
        $showMembershipOffer = false;
        $showRenewalOffer = false;

        if ($member) {
            // Jika tanggal berakhir sudah lewat
            if (Carbon::parse($member->tanggal_berakhir)->isPast()) {
                // Ubah status ke non-aktif jika masih aktif
                if ($member->status === 'aktif') {
                    $member->status = 'non-aktif';
                    $member->save();
                }

                // Tampilkan penawaran perpanjangan
                $showRenewalOffer = true;
            }
            // Jika sudah punya member (aktif/non-aktif), tidak usah tawarkan member baru
            $showMembershipOffer = false;
        } else {
            // Jika belum pernah jadi member dan sudah booking minimal 1x, tawarkan jadi member
            if ($bookingCount >= 1) {
                $showMembershipOffer = true;
            }
        }

        return view('dashboard', compact(
            'user',
            'bookingCount',
            'showMembershipOffer',
            'showRenewalOffer',
            'member'
        ));
    }
}
