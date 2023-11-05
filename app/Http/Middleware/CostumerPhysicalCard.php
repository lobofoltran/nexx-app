<?php

namespace App\Http\Middleware;

use App\Enums\CardPhysicalStatus;
use App\Models\CardPhysical;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CostumerPhysicalCard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cardPhysical = CardPhysical::where('uuid', $request->cardPhysical)->whereIn('status', [CardPhysicalStatus::Available->value])->first();

        if ($cardPhysical) {
            Session::put('costumer', ['type' => 'card.physical', 'data' => $cardPhysical]);

            return $next($request);
        } else {
            abort(401, 'Não autorizado');
        }
    }
}
