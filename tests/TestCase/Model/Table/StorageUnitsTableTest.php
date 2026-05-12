<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StorageUnitsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StorageUnitsTable Test Case
 */
class StorageUnitsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StorageUnitsTable
     */
    protected $StorageUnits;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.StorageUnits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('StorageUnits') ? [] : ['className' => StorageUnitsTable::class];
        $this->StorageUnits = $this->getTableLocator()->get('StorageUnits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->StorageUnits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\StorageUnitsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\StorageUnitsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
