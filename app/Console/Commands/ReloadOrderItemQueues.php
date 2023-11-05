<?php

namespace App\Console\Commands;

use App\Services\QueuesEntitiesService;
use Illuminate\Console\Command;

class ReloadOrderItemQueues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reload-order-item-queues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recarrega os itens da fila de atração';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        QueuesEntitiesService::reloadAll();

        $this->info('Recarregado com sucesso.');
    }
}
