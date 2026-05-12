<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvoiceItemPresetsFixture
 */
class InvoiceItemPresetsFixture extends TestFixture
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
                'invoice_item_preset_id' => 1,
                'code' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'unit_price_cents' => 1,
                'is_active' => 1,
                'sort_order' => 1,
                'created' => '2026-05-03 06:41:41',
                'modified' => '2026-05-03 06:41:41',
            ],
        ];
        parent::init();
    }
}
