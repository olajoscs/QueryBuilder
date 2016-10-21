<?php

namespace OlajosCs\QueryBuilder\MySQL;


/**
 * Class InsertTeset
 *
 * Test insert statements
 */
class InsertTest extends MySQL
{
    /**
     * Test insert statements then check the results
     *
     * @return void
     */
    public function testInsert()
    {
        $statement = $this->getConnection()
            ->insert()
            ->into('querybuilder_tests')
            ->values(
                [
                    'id'         => 10,
                    'languageId' => 1,
                    'field'      => 'zzzz',
                ]
            )->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(1, $statement->rowCount());

        $result = $this->getConnection()
            ->select('count(1) as counter')
            ->from('querybuilder_tests')
            ->getOneField('counter');

        $this->assertEquals(11, $result);

        $statement = $this->getConnection()
            ->insert(
                [
                    'id'         => 11,
                    'languageId' => 1,
                    'field'      => 'yyyy',
                ]
            )
            ->into('querybuilder_tests')
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(1, $statement->rowCount());

        $result = $this->getConnection()
            ->select('count(1) as counter')
            ->from('querybuilder_tests')
            ->getOneField('counter');

        $this->assertEquals(12, $result);
    }


    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->seed();
    }

}