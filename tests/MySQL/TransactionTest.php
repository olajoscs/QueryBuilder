<?php

namespace OlajosCs\QueryBuilder\MySQL;

/**
 * Class TransactionTest
 *
 * Testing transaction in mysql
 */
class TransactionTest extends MySQL
{
    /**
     * Test the rollback of the transaction
     *
     * @return void
     */
    public function testRollback()
    {
        $connection = $this->getConnection();

        $before = $connection->getOneField(
            'SELECT count(1) AS counter FROM querybuilder_tests',
            [],
            'counter'
        );

        try {
            $connection->transaction(function() use ($connection) {
                $connection
                    ->insert()
                    ->into('querybuilder_tests')->values(
                        [
                            'id'         => 1234,
                            'languageId' => 1,
                            'field'      => 'pppp',
                        ]
                    )
                    ->execute();

                throw new \Exception('Test exception');
            });
        } catch (\Exception $e) {
            // It's ok now to not have anything here
        }

        $after = $connection->getOneField(
            'SELECT count(1) AS counter FROM querybuilder_tests',
            [],
            'counter'
        );

        $this->assertEquals($before, $after);
    }


    /**
     * Test a successful transaction
     *
     * @return void
     */
    public function testCommit()
    {
        $connection = $this->getConnection();

        $before = $connection->getOneField(
            'SELECT count(1) AS counter FROM querybuilder_tests',
            [],
            'counter'
        );

        $connection->transaction(function() use ($connection) {
            $connection
                ->insert()
                ->into('querybuilder_tests')->values(
                    [
                        'id'         => 1234,
                        'languageId' => 1,
                        'field'      => 'pppp',
                    ]
                )
                ->execute();
        });

        $after = $connection->getOneField(
            'SELECT count(1) AS counter FROM querybuilder_tests',
            [],
            'counter'
        );

        $this->assertEquals($before + 1, $after);
    }


    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->seed();
    }
}
