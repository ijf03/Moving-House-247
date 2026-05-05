<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BookingResourcesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BookingResourcesTable Test Case
 */
class BookingResourcesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BookingResourcesTable
     */
    protected $BookingResources;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BookingResources',
        'app.Bookings',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BookingResources') ? [] : ['className' => BookingResourcesTable::class];
        $this->BookingResources = $this->getTableLocator()->get('BookingResources', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BookingResources);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\BookingResourcesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\BookingResourcesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
