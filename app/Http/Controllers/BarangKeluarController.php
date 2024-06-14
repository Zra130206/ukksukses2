<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangkeluars = BarangKeluar::with('barang')->paginate(10);

        return view('barangkeluar.index', compact('barangkeluars'));
    }

    public function create()
    {
        $barangs = Barang::all();

        return view('barangkeluar.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'tgl_keluar' => 'required|date',
        //     'qty_keluar' => 'required|integer|min:1',
        //     'barang_id' => 'required|exists:barang,id',
        // ]);

        // Create a new barangkeluar record
        BarangKeluar::create($request->all());

        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Barang Keluar Berhasil Disimpan!']);
    }

    public function show($id)
    {
        $barangkeluar = BarangKeluar::findOrFail($id);

        return view('barangkeluar.show', compact('barangkeluar'));
    }

    public function edit($id)
    {
        $barangkeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::all();

        return view('barangkeluar.edit', compact('barangkeluar', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tgl_keluar' => 'required|date',
            'qty_keluar' => 'required|integer|min:1',
            'barang_id' => 'required|exists:barang,id',
        ]);

        // Find the barangkeluar record and update it
        $barangkeluar = BarangKeluar::findOrFail($id);
        $barangkeluar->update($request->all());

        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Barang Keluar Berhasil Diperbarui!']);
    }

    public function destroy($id)
    {
        // Find the barangkeluar record and delete it
        $barangkeluar = BarangKeluar::findOrFail($id);
        $barangkeluar->delete();

        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Barang Keluar Berhasil Dihapus!']);
    }
}