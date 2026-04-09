<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContactFormsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContactFormsTable Test Case
 */
class ContactFormsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContactFormsTable
     */
    protected $ContactForms;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ContactForms',
        'app.Customers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ContactForms') ? [] : ['className' => ContactFormsTable::class];
        $this->ContactForms = $this->getTableLocator()->get('ContactForms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContactForms);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ContactFormsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ContactFormsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
