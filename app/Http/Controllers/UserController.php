<?php

namespace App\Http\Controllers;

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
          return response()->json(['success' => false, 'message' => 'Success: ',  'data' => $user], 500);  
          
        }catch(\Exception $e) {
          // Tangkap error jika terjadi
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'data' => null], 500);
        }
    }
   // INSERT DATA KE DATABSE
    // public function store(Request $request)
    // {
        //define validation rules
        // $validator = Validator::make($request->all(), [
        //     'username'  => 'required',
        //     'password'     => 'required',
        //     'alamat'     => 'required',
        //     'hp'     => 'required',
        // ]);

        //check if validation fails
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        //create post
    //    $user = User::create([
    //         'username'     => $request->username,
    //         'password'   => $request->password,
    //         'alamat'   => $request->alamat,
    //          'hp'     => $request->hp,
    //         'role_id'     => $request->role_id,
    //     ]);

        //return response
        // return new UserResource(true, 'Data Post Berhasil Ditambahkan!',  $user);
  
        //INSERT DATA
    
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
         $data = new User;
         $data->username = $request->username;
         $data->password = Hash::make($request->password);
         $data->alamat = $request->alamat;
         $data->hp = $request->hp;
         $data->role_id = 2;
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
      public function destroy( User $user)
    {
      

         try {

       // Hapus terlebih dahulu catatan terkait di tabel transactions
        $user->transactions()->delete();

        // Hapus role
        $user->delete();

          //return response
        return new UserResource(true, 'Data Post Berhasil Dihapus!', null);
        } catch (\Exception $e) {
            // Tangkap error jika terjadi
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'data' => null], 500);
        }
    }    



}