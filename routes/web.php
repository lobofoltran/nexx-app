<?php

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
    Route::view('/waiter/cards', 'waiter.card')->name('waiter.card');
    Route::view('/waiter/cards/{id}', 'waiter.card-view')->name('waiter.card-view');
    Route::view('/waiter/cards/{id}/new-order', 'waiter.new-order')->name('waiter.new-order');

    Route::view('/waiter/tables', 'waiter.table')->name('waiter.table');
    Route::view('/waiter/orders', 'waiter.order')->name('waiter.order');
});
