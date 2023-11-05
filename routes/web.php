<?php

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

Route::get('testprint', function () {
    $printers = Printing::printers();

    $printJob = Printing::newPrintTask()
        ->content('okok')
        ->printer($printers->first()->id())
        ->send();

    echo $printJob->id();


    $receipt = (string) (new ReceiptPrinter)
        ->centerAlign()
        ->text('My heading')
        ->leftAlign()
        ->line()
        ->twoColumnText('Item 1', '2.00')
        ->twoColumnText('Item 2', '4.00')
        ->feed(2)
        ->centerAlign()
        ->barcode('1234')
        ->cut();

        dd($receipt);
    $printers = Printing::printers();

    // Now send the string to your receipt printer
    Printing::newPrintTask()
        ->printer($printers->first()->id())
        ->content('hello world')
        ->send();
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::redirect('/waiter', '/waiter/cards')->name('waiter');

    /**
     * ROTAS DO GARÇOM
     */
    // Comandas
    Route::view('/waiter/cards', 'waiter.card')->name('waiter.card');
    Route::view('/waiter/cards/{card}', 'waiter.card-view')->name('waiter.card-view');
    Route::get('/waiter/cards/{card}/print', [CardController::class, 'printCard'])->name('waiter.card-view.print');
    Route::view('/waiter/cards/{card}/new-order', 'waiter.new-order')->name('waiter.new-order');
    Route::view('/waiter/cards/{card}/payment', 'waiter.payment')->name('waiter.payment');
    // Comandas Físicas
    Route::view('/waiter/cards-physical', 'waiter.cards-physical')->name('waiter.cards-physical');
    Route::view('/waiter/cards-physical/{cardPhysical}', 'waiter.cards-physical-view')->name('waiter.cards-physical-view');
    // Mesas
    Route::view('/waiter/tables', 'waiter.table')->name('waiter.table');
    Route::view('/waiter/table/{table}', 'waiter.table-view')->name('waiter.table-view');
    // Pedidos
    Route::view('/waiter/orders', 'waiter.order')->name('waiter.order');

    /**
     * ROTAS DAS ATRAÇÕES
     */
    Route::redirect('/attraction', '/attraction/entities')->name('attraction');
    Route::view('/attraction/entities', 'attraction.entities')->name('attraction.entities');
    Route::view('/attraction/queues', 'attraction.queues')->name('attraction.queues');

    /**
     * ROTAS DO BAR
     */
    Route::redirect('/bar', '/bar/orders')->name('bar');
    Route::view('/bar/orders', 'bar.orders')->name('bar.orders');

    /**
     * ROTAS DA COZINHA
     */
    Route::redirect('/kitchen', '/kitchen/orders')->name('kitchen');
    Route::view('/kitchen/orders', 'kitchen.orders')->name('kitchen.orders');

    /**
     * ROTAS DO CAIXA
     */
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
});

/**
 * ROTAS DOS CLIENTES
 */
Route::view('/costumer/virtual/{card}', 'costumer.card.virtual')->name('costumer.card.virtual')->middleware('costumer.virtual.card');
Route::view('/costumer/physical/{cardPhysical}', 'costumer.card.physical')->name('costumer.card.physical')->middleware('costumer.physical.card');
Route::view('/costumer/table/{table}', 'costumer.table')->name('costumer.table')->middleware('costumer.table');
Route::view('/costumer/new-order', 'costumer.new-order')->name('costumer.new-order')->middleware('auth.costumer');
