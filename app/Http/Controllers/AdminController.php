<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
