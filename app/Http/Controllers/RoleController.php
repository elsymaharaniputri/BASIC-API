<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
       // SHOW DATA KE DATABASE
   public function index()
    {
        //jangan lupa import model Post dengan cara klik kanan untuk import
        $role = Roles::all();
        //berfungsi untuk mengatur jenis data yang akan ditampilkan
        return response()->json(['data' =>  $role]);
    }
   // INSERT DATA KE DATABSE
    public function store(Request $request)
    {
        //define validation rules
        // $validator = Validator::make($request->all(), [
        //     'status'     => 'required',
      
        // ]);

        // //check if validation fails
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

       
         try {
       //define validation rules
        $validator = Validator::make($request->all(), [
            'status'     => 'required',
      
        ]);
         //create post
       $role = Roles::create([
            'status'   => $request->status,
           
        ]);

        //return response
        return new RoleResource(true, 'Data Post Berhasil Ditambahkan!',  $role);

        } catch (\Exception $e) {
            // Tangkap error jika terjadi
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'data' => null], 500);
        }
        
    }

// DELETE
      public function destroy(Roles $role)
    {
      

         try {
        // Hapus role
        $role->delete();

          //return response
        return new RoleResource(true, 'Data Post Berhasil Dihapus!', null);
        } catch (\Exception $e) {
            // Tangkap error jika terjadi
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}