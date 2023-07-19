<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanMingguanController extends Controller
{
    public function index()
    {
        $currentStartWeek = Carbon::now()->startOfWeek();
        $currentEndWeek = Carbon::now()->endOfWeek();

        $peminjamans = Peminjaman::with('barangs', 'users')
            ->whereBetween('created_at', [$currentStartWeek, $currentEndWeek])
            ->get();
        return view('dashboard.laporan-mingguan.index', [
            'title' => "Tabel Laporan Mingguan"
        ])->with(compact('peminjamans'));
    }
}
