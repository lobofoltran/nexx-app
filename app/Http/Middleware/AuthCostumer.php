<?php

namespace App\Http\Middleware;

use App\Enums\CardPhysicalStatus;
use App\Enums\CardStatus;
use App\Enums\TableStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthCostumer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $costumer = Session::get('costumer');

        if (!$costumer) {
            abort(401, 'Não autorizado');
        }

        if ($costumer['type'] === 'table') {
            $table = $costumer['data'];
            $table->refresh();

            if (!in_array($table->status, [TableStatus::InUse->value, TableStatus::Grouped->value])) {
                abort(401, 'Não autorizado');
            }
        } else if ($costumer['type'] === 'card.virtual') {
            $card = $costumer['data'];
            $card->refresh();

            if (!in_array($card->status, [CardStatus::Active->value, CardStatus::Grouped->value])) {
                abort(401, 'Não autorizado');
            }
        } else if ($costumer['type'] === 'card.physical') {
            $cardPhysical = $costumer['data'];
            $cardPhysical->refresh();

            if (!in_array($cardPhysical->status, [CardPhysicalStatus::InUse->value])) {
                abort(401, 'Não autorizado');
            }
        } else {
            abort(401, 'Não autorizado');
        }

        return $next($request);
    }
}
