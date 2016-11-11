<?php

namespace OlajosCs\QueryBuilder\MySQL;

/**
 * Class RawExpressionTest
 *
 * Test RawExpression object and handling of it
 */
class RawExpressionTest extends MySQL
{
    /**
     * Test RawExpression when it is in the field list of a select
     *
     * @return void
     */
    public function testRawInSelect()
    {
        $connection = $this->getConnection();

        $counter = $connection
            ->select($connection->createRawExpression('count(1) as counter'))
            ->from('querybuilder_tests')
            ->getOneField('counter');

        $this->assertEquals(10, $counter);

        $counters = $connection
            ->select([$connection->createRawExpression('count(1) as counter'), 'languageId'])
            ->from('querybuilder_tests')
            ->groupBy('languageId')
            ->get();

        $this->assertCount(2, $counters);
    }


    /**
     * Test RawExpression where it is in the where clause in select statement
     *
     * @return void
     */
    public function testRawInSelectWhere()
    {
        $connection = $this->getConnection();

        $counter = $connection
            ->select($connection->createRawExpression('count(1) as counter'))
            ->from('querybuilder_tests')
            ->whereRaw($connection->createRawExpression('languageId = 1'))
            ->getOneField('counter');

        $this->assertEquals(5, $counter);

        $counter = $connection
            ->select($connection->createRawExpression('count(1) as counter'))
            ->from('querybuilder_tests')
            ->whereRaw($connection->createRawExpression('languageId = :languageId'), ['languageId' => 1])
            ->getOneField('counter');


        $this->assertEquals(5, $counter);
    }


    /**
     * Test RawExpression where it is in the where clause in update statement
     *
     * @return void
     */
    public function testRawInUpdateWhere()
    {
        $connection = $this->getConnection();

        $statement = $connection
            ->update('querybuilder_tests')
            ->set(
                [
                    'languageId' => 3,
                ]
            )
            ->whereRaw($connection->createRawExpression('languageId = 2'))
            ->execute();

        $this->assertEquals(5, $statement->rowCount());
    }


    /**
     * Test RawExpression where it is in the where clause in delete statement
     *
     * @return void
     */
    public function testRawInDeleteWhere()
    {
        $connection = $this->getConnection();

        $statement = $connection
            ->delete()
            ->from('querybuilder_tests')
            ->whereRaw($connection->createRawExpression('languageId = 1'))
            ->execute();

        $this->assertEquals(5, $statement->rowCount());
    }


    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->seed();
    }
}