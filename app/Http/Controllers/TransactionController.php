<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
     // SHOW SEMUA DATA KE DATABASE
     public function index()
    {
        //jangan lupa import model Post dengan cara klik kanan untuk import
    //   $transaksi = Transaction::all();
        //berfungsi untuk mengatur jenis data yang akan ditampilkan
        // return response()->json(['data' =>  $transaksi]);

         // Retrieve the currently authenticated user
    $user = Auth::user();

    // Check if the user is authenticated
    if ($user) {
        // Retrieve transactions associated with the user
        $transaksi = Transaction::where('user_id', $user->id)->get();

        // Return the response with filtered transactions
        return response()->json(['data' => $transaksi]);
    } else {
        // User is not authenticated
        return response()->json(['message' => 'User not authenticated'], 401);
    }
    }


    //INSERT TRANSACTIONS
       public function store(Request $request)
    {
        //define validation rules
        $kategoriNames = Categories::pluck('kategori_sampah')->toArray();
       $validator = Validator::make($request->all(), [
        'berat_sampah' => 'required',
        'alamat_jemput' => 'required',
        'tanggal_jemput' => 'required',
        'kategori_id' => [
            'required',
            Rule::in($kategoriNames),
        ],
    ]);

    
        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } 
            try {
                // Retrieve category details
                $kategori = Categories::where('kategori_sampah', $request->kategori_id)->firstOrFail();
                // Calculate total_berat based on category's weight
                $total_berat =  $request->berat_sampah;

                // Calculate poin based on category's harga
                $poin = $kategori->harga_sampah * $request->berat_sampah;

                // Create post
                $transactions = Transaction::create([
                    'berat_sampah' => $request->berat_sampah,
                    'alamat_jemput' => $request->alamat_jemput,
                    'tanggal_jemput' => $request->tanggal_jemput,
                    'status' => 1,
                    'poin' => $poin,
                    'total_berat' => $total_berat,
                    'user_id' => Auth::id(),
                    'kategori_id' => $kategori->id,
                ]);

                // Return response
                return new TransactionResource(true, 'Data Post Berhasil Ditambahkan!', $transactions);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['kategori_id' => 'Kategori tidak valid.'], 422);
            } catch (\Exception $e) {
                // Handle other exceptions if needed
                return response()->json(['error' => 'Something went wrong.'], 500);
            }
            
       }
    
}