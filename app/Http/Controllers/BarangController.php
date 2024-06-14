<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::paginate(5);
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('barang.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'merk' => 'nullable|string|max:50',
        //     'seri' => 'nullable|string|max:50',
        //     'spesifikasi' => 'nullable|string',
        //     'stok' => 'integer|min:0',
        //     'kategori_id' => 'required|exists:kategori,id',
        // ]);
        $stok = $request->input('stok', 0);

        // Create a new barang record
        // Barang::create($request->all());
        Barang::create([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'stok' => $stok,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('barang.index')->with(['success' => 'Data Barang Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::all();
        return view('barang.edit', compact('barang', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $this->validate($request, [
        //     'merk' => 'nullable|string|max:50',
        //     'seri' => 'nullable|string|max:50',
        //     'spesifikasi' => 'nullable|string',
        //     'stok' => 'integer|min:0',
        //     'kategori_id' => 'required|exists:kategori,id',
        // ]);

        // Find the barang record and update it
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')->with(['success' => 'Data Barang Berhasil Diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // if (DB::table('barangmasuk')->where('barang_id', $id)->exists() ||
        // DB::table('barangkeluar')->where('barang_id', $id)->exists()) {
        // return redirect()->route('barang.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        // }

        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);

    }
}