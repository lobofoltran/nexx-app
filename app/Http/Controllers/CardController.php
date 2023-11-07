<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Rawilk\Printing\Receipts\ReceiptPrinter;

class CardController extends Controller
{
    public function printCard(Card $card, Request $request)
    {
        $enterprise = Enterprise::find($card->owner_id);
        
        return view('print.recieve', compact('card', 'enterprise'));
    }

    public function printReceiptCard(Card $card, Request $request)
    {
        $enterprise = Enterprise::find($card->owner_id);

        return view('print.card', compact('card', 'enterprise'));
    }
}
