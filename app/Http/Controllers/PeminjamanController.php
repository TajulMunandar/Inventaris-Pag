<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::where('qty', '>=', 1)->get();
        $users = User::all();
        if (auth()->user()->isAdmin == 0) {
            $peminjamans = Peminjaman::with('users', 'barangs')
                ->where('status', 1)
                ->orderBy('isApprove', 'asc')
                ->get();
        } else {
            $peminjamans = Peminjaman::with('users', 'barangs')->where('userId', auth()->user()->id)->where('status', 1)->get();
        }
        return view('dashboard.peminjaman.index', [
            'title' => "Tabel Peminjaman"
        ])->with(compact('peminjamans', 'users', 'barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = Carbon::now();
        $validatedData = $request->validate([
            'barangId' => 'required',
            'userId' => 'required',
            'qty' => 'required|numeric|min:1',
            'deskripsi' => 'required',
            'status' => 'numeric',
            'tgl_pinjam' => 'date'
        ]);

        $barang = Barang::find($request->barangId);

        if ($barang) {
            $requestedQty = $request->qty;

            if ($requestedQty > $barang->qty) {
                return redirect()->back()->with('failed', 'Stok barang tidak cukup!');
            }

            $validatedData = $request->except('qty');
            $validatedData['qty'] = $requestedQty;
            $validatedData['status'] = 1;
            $validatedData['isApprove'] = 0;
            $validatedData['tgl_pinjam'] = $date;

            Peminjaman::create($validatedData);

            $qtyreq = $barang->qty - $request->qty;

            $barang->update(['qty' => $qtyreq]);


            return redirect('/dashboard/peminjaman')->with('success', 'Data peminjaman berhasil ditambahkan!');
        } else {
            return redirect('/dashboard/peminjaman')->with('failed', 'Barang tidak ditemukan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $date = Carbon::now();
            $peminjaman = Peminjaman::whereId($request->id)->first();

            Peminjaman::where('id', $request->id)->update(["status" => 0, "tgl_balik" => $date->toDateString()]);

            $item = Barang::whereId($peminjaman->barangId)->first();

            $qtyreq = $item->qty + $peminjaman->qty;

            $item->update(['qty' => $qtyreq]);

            return redirect('/dashboard/peminjaman')->with('success', 'Barang berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('peminjaman.index')->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approve(Request $request)
    {
        Peminjaman::where('id', $request->id)->update(["isApprove" => 1]);
        return redirect('/dashboard/peminjaman')->with('success', 'Barang berhasil diperbarui!');
    }
}
