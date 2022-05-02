<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
    // isimli route tanımlarında yönlendirme yapılırken
    // return redirect()->route('category.show', ['slug'=>'books']);
});

//prefix tanımladığmızda route gruplayıp adres çubuğunda o prefixi kullanarak route tanımlarına ulaşabiliriz.
Route::prefix('basics')->group(function () {
    Route::get('/merhaba', function () {
        return "Meerhabalar efendim";
    });

    Route::get('/merhaba-json', function () {
        return ["Message :" => "Bu viewda json ciktisi ornegidir."];
    });

    Route::get('/merhaba-json2', function () {
        return response(["Message :" => "Bu viewda json ciktisi ornegidir."], 200)
//        ->header('Content-Type', 'text/plain');
            ->header('Content-Type', 'application/json');
    });


    Route::get('/merhaba-json3', function () {
        return response()->json(['message' => 'Bu viewda json ciktisi ornegidir']);
    });

    Route::get('/product/{id}', function ($id) {
        return "Product Id: $id";
    });

    Route::get('/product/{id}/{type}', function ($id, $r_type) {
        return "Product Id: $id, Type: $r_type";
    });


//Girilen product değerinde girilen değer opsiyonelse tanımlanan yerin sonuna ? geliyor.
    Route::get('/product/{id}/{type?}', function ($id, $r_type) {
        return "Product Id: $id, Type: $r_type";
    });

    Route::get('/category/{slug}', function ($slug) {
        return "Category Slug: $slug";
    })->name('category.show');

});


// function kullanarak yazdığımızda uzun satılar olabilir. bunun yerine controller kullanarak route tanımları controller içinde yaparak kodu daha düzenli şekilde yazabiliriz.
//controller yazmak için  App/http/controllers
//veya terminal ekranına -> php artisan make:controller Controllerismi yazarak oluşturabilirz.


//Controller da tanımladığımız route almak için
Route::get('/product/{id}/{type?}',[ProductController::class,'show']);



//Burada resource yazdığımızda tanımlı olan tüm istekleri gerçekleştiriyor(create show edit gibi)
//   ->only(['index', 'put']);  route tanımı sonunda sadece belirli istekleri kullanacaksak only ile o istekleri belirtebiliriz.
//   ->except['delete', 'show']);  route tanımı sonunda belirli istekleri kullanmayacaksak onları tanımlarken kullanılır.
Route::resource('users', 'app\Http\Controllers\ProductController', ['except' => ['create', 'edit']]);

Route::get('/secured', function(){
    return "You are authenticated!";
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
