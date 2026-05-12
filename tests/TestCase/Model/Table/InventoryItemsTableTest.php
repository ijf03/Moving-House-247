<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InventoryItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InventoryItemsTable Test Case
 */
class InventoryItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InventoryItemsTable
     */
    protected $InventoryItems;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.InventoryItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('InventoryItems') ? [] : ['className' => InventoryItemsTable::class];
        $this->InventoryItems = $this->getTableLocator()->get('InventoryItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->InventoryItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\InventoryItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
