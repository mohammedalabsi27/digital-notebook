<?php

use App\Http\Controllers\CustomerSupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TransactionController;
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
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Shop
    Route::prefix('/shop')->name('shop.')->controller(ShopController::class)
        ->group(function () {
            Route::get('/profile', 'edit')->name('edit');
            Route::put('/profile', 'update')->name('update');
    }); 

    // Customers
    Route::resource('customers-suppliers', CustomerSupplierController::class);


    // Transactions
    Route::resource('transactions', TransactionController::class);
    // Route::prefix('/transactions')->name('transactions.')->controller(TransactionController::class)->group(function () {
    //     Route::post('/customers/{customer}/transactions', 'store')->name('store');
    //     Route::get('/', 'index')->name('index');
    //     Route::get('/create', 'create')->name('create');
    // });
     
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::view('/cc', 'index2');
Route::view('/dd', 'dashboard2');
Route::view('/tt', 'tran2');

require __DIR__.'/auth.php';
