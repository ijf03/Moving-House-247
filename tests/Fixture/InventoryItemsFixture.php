<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InventoryItemsFixture
 */
class InventoryItemsFixture extends TestFixture
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
                'inventory_item_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'category' => 'Lorem ipsum dolor sit amet',
                'quantity_on_hand' => 1,
                'reorder_threshold' => 1,
                'unit' => 'Lorem ipsum dolor ',
                'storage_location' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'created' => '2026-05-03 09:01:02',
                'modified' => '2026-05-03 09:01:02',
            ],
        ];
        parent::init();
    }
}
