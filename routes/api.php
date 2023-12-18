<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/kategori', [App\Http\Controllers\CategoriesController::class, 'index']);
// Route::get('/kategori', function (){
//   return "kategori";
// });

Route::apiResource('/kategori', CategoriesController::class)-> middleware('auth:sanctum');
Route::apiResource('/transaksi', TransactionController::class)-> middleware('auth:sanctum');
// Route::apiResource('/user', UserController::class);
Route::apiResource('/role', RoleController::class);
Route::post('/login',[UserController::class,'login']);
Route::post('/user',[UserController::class,'store']);
Route::delete('/deleteUser/{id}', [UserController::class, 'destroy']);
Route::delete('/deleteKategori/{id}', [CategoriesController::class, 'destroy']);
Route::get('/user',[UserController::class,'index']);
Route::post('/logout', [UserController::class, 'out'])->middleware('auth:sanctum');