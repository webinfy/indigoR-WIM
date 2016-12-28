<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FailedTransactionsFixture
 *
 */
class FailedTransactionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'transaction_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_recovered' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '1=Yes/0=NO', 'precision' => null],
        'recovered_at' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Recovery Date', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'transaction_id' => 1,
            'is_recovered' => 1,
            'recovered_at' => '2016-11-16 07:18:09'
        ],
    ];
}
