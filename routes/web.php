<?php

use App\Enums\RolesEnum;
use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;
use Rawilk\Printing\Facades\Printing;
use Rawilk\Printing\Receipts\ReceiptPrinter;

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

Route::get('artisan/migrate', function() {
    Artisan::call('migrate:fresh', [
        '--seed',
        '--force' => true,
    ]);
});

Route::get('artisan/storage', function() {
    Artisan::call('storage:link');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    
    Route::group(['middleware' => ['role:' . RolesEnum::WAITER->value]], function () {
        Route::redirect('/waiter', '/waiter/cards')->name('waiter');
        Route::view('/waiter/cards', 'waiter.card')->name('waiter.card');
        Route::view('/waiter/cards/{card}', 'waiter.card-view')->name('waiter.card-view');
        Route::get('/waiter/cards/{card}/print', [CardController::class, 'printCard'])->name('waiter.card-view.print');
        Route::view('/waiter/cards/{card}/new-order', 'waiter.new-order')->name('waiter.new-order');
        Route::view('/waiter/cards/{card}/payment', 'waiter.payment')->name('waiter.payment');
        Route::view('/waiter/cards-physical', 'waiter.cards-physical')->name('waiter.cards-physical');
        Route::view('/waiter/cards-physical/{cardPhysical}', 'waiter.cards-physical-view')->name('waiter.cards-physical-view');
        Route::view('/waiter/tables', 'waiter.table')->name('waiter.table');
        Route::view('/waiter/table/{table}', 'waiter.table-view')->name('waiter.table-view');
        Route::view('/waiter/orders', 'waiter.order')->name('waiter.order');
        Route::view('/waiter/calls', 'waiter.calls')->name('waiter.calls');
    });

    Route::group(['middleware' => ['role:' . RolesEnum::ATTRACTION->value]], function () {
        Route::redirect('/attraction', '/attraction/entities')->name('attraction');
        Route::view('/attraction/entities', 'attraction.entities')->name('attraction.entities');
        Route::view('/attraction/queues', 'attraction.queues')->name('attraction.queues');
    });

    Route::group(['middleware' => ['role:' . RolesEnum::BAR->value]], function () {
        Route::redirect('/bar', '/bar/orders')->name('bar');
        Route::view('/bar/orders', 'bar.orders')->name('bar.orders');
    });

    Route::group(['middleware' => ['role:' . RolesEnum::KITCHEN->value]], function () {
        Route::redirect('/kitchen', '/kitchen/orders')->name('kitchen');
        Route::view('/kitchen/orders', 'kitchen.orders')->name('kitchen.orders');
    });

    Route::group(['middleware' => ['role:' . RolesEnum::CASHIER->value]], function () {
        Route::redirect('/cashier', '/cashier/cards')->name('cashier');
        Route::view('/cashier/cards', 'cashier.cards')->name('cashier.cards');
        Route::view('/cashier/cards/{card}', 'cashier.card-view')->name('cashier.card-view');
        Route::get('/cashier/cards/{card}/receipt', [CardController::class, 'printReceiptCard'])->name('cashier.card-view.print');
        Route::view('/cashier/cards/{card}/new-order', 'cashier.new-order')->name('cashier.new-order');
        Route::view('/cashier/cards/{card}/payment', 'cashier.payment')->name('cashier.payment');
        Route::view('/cashier/cards-physical', 'cashier.cards-physical')->name('cashier.cards-physical');
        Route::view('/cashier/cards-physical/{cardPhysical}', 'cashier.cards-physical-view')->name('cashier.cards-physical-view');
        Route::view('/cashier/tables', 'cashier.table')->name('cashier.table');
        Route::view('/cashier/tables/{table}', 'cashier.table-view')->name('cashier.table-view');
        // Route::view('/cashier/orders', 'cashier.orders')->name('cashier.orders');
        Route::view('/cashier/calls', 'cashier.calls')->name('cashier.calls');
    });

});

Route::view('/costumer/virtual/{card}', 'costumer.card.virtual')->name('costumer.card.virtual')->middleware('costumer.virtual.card');
Route::view('/costumer/physical/{cardPhysical}', 'costumer.card.physical')->name('costumer.card.physical')->middleware('costumer.physical.card');
Route::view('/costumer/table/{table}', 'costumer.table')->name('costumer.table')->middleware('costumer.table');
Route::view('/costumer/new-order', 'costumer.new-order')->name('costumer.new-order')->middleware('auth.costumer');
