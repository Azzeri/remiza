<?php

// use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CathegoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FireBrigadeUnitController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ItemDatabaseController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\UsageController;

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
    return redirect('/dashboard');
});
Route::get('saveHistorySuccess/', [HistoryController::class, 'storeSuccess'])->name('saveHistorySuccess');
Route::post('saveHistoryFail/', [HistoryController::class, 'storeFail'])->name('saveHistoryFail');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/password-change', function () {
        return Inertia::render('PasswordChange');
    })->name('password.change');

    Route::post('password-change-store', [UserController::class, 'changePassword'])->name('password.change.store');

    Route::group(['middleware' => ['FirstTimeLogin']], function () {
        // Route::post('/2fa', function () {
        //     return redirect('dashboard');
        // })->name('2fa');

        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

        Route::resource('users', UserController::class, ['names' => ['index' => 'users.index']]);
        // Route::resource('users', UserController::class, ['names' => ['index' => 'users.index']])->middleware('isAdmin');
        Route::resource('sets', SetController::class, ['names' => ['index' => 'sets.index']]);
        Route::resource('cathegories', CathegoryController::class, ['names' => ['index' => 'cathegories.index']]);
        Route::resource('items', ItemController::class, ['names' => ['index' => 'items.index']]);
        Route::resource('services', ServiceController::class, ['names' => ['index' => 'services.index']]);
        Route::resource('fireBrigadeUnits', FireBrigadeUnitController::class, ['names' => ['index' => 'fireBrigadeUnits.index']]);
        Route::resource('stencils', ItemDatabaseController::class, ['names' => ['index' => 'stencils.index']]);

        // Route::resource('fireBrigadeUnits', FireBrigadeUnitController::class, ['names' => ['index' => 'fireBrigadeUnits.index']])->middleware('isGlobalAdmin');

        // Route::get('items/{item}', [ItemController::class, 'itemDetails'])->name('item.details')->middleware('belongsToUnit:item');
        // Route::get('sets/{set}', [SetController::class, 'setDetails'])->name('set.details')->middleware('belongsToUnitId');
        Route::get('items/{item}', [ItemController::class, 'itemDetails'])->name('item.details');
        Route::get('sets/{set}', [SetController::class, 'setDetails'])->name('set.details');

        Route::post('services/finish/', [ServiceController::class, 'finish']);
        Route::post('services/activate/{id}', [ServiceController::class, 'activate']);

        Route::get('items/history/{id}', [ItemController::class, 'history']);

        Route::get('loginhistory/{id}', [HistoryController::class, 'index']);

        Route::post('cathegories/deletePhoto/{id}', [CathegoryController::class, 'deletePhoto']);
        Route::post('cathegories/insertPhoto/{id}', [CathegoryController::class, 'insertPhoto']);

        Route::post('usages/insertNew/', [UsageController::class, 'insertNew'])->name('usage.new');;

        Route::get('scanner', [ScannerController::class, 'index'])->name('scanner');
    });

    // Route::get('/mfa', [UserController::class, 'mfa'])->name('mfa');
    // Route::get('/mfa/confirm', [UserController::class, 'mfaconfirm'])->name('mfa.confirm');
});


require __DIR__ . '/auth.php';
