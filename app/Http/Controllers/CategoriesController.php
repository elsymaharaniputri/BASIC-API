<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\PostInc;

class CategoriesController extends Controller
{
    // SHOW DATA KE DATABASE
   public function index()
    {
        //jangan lupa import model Post dengan cara klik kanan untuk import
      $kategori = Categories::all();
        //berfungsi untuk mengatur jenis data yang akan ditampilkan
        return response()->json(['data' =>  $kategori]);
    }
    
// INSERT DATA KE DATABSE
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kategori_sampah'  => 'required',
            'harga_sampah'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            
        }
        // Check if the user has role_id 1 (admin)
        if ($request->user()->role_id != 1) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Hanya admin yang dapat menambahkan kategori sampah.', 'data' => null], 403);
        }

        //create post
       $kategori = Categories::create([
            'kategori_sampah'     => $request->kategori_sampah,
            'harga_sampah'   => $request->harga_sampah,
        ]);

        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!',  $kategori);
        
    }
    
    //SHOW DATA DETAIL BY ID
     public function show($id)
    {
       $kategori = Categories::findOrFail($id);
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $kategori);
    }


    // DELETE
   public function destroy($id)
{
    try {
        // Temukan pengguna berdasarkan ID
        $kategori = Categories::find($id);

        // Periksa apakah pengguna ditemukan
        if (!$kategori) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan', 'data' => null], 404);
        }

        // Hapus pengguna
        $kategori->delete();

        // Return response
        return response()->json(['success' => true, 'message' => 'Data Pengguna Berhasil Dihapus!', 'data' => null], 200);
    } catch (\Exception $e) {
        // Tangkap error jika terjadi
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'data' => null], 500);
    }
}

    
}