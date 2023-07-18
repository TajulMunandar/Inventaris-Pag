<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\History;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::with('kategoris')->latest()->get();
        $kategoris = Kategori::all();
        return view('dashboard.barang.index', [
            'title' => "Table Barang"
        ])->with(compact('barangs', 'kategoris'));
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
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'serialNumber' => 'required',
            'qty' => 'required',
            'deskripsi' => 'required',
            'kategoriId' => 'required'
        ]);

        Barang::create($validatedData);

        return redirect('/dashboard/barang')->with('success', 'barang baru berhasil dibuat!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        try {
            $rules = [
                'name' => 'required|max:255',
                'serialNumber' => 'required',
                'qty' => 'required',
                'deskripsi' => 'required',
                'kategoriId' => 'required'
            ];

            $validatedData = $request->validate($rules);

            Barang::where('id', $barang->id)->update($validatedData);

            return redirect('/dashboard/barang')->with('success', 'Barang berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('barang.index')->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        try {
            Barang::destroy($barang->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('barang.index')->with('failed', "Barang $barang->deskripsi_barang tidak dapat dihapus, karena sedang digunakan pada tabel lain!");
            }
        }
        return redirect('/dashboard/barang')->with('success', "Barang $barang->name berhasil dihapus!");
    }

    public function storeStock(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'qty' => 'required|numeric',
            'barangId' => 'required'
        ]);

        History::create($validatedData);

        $item = Barang::whereId($request->barangId)->first();

        $qtyreq = $item->qty + $request->qty;

        $item->update(['qty' => $qtyreq]);

        return redirect('/dashboard/barang')->with('success', 'Stock barang berhasil ditambah!');
    }
}
