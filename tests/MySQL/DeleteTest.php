<?php

namespace OlajosCs\QueryBuilder\MySQL;

/**
 * Class DeleteTest
 *
 * Test delete statement
 */
class DeleteTest extends MySQL
{
    /**
     * Test the deletion with a where condition
     *
     * @return void
     */
    public function testDeleteWhere()
    {
        $connection = $this->getConnection();

        $countQuery = $connection
            ->select()
            ->from('querybuilder_tests');

        $originalCount = count($countQuery->get());

        $connection
            ->delete()
            ->from('querybuilder_tests')
            ->where('id', '=', 1)
            ->execute();

        $resultCount = count($countQuery->get());

        $this->assertEquals($originalCount - 1, $resultCount);
    }


    /**
     * Test the deletion of rows
     *
     * @return void
     */
    public function testDelete()
    {
        $connection = $this->getConnection();

        $statement = $connection
            ->delete()
            ->from('querybuilder_tests')
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(10, $statement->rowCount());


        $result = $connection
            ->select()
            ->from('querybuilder_tests')
            ->get();

        $this->assertEquals([], $result);
    }


    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->seed();
    }
}