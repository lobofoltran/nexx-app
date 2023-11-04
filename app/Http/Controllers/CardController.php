<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function printCard(Card $card, Request $request)
    {
        $route = $request->schemeAndHttpHost() . "/clients/{$card->uuid}";

        return view('print.card', compact('route'));
    }

    public function printReceiptCard(Request $request)
    {
        return 'hello 2';
    }
}
