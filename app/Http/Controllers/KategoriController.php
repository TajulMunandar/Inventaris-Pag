<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return view('dashboard.kategori.index', [
            'title' => "Data Kategori"
        ])->with(compact('kategoris'));
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
            'isHabis' => 'required'
        ]);

        Kategori::create($validatedData);

        return redirect('/dashboard/kategori')->with('success', 'Kategori baru berhasil dibuat!');
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
    public function update(Request $request, Kategori $kategori)
    {
        $rules =[
            'name' => 'required|max:255',
            'isHabis' => 'required'
        ];

        $validatedData = $request->validate($rules);

        Kategori::where('id', $kategori->id)->update($validatedData);

        return redirect('/dashboard/kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        Kategori::destroy($kategori->id);
        return redirect('/dashboard/kategori')->with('success', "Kategori $kategori->name berhasil dihapus!");
    }
}
