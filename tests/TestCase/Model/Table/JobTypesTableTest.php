<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\JobTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\JobTypesTable Test Case
 */
class JobTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\JobTypesTable
     */
    protected $JobTypes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.JobTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('JobTypes') ? [] : ['className' => JobTypesTable::class];
        $this->JobTypes = $this->getTableLocator()->get('JobTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->JobTypes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\JobTypesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
