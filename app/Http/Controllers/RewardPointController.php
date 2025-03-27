<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RewardPoint;
use Illuminate\Support\Facades\Auth;

class RewardPointController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rewards = RewardPoint::where('user_id', $user->id)->get();

        return view('reward.index', compact('rewards'));
    }
}

