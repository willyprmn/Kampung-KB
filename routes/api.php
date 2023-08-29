<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'namespace' => 'Api',
    'as' => 'api.'
], function () {
    Route::apiResource('program', 'ProgramController');
    Route::apiResource('sumber-dana', 'SumberDanaController');

    Route::post('profil/{profil}/upload', 'ProfilController@upload');
    Route::apiResource('profil', 'ProfilController');

    Route::apiResource('inpres-kegiatan', 'InpresKegiatanController')->only(['index']);
    Route::apiResource('kategori', 'KategoriController')->only(['index']);
    Route::apiResource('sasaran', 'SasaranController')->only(['index']);
    Route::apiResource('instansi', 'InstansiController')->only(['index']);
    Route::apiResource('kampung', 'KampungController')->only(['index']);
    Route::apiResource('jenis-post', 'JenisPostController')->only(['index']);
    Route::apiResource('intervensi', 'IntervensiController')->only(['show']);
    Route::apiResource('plkb-pengarah', 'PlkbPengarahController')->only(['index']);
    Route::apiResource('regulasi', 'RegulasiController')->only(['index']);
    Route::apiResource('penggunaan-data', 'PenggunaanDataController')->only(['index']);
    Route::apiResource('frekuensi', 'FrekuensiController')->only(['index']);
    Route::apiResource('operasional', 'OperasionalController')->only(['index']);
});
