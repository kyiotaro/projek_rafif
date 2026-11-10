<?php

use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\SiswaController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::apiResource('siswa', SiswaController::class);
    Route::apiResource('guru', GuruController::class);
    Route::apiResource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas',
    ]);
});