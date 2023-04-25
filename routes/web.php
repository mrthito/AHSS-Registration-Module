<?php

use App\Http\Controllers\Api\WordpressController;
use Illuminate\Support\Facades\DB;
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
    return view('welcome');
});

Route::get('/stripe/pay/pending', [WordpressController::class, 'pay_pending'])->name('stripe.pay.pending');
Route::get('/stripe/{user_id}', [WordpressController::class, 'index'])->name('stripe');
Route::any('/stripe/{user_id}/success', [WordpressController::class, 'success'])->name('stripe.success');
Route::any('/stripe/{user_id}/success/active', [WordpressController::class, 'success_active'])->name('stripe.success.active');
Route::any('/stripe/{user_id}/success/code', [WordpressController::class, 'success_code'])->name('stripe.success.code');
Route::any('/stripe/{user_id}/cancel', [WordpressController::class, 'cancel'])->name('stripe.cancel');

Route::get('/upload', function () {
    return view('upload');
});

Route::post('/upload', [WordpressController::class, 'uploadCSVUser'])->name('upload');

Route::get('/lll', function () {
    return config('database');
});

Route::get('/insert-invoice', [WordpressController::class, 'insertInvoice'])->name('insert-invoice');
Route::post('/insert-invoice', [WordpressController::class, 'insertInvoiceSave'])->name('insert-invoice');
