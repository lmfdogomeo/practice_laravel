<?php

use App\Http\Controllers\MerchantController;
use App\Livewire\Counter;
use App\Livewire\MerchantComponent;
use App\Livewire\ProductComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect("login");
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/merchants', MerchantComponent::class)->name('merchant');
    Route::get('/products', ProductComponent::class)->name('product');

    // Route::get('/merchants', function () {
    //     return view("product");
    // })->name('merchant');

    // Route::get('/products', function () {
    //     return view("product");
    // })->name('product');
});

Route::get('/counter', Counter::class);
