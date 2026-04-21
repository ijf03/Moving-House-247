<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvoiceItemsFixture
 */
class InvoiceItemsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'invoice_item_id' => 1,
                'invoice_id' => 1,
                'description' => 'Lorem ipsum dolor sit amet',
                'quantity' => 1.5,
                'unit_price_cents' => 1,
                'line_total_cents' => 1,
                'sort_order' => 1,
                'created' => '2026-04-19 06:59:04',
                'modified' => '2026-04-19 06:59:04',
            ],
        ];
        parent::init();
    }
}
