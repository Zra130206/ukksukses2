<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/invent01', [KategoriController::class, 'showAPIKategori']);
Route::get('invent03/{kategori_id}', [KategoriController::class, 'showAPIKategori1']);
Route::post('invent05/{kategori_id}', [KategoriController::class, 'updateAPIKategori']);
Route::post('invent02', [KategoriController::class, 'buatAPIKategori']);
Route::delete('invent04/{kategori_id}', [KategoriController::class, 'hapusAPIKategori']);