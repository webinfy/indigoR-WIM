<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FailedTransactionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FailedTransactionsTable Test Case
 */
class FailedTransactionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FailedTransactionsTable
     */
    public $FailedTransactions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.failed_transactions',
        'app.transactions',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FailedTransactions') ? [] : ['className' => 'App\Model\Table\FailedTransactionsTable'];
        $this->FailedTransactions = TableRegistry::get('FailedTransactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FailedTransactions);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
