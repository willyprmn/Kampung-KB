<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\{
    PageController,
    IntervensiController as PortalIntervensiController,
    KampungController as PortalKampungController,
    ReportController as PortalReportController,
    Intervensi\KategoriController as PortalIntervensiKategoriController,
};
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ConfigurationStatisticController as AdminConfigurationStatisticController;
use App\Http\Controllers\Admin\{
    UserController,
    RekapitulasiController,
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware' => 'maintainer'
], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::resource('provinsi', 'ProvinsiController')->only(['index']);
Route::resource('kabupaten', 'KabupatenController')->only(['index']);
Route::resource('kecamatan', 'KecamatanController')->only(['index']);
Route::resource('desa', 'DesaController')->only(['index']);
Route::resource('inpres-kegiatan', 'InpresKegiatanController')->only(['index']);
Route::resource('keyword', 'KeywordController')->only(['index']);

Route::group([
    'namespace' => 'Portal',
    'as' => 'portal.',
], function () {

    # Redirect old url
    Route::get('/profile/{id}', [PageController::class, 'profile'])
        ->where('id', '[0-9]+');
    Route::get('/kampungkb/profile/{id}', [PageController::class, 'profile'])
        ->where('id', '[0-9]+');

    # Redirect old url
    Route::get('/postSlider/{kampung}/{intervensi}', [PageController::class, 'intervensi'])
        ->where([
            'kampung' => '[0-9]+',
            'intervensi' => '[0-9]+'
        ]);
    Route::get('/kampungkb/postSlider/{kampung}/{intervensi}', [PageController::class, 'intervensi'])
        ->where([
            'kampung' => '[0-9]+',
            'intervensi' => '[0-9]+'
        ]);

    # Redirect old url
    Route::get('/intervensi/{kampung}', [PageController::class, 'subsite'])
        ->where(['kampung' => '[0-9]+']);
    Route::get('/kampungkb/intervensi/{kampung}', [PageController::class, 'subsite'])
        ->where(['kampung' => '[0-9]+']);

    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/tentang', [PageController::class, 'about'])->name('tentang');
    Route::get('/kampung-percontohan', [PageController::class, 'percontohan'])->name('percontohan');

    Route::get('statistik/{statistik}/{slug?}', 'ReportController@show')
        ->name('statistik.show')
        ->where('slug', '^[a-z0-9]+(-?[a-z0-9]+)*$');

    Route::resource('statistik', ReportController::class)->only(['index']);

    Route::group(['as' => 'kampung.'], function () {
        Route::get('/jelajahi', [PortalKampungController::class, 'index'])->name('index');
        Route::group([
            'prefix' => '/kampung/{kampung_id}/intervensi',
            'as' => 'intervensi.'
        ], function () {
            Route::get('/kategori/{kategori_id}', [PortalIntervensiKategoriController::class, 'index'])->name('kategori.index');
            Route::get('/{intervensi_id}/{slug?}', [PortalIntervensiController::class, 'show'])
                ->name('show')
                ->where('slug', '^[a-z0-9]+(-?[a-z0-9]+)*$');
            Route::get('/', [PortalIntervensiController::class, 'index'])->name('index');
        });

        Route::get('/kampung/{kampung_id}/{slug?}', [PortalKampungController::class, 'show'])
            ->name('show')
            ->where('slug', '^[a-z0-9]+(-?[a-z0-9]+)*$');
    });

});

Auth::routes();

# If /logout hit directly
Route::get('/logout', 'Auth\LoginController@redirectLogout');

Route::group([
    'namespace' => 'Admin',
    'as' => 'admin.',
], function () {
    Route::resource('archive', 'ArchiveController');
});

Route::group([
    'namespace' => 'Admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'active.only'],
], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('profile', 'UserController@profile')->name('profile');
    Route::get('profile/edit', 'UserController@profilEdit')->name('profile.edit');
    Route::put('profile/update/', 'UserController@profileUpdate')->name('profile.update');

    Route::group(['namespace' => 'Kampung'], function () {

        Route::resource('kampungs.profil', 'ProfilController');
        Route::resource('kampungs.penduduk', 'PendudukController');
        Route::resource('kampungs.kkbpk', 'KkbpkController');
        Route::resource('kampungs.intervensi', 'IntervensiController');

        Route::resource('percontohan', 'PercontohanController');
        Route::resource('progres-statistik', 'ProgressStatisticController');
    });

    Route::group([
        'prefix' => '/configuration',
        'as' => 'configuration.',
        'namespace' => 'Configuration'
    ], function () {

        #config tooltip
        Route::put('/statistik', [AdminConfigurationStatisticController::class, 'update'])->name('statistik.update');
        Route::get('/tooltip-statistik', [AdminConfigurationStatisticController::class, 'index'])->name('tooltip-statistik');

    });

    Route::group([
        'prefix' => '/page',
        'as' => 'page.',
    ], function () {
        Route::put('/', [AdminPageController::class, 'update'])->name('update');
        Route::get('/about', [AdminPageController::class, 'index'])->name('about');
        Route::get('/header', [AdminPageController::class, 'header'])->name('header');
    });

    Route::group(['namespace' => 'Inpres'], function () {
        Route::resource('inpres-sasaran', 'SasaranController');
        Route::resource('inpres-program', 'ProgramController');
        Route::resource('inpres-kegiatan', 'KegiatanController');
    });

    Route::resource('keyword', 'KeywordController');
    Route::resource('instansi', 'InstansiController');
    Route::resource('program', 'ProgramController');
    Route::resource('program-group', 'ProgramGroupController');
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('kampungs', 'KampungController');

    #reset password
    Route::put('/user/reset/{id}', [UserController::class, 'reset'])->name('user.reset');

    #rekapitulasi
    Route::get('/rekap-pengisi-konten', 'RekapitulasiController@pengisiKonten')->name('rekap-pengisi-konten.index');
    Route::get('/rekap-admin-provinsi', 'RekapitulasiController@adminProvinsi')->name('rekap-admin-provinsi.index');
    Route::get('/rekap-admin-kabupaten', 'RekapitulasiController@adminKabupaten')->name('rekap-admin-kabupaten.index');
    Route::get('/rekap-klasifikasi', 'RekapitulasiController@klasifikasi')->name('rekap-klasifikasi.index');
    Route::get('/rekap-kampung', 'RekapitulasiController@kampung')->name('rekap-kampung.index');
});
