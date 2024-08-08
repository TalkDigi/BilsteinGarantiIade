<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Models\Status;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuideController;
use App\Models\Application;
use App\Http\Controllers\ClosureController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\Blockage;
use App\Models\Type;

Route::get('/assignRole', function () {
    $user = \App\Models\User::find(1);
    $user->assignRole('Yönetici');
    return $user;
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');


    Route::get('/', function () {



        $Activities = \App\Models\Activity::orderBy('created_at', 'desc')->limit(15)->get();

        //find applications where viewed_by is null

        $query = Application::selectRaw('type, COUNT(*) as count')
            ->groupBy('type');


        if (auth()->user()->hasRole('Kullanıcı')) {
            $query->where('user_id', auth()->user()->id);
        }

        $Types = Type::all();


        return view('dashboard.home', compact('Types','Activities' ));

    })->name('dashboard');


    Route::prefix('/yeni-basvuru')->group(function () {

        /*Route::get('/', [ApplicationController::class, 'index'])->name('dashboard.application.index');

        Route::post('/', [ApplicationController::class, 'search'])->name('dashboard.application.search');*/

        /*Route::post('/taslak-olustur', [ApplicationController::class, 'create_draft'])->name('dashboard.application.draft');*/

        Route::post('/urun-ara', [ApplicationController::class, 'search'])->name('dashboard.application.search');

        Route::post('/bridge', [ApplicationController::class, 'applicationBridge'])->name('dashboard.application.bridge');

        Route::get('/{type}', [ApplicationController::class, 'firstStep'])->name('dashboard.application.firstStep');

        Route::post('/{type}', [ApplicationController::class, 'store'])->name('dashboard.application.store');

        Route::get('/{type}/{claim}', [ApplicationController::class, 'firstStep'])->name('dashboard.application.first');

    });

    Route::prefix('/basvurular')->group(function () {

        Route::get('/', [ApplicationController::class, 'list'])->name('dashboard.application.list');

        Route::get('/{type}/{tip?}', [ApplicationController::class, 'list'])->name('dashboard.application.listFilter');

        Route::post('/ara', [ApplicationController::class, 'claim_search'])->name('dashboard.application.claim_search');

    });

    Route::prefix('/basvuru')->group(function () {
        Route::get('/detay/{claim}', [ApplicationController::class, 'show'])->name('dashboard.application.show');

        Route::get('/duzenle/{claim}', [ApplicationController::class, 'edit'])->name('dashboard.application.edit');

        Route::post('/guncelle/{claim}', [ApplicationController::class, 'update'])->name('dashboard.application.update');

        Route::get('/durum-degistir/{status}/{claim}', [ApplicationController::class, 'update_status'])->name('dashboard.application.update_status');

        Route::post('/durum-degistir', [ApplicationController::class, 'update_status_with_message'])->name('dashboard.application.update_status_with_message');

        Route::get('/pdf-cikti/{claim}', [ApplicationController::class, 'generatePDF'])->name('dashboard.application.pdf');
    });

    Route::prefix('/icerik')->group(function () {

        Route::get('/sss', [GuideController::class, 'sss'])->name('dashboard.guide.sss');

    });

    Route::prefix('/yonetim')->group(function () {
        Route::get('/ayarlar', [SettingController::class, 'index'])->name('dashboard.setting.index');
        Route::get('/sss', [SettingController::class, 'sss'])->name('dashboard.setting.sss');
        Route::get('/dosyalar', [SettingController::class, 'file'])->name('dashboard.setting.file');

        Route::prefix('/kaydet')->group(function () {
            Route::post('/sss', [QuestionController::class, 'store'])->name('dashboard.setting.sssStore');
            Route::post('/ayarlar', [SettingController::class, 'settingsStore'])->name('dashboard.setting.settingsStore');
            Route::post('/dosya', [FileController::class, 'settingsFileStore'])->name('dashboard.setting.fileStore');
        });


        Route::prefix('/sil')->group(function () {
            Route::get('/sss/{id}', [QuestionController::class, 'destroy'])->name('dashboard.setting.sssDestroy');
            Route::get('/dosya/{id}', [FileController::class, 'destroy'])->name('dashboard.setting.fileDestroy');
        });

    });

    Route::get('/ay-kapama', [ClosureController::class, 'index'])->name('dashboard.application.closure');
    Route::post('/ay-kapama', [ClosureController::class, 'filter'])->name('dashboard.application.closure-filter');
    Route::post('/ay-kapama/islem', [ClosureController::class, 'process'])->name('dashboard.application.closure-process');
    Route::get('/ay-kapama/{uuid}', [ClosureController::class, 'show'])->name('dashboard.application.closure-show');
    Route::post('/fiyat-ara', [ClosureController::class, 'search_other_prices'])->name('dashboard.application.search_other_prices');
    Route::post('/fiyat-degistir', [ClosureController::class, 'set_price'])->name('dashboard.application.set_price');



    Route::post('/fatura-olustur', [ClosureController::class, 'create_invoice'])->name('dashboard.application.create-invoice');
    Route::get('/fatura-cikti/{claim}', [ClosureController::class, 'export_invoice'])->name('dashboard.application.export-invoice');
    Route::get('/ay-kapama-fatura-cikti/{uuid}', [ClosureController::class, 'export_invoice_closure'])->name('dashboard.application.export-invoice-closure');

    Route::post('/file', [FileController::class, 'store'])->name('file.store');
    Route::post('/quill', [FileController::class, 'quill'])->name('quill.store');
    Route::post('/delete', [FileController::class, 'delete'])->name('file.delete');

    Route::prefix('/kullanicilar')->middleware('role:Yönetici')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/olustur', [UserController::class, 'store'])->name('user.store');
        Route::get('/duzenle/{id}', [UserController::class, 'show'])->name('user.show');

    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


require __DIR__ . '/auth.php';
