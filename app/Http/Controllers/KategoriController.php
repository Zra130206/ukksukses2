<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Foundation\Validation\ValidatesRequests; // Add this import


class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //mengakses method dari model Kategori - OK
        // ----------------------------------------------------------------
        $rsetKategori = Kategori::getKategoriAll();
        return view('kategori.index', compact('rsetKategori'));
    
        // ----------------------------------------------------------------
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aKategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Barang Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );
        return view('kategori.create',compact('aKategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'deskripsi' => 'required',
        //     'kategori' => 'required|in:M,A,BHP,BTHP',
        // ]);

        //create post
        Kategori::create([
            'deskripsi'  => $request->deskripsi,
            'kategori'   => $request->kategori,
        ]);

        //redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        if (DB::table('barang')->where('kategori_id', $id)->exists()) {
            $rsetKategori = Kategori::find($id); // Jika ada barang yang terkait, ambil objek kategori dengan find().
        } else {
            $rsetKategori = Kategori::showKategoriById($id); // Jika tidak ada barang yang terkait, gunakan showKategoriById().
        }

        $rsetKategori = Kategori::select('id', 'deskripsi', 'kategori',
            DB::raw('(CASE
                WHEN kategori = "M" THEN "Modal"
                WHEN kategori = "A" THEN "Alat"
                WHEN kategori = "BHP" THEN "Bahan Habis Pakai"
                ELSE "Bahan Tidak Habis Pakai"
                END) AS ketKategori'))
            ->where('id', '=', $id)
            ->first();
        

        //return $rsetKategori;
        return view('kategori.show', compact('rsetKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $aKategori = array('blank'=>'Pilih Kategori',
        'M'=>'Barang Modal',
        'A'=>'Alat',
        'BHP'=>'Bahan Habis Pakai',
        'BTHP'=>'Bahan Tidak Habis Pakai'
    );

        $rsetKategori = Kategori::find($id);
        //return $rsetBarang;
        return view('kategori.edit', compact('rsetKategori','aKategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $this->validate($request, [
        //     'deskripsi'   => 'required',
        //     'kategori'    => 'required | in:M,A,BHP,BTHP',
        // ]);

        $rsetKategori = Kategori::find($id);

        $rsetKategori->update([
            'deskripsi'  => $request->deskripsi,
            'kategori'   => $request->kategori
            ]);

            //redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        if (DB::table('barang')->where('kategori_id', $id)->exists()){
            return redirect()->route('kategori.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        } else {
            $rsetKategori = Kategori::find($id);
            $rsetKategori->delete();
            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }
    function updateAPIKategori(Request $request, $kategori_id){
        $kategori = Kategori::find($kategori_id);

        if (null == $kategori){
            return response()->json(['status'=>"kategori tidak ditemukan"]);
        }

         $kategori->deskripsi= $request->deskripsi;
         $kategori->kategori = $request->kategori;
         $kategori->save();

        return response()->json(["status"=>"kategori berhasil diubah"]);
    }

    // function untuk membuat index api
    function showAPIKategori(Request $request){
        $kategori = Kategori::all();
        return response()->json($kategori);
    }

    function showAPIKategori1($id){
        $kategori1 = Kategori::find($id);
        return response()->json($kategori1);
    }

    // function untuk create api
    function buatAPIKategori(Request $request){
        $request->validate([
            'deskripsi' => 'required|string|max:100',
            'kategori' => 'required|in:M,A,BHP,BTHP',
        ]);

        // Simpan data kategori
        $kat = Kategori::create([
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ]);

        return response()->json(["status"=>"data berhasil dibuat"]);
    }

    // function untuk delete api
    function hapusAPIKategori($kategori_id){

        $del_kategori = Kategori::findOrFail($kategori_id);
        $del_kategori -> delete();

        return response()->json(["status"=>"data berhasil dihapus"]);
    }

}