<?php

use Illuminate\Support\Facades\Route;
use Dbfx\LaravelStrapi\LaravelStrapi;
use GuzzleHttp\Client;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ArquitecturaController;
use App\Http\Controllers\CulturaController;
use App\Http\Controllers\DeporteController;
use App\Http\Controllers\TransporteController;
use App\Filament\Resources\GuiaResource;



Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::get('admin/guia', [ApiController::class, 'fetchImages']);
    Route::get('/generate-pdf/{userId}', [ApiController::class, 'generatePdf']);
    Route::put('/admin/editar/{id}', [ApiController::class, 'update']);
    Route::post('/admin/add-data', [ApiController::class, 'post']);

    //************************************* */
    Route::get('admin/arqui',[ArquitecturaController::class, 'v_arqui']);
    Route::post('admin/a_post', [ArquitecturaController::class, 'post']);
    Route::put('admin/a_post/{id}', [ArquitecturaController::class, 'update']);
    //************************************ */
    Route::get('admin/culturas',[CulturaController::class, 'v_cultura']);
    Route::post('admin/c_post', [CulturaController::class, 'post']);
    Route::put('admin/c_post/{id}', [CulturaController::class, 'update']);
    //************************************ */
    Route::get('admin/deportes',[DeporteController::class, 'v_deporte']);
    Route::post('admin/d_post', [DeporteController::class, 'post']);
    Route::put('admin/d_post/{id}', [DeporteController::class, 'update']);
    //************************************ */
    Route::get('admin/transportes',[TransporteController::class, 'v_transporte']);
    Route::post('admin/t_post', [TransporteController::class, 'post']);
    Route::put('admin/t_post/{id}', [TransporteController::class, 'update']);
});


