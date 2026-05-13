<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AvailabilityTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AvailabilityTable Test Case
 */
class AvailabilityTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AvailabilityTable
     */
    protected $Availability;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Availability',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Availability') ? [] : ['className' => AvailabilityTable::class];
        $this->Availability = $this->getTableLocator()->get('Availability', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Availability);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\AvailabilityTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
