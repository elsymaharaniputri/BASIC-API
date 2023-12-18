<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

  
    //LOGIN
    public function login (Request $request) {

        $credentials = $request->only('username', 'password');
         $validator = Validator::make($request->all(), [
            'username'  => 'required',
            'password'     => 'required',
  
        ]);
  
        if($validator->fails()){
        return response()->json(['error' => 'invalid input'],422);
      }
        if (!Auth::attempt($credentials)) {
          return response()->json(['error' => 'Unauthorized'],401);
        }
        
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        $expiryDate = now()->addHour();
        return response()->json([
          'message' => 'Login successful',  
          'body' => [
            'user_id'=>$user->id,
            'token'=> $token,
          'username' => $user->username,
          'expiryDate' => $expiryDate,
          ],   
          
        
        ]);     
             
    }

    public function out (Request $request)  {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Successfully logged out']);
    }
   
    
   // SHOW DATA KE DATABASE
   public function index()
    {
     
        try{
             //jangan lupa import model Post dengan cara klik kanan untuk import
        // $user = User::with('role')->get();
           $user = User::all();
        //berfungsi untuk mengatur jenis data yang akan ditampilkan
          return response()->json(['success' => true, 'message' => 'Success: ',  'data' => $user], 200);  
          
        }catch(\Exception $e) {
          // Tangkap error jika terjadi
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    
        public function store(Request $request)
    {
        try {
       //define validation rules
        $validator = Validator::make($request->all(), [
            'username'  => 'required',
            'password'     => 'required',
            'alamat'     => 'required',
            'hp'     => 'required',
        ]);
        // Check if role_id is provided, otherwise set default value
        $role_id = $request->filled('role_id') ? $request->role_id : 2;

         $data = new User;
         $data->username = $request->username;
         $data->password = Hash::make($request->password);
         $data->alamat = $request->alamat;
         $data->hp = $request->hp;
         $data->role_id = $data->role_id = $role_id;;
         if($data->save()){
          return response()->json(['success' => true, 'message' => 'Success: ',  'data' => $data], 200);  
         }else{
          return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ', 'data' => null], 500);
         }
        } catch (\Exception $e) {
            // Tangkap error jika terjadi
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'data' => null], 500);
        }
        
    }

    
// DELETE
public function destroy($id)
{
    try {
        // Temukan pengguna berdasarkan ID
        $user = User::find($id);

        // Periksa apakah pengguna ditemukan
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Pengguna tidak ditemukan', 'data' => null], 404);
        }

      // Hapus terlebih dahulu catatan terkait di tabel transactions
       Transaction::where('user_id', $user->id)->delete();


        // Hapus pengguna
        $user->delete();

        // Return response
        return response()->json(['success' => true, 'message' => 'Data Pengguna Berhasil Dihapus!', 'data' => null], 200);
    } catch (\Exception $e) {
        // Tangkap error jika terjadi
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'data' => null], 500);
    }
}




}