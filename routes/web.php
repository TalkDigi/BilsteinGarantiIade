<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuideController;
use App\Models\Application;

Route::get('/test', function() {
    //generate two uuid
    $uuid1 = \Illuminate\Support\Str::uuid();
    $uuid2 = \Illuminate\Support\Str::uuid();
    dd($uuid1, $uuid2);
});
Route::get('/assignRole', function() {
   $user = \App\Models\User::find(1);
    $user->assignRole('Yönetici');
    return $user;
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', function() {
        auth()->logout();
        return redirect('/');
    })->name('logout');


        Route::get('/', function () {

            $Activities = \App\Models\Activity::orderBy('created_at','desc')->limit(15)->get();

            $query = Application::selectRaw('type, COUNT(*) as count')
            ->groupBy('type');


            if(auth()->user()->hasRole('Kullanıcı')) {
                $query->where('user_id',auth()->user()->id);
            }

            $typeCounts = $query->pluck('count', 'type');


            $totalCount = $typeCounts->sum(); // Tüm başvuruların toplam sayısı
            $typeACount = $typeCounts->get('ilave-masraf-iceren-basvuru', 0); // 'b' tipi başvuruların sayısı
            $typeBCount = $typeCounts->get('masraf-icermeyen-basvuru', 0); // 'a' tipi başvuruların sayısı
            $typeCCount = $typeCounts->get('hasarli-eksik-parca-bildirim', 0); // 'c' tipi başvuruların sayısı

           // Öncelikle tüm kombinasyonları içeren bir array oluşturuyoruz.
            $allResults = [];
            foreach (Application::TYPES as $typeKey => $typeInfo) {
                foreach (Application::STATUS as $statusKey => $statusInfo) {
                    if ($statusInfo['slug'] != 'taslak') {  // 'Taslak' durumunu hariç tutuyoruz.
                        $statusTitle = $statusInfo['name']; // Status başlığını kullanıyoruz.
                        $allResults[$typeInfo['title']][$statusTitle] = 0; // Başlangıçta her bir kombinasyon için sayımı 0 olarak ayarlıyoruz.
                    }
                }
            }

            // Veritabanından gelen sonuçları alıyoruz.
            $query = Application::select('type', 'status', DB::raw('COUNT(*) as count'))
                ->whereNotIn('status', [0]);  // 'Taslak' durumunu veritabanı sorgusunda hariç tutuyoruz.

            // Eğer kullanıcı 'Kullanıcı' rolüne sahipse, sadece kendi oluşturduğu kayıtları filtrele
            if (auth()->user()->hasRole('Kullanıcı')) {
                $query->where('user_id', auth()->id());
            }

            $results = $query->groupBy('type', 'status')->get();

            // Veritabanından gelen sonuçları işleyerek ilgili type ve status için sayıları güncelliyoruz.
            foreach ($results as $result) {
                $typeTitle = Application::TYPES[$result->type]['title'] ?? 'Bilinmeyen Tip';
                $statusTitle = Application::STATUS[$result->status]['name'] ?? 'Bilinmeyen Durum';
                if (isset($allResults[$typeTitle][$statusTitle])) {
                    $allResults[$typeTitle][$statusTitle] = $result->count;
                }
            }




            return view('dashboard.home',compact('Activities','totalCount','typeACount','typeBCount','typeCCount','allResults'));

        })->name('dashboard');

        Route::prefix('/yeni-basvuru')->group(function () {

            Route::post('/',[ApplicationController::class,'applicationBridge'])->name('dashboard.application.create.redirect');

            Route::get('/{type}',[ApplicationController::class,'invoiceIndex'])->name('dashboard.application.create');

            Route::get('/{type}/{invoice}',[ApplicationController::class,'firstStep'])->name('dashboard.application.index');

            Route::post('/{type}/{invoice}',[ApplicationController::class,'store'])->name('dashboard.application.store');

        });

        Route::prefix('/basvurular')->group(function () {

            Route::get('/',[ApplicationController::class,'index'])->name('dashboard.application.list');

            Route::get('/{type}/{tip?}',[ApplicationController::class,'index'])->name('dashboard.application.listFilter');

        });

        Route::prefix('/basvuru')->group(function() {
             Route::get('/detay/{claim}',[ApplicationController::class,'show'])->name('dashboard.application.show');

            Route::get('/duzenle/{claim}',[ApplicationController::class,'edit'])->name('dashboard.application.edit');

            Route::post('/guncelle/{claim}',[ApplicationController::class,'update'])->name('dashboard.application.update');

            Route::get('/durum-degistir/{status}/{claim}',[ApplicationController::class,'update_status'])->name('dashboard.application.update_status');

            Route::post('/durum-degistir',[ApplicationController::class,'update_status_with_message'])->name('dashboard.application.update_status_with_message');
        });

        Route::prefix('/icerik')->group(function () {

            Route::get('/sss',[GuideController::class,'sss'])->name('dashboard.guide.sss');

        });

        Route::get('/ay-kapama',[\App\Http\Controllers\ClosureController::class,'index'])->name('dashboard.application.closure');
        Route::post('/ay-kapama',[\App\Http\Controllers\ClosureController::class,'filter'])->name('dashboard.application.closure-filter');
        Route::post('/ay-kapama/islem',[\App\Http\Controllers\ClosureController::class,'process'])->name('dashboard.application.closure-process');

        Route::post('/file', [FileController::class, 'store'])->name('file.store');
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




require __DIR__.'/auth.php';
