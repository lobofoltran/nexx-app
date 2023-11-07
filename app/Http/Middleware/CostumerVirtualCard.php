<?php

namespace App\Http\Middleware;

use App\Actions\CreateNewLogsQrCodeAction;
use App\Enums\CardStatus;
use App\Models\Card;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CostumerVirtualCard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $card = Card::where('uuid', $request->card)->whereIn('status', [CardStatus::Active->value, CardStatus::Grouped->value])->first();

        if ($card) {
            Session::put('costumer', ['type' => 'card.virtual', 'data' => $card]);
            CreateNewLogsQrCodeAction::handle($card::class, $card->id, $request->ip());

            return $next($request);
        } else {
            abort(401, 'Não autorizado');
        }
    }
}
