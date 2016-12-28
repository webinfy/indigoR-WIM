<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdminsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdminsTable Test Case
 */
class AdminsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AdminsTable
     */
    public $Admins;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.admins'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Admins') ? [] : ['className' => 'App\Model\Table\AdminsTable'];
        $this->Admins = TableRegistry::get('Admins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Admins);

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
