<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;
use App\Models\Member;
use App\Models\RewardPoint;
use Carbon\Carbon;

class PenawaranMemberController extends Controller
{
    public function index()
    {
        $idr = RewardPoint::where('user_id', Auth::id())->sum('idr');
        // Hitung jumlah pemesanan yang akan datang (tanggal lebih besar dari hari ini dan status belum lunas)
        $jumlahPemesananMendatang = Pemesanan::where('user_id', Auth::id())
            ->where('tanggal', '>', Carbon::now())
            ->where('status', '!=', 'lunas')
            ->count();
        $memberStatus = Member::where('user_id', Auth::id())->latest()->value('status') ?? 'non-aktif';

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
            if ($bookingCount >= 4) {
                $showMembershipOffer = true;
            }
        }

        return view('dashboard', compact(
            'user',
            'bookingCount',
            'showMembershipOffer',
            'showRenewalOffer',
            'member',
            'idr',
            'jumlahPemesananMendatang',
            'memberStatus',
        ));
    }
    public function create()
    {
        return view('member.create');
    }
}
