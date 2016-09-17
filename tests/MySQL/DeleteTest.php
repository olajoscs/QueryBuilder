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
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->seed();
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
}