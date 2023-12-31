<?php

namespace App\Http\Middleware;

use App\Actions\CreateNewLogsQrCodeAction;
use App\Enums\TableStatus;
use App\Models\Table;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CostumerTable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $table = Table::where('uuid', $request->table)->whereIn('status', [TableStatus::InUse->value, TableStatus::Grouped->value])->first();

        if ($table) {
            Session::put('costumer', ['type' => 'table', 'data' => $table]);
            CreateNewLogsQrCodeAction::handle($table::class, $table->id, $request->ip());

            return $next($request);
        } else {
            abort(401, 'Não autorizado');
        }
    }
}
