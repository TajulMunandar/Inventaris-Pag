<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanBulananController extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now();
        $peminjamans = Peminjaman::with('barangs', 'users')->whereYear('created_at', $currentDate->year)
            ->whereMonth('created_at', $currentDate->month)
            ->get();
        return view('dashboard.laporan-bulanan.index', [
            'title' => "Tabel Laporan Bulanan"
        ])->with(compact('peminjamans'));
    }
}
