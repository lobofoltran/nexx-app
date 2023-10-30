<?php

namespace Tests\Unit;

use App\Actions\CreateNewCardAction;
use App\Actions\CreateNewOrderAction;
use App\Actions\CreateNewPaymentAction;
use App\Actions\CreateNewPaymentMethodAction;
use App\Actions\CreateNewProductAction;
use App\Actions\CreateNewProductCategoryAction;
use App\Actions\CreateNewTableAction;
use App\Enums\TableStatus;
use App\Models\Table;
use App\Services\PaymentService;
use Tests\TestCase;

class CreateTableTest extends TestCase
{
    public function test_table_can_created(): void
    {
        $table = CreateNewTableAction::handle();

        $this->assertTrue($table->exists());
    }
    public function test_table_with_identity_can_created(): void
    {
        $identity = 'Teste';

        $table = CreateNewTableAction::handle($identity);
        
        $this->assertTrue($table->exists());
        $this->assertTrue($table->identity === $identity);
    }

    public function test_table_status_after_card_paid(): void
    {
        $consum = 50;
        $table = CreateNewTableAction::handle();
        $card = CreateNewCardAction::handle($table);

        CreateNewOrderAction::handle($card, [
            CreateNewProductAction::handle(CreateNewProductCategoryAction::handle('Produtos'), 'Produto teste', value: $consum)
        ]);

        $paymentMethod = CreateNewPaymentMethodAction::handle('Dinheiro');
        $payment = CreateNewPaymentAction::handle($card, $paymentMethod, $consum);
        PaymentService::setConcluded($payment);

        $table->refresh();

        $this->assertTrue($table->status === TableStatus::WaitingCleaning->value);
    }
}
