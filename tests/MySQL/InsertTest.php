<?php

namespace OlajosCs\QueryBuilder\MySQL;


/**
 * Class InsertTeset
 *
 * Test insert statements
 */
class InsertTest extends MySQLTestCase
{
    /**
     * Test insert statements then check the results
     *
     * @return void
     */
    public function testInsert()
    {
        $statement = $this->getQueryBuilderConnection()
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

        $result = $this->getQueryBuilderConnection()
            ->select('count(1) as counter')
            ->from('querybuilder_tests')
            ->getOneField('counter');

        $this->assertEquals(11, $result);

        $statement = $this->getQueryBuilderConnection()
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

        $result = $this->getQueryBuilderConnection()
            ->select('count(1) as counter')
            ->from('querybuilder_tests')
            ->getOneField('counter');

        $this->assertEquals(12, $result);
    }


    /**
     * Test that multiple rows can be inserted in one statement
     *
     * @return void
     */
    public function testMultipleInserts()
    {
        $statement = $this->getQueryBuilderConnection()
            ->insert()
            ->into('querybuilder_tests')
            ->values(
                [
                    [
                        'id'         => 10,
                        'languageId' => 1,
                        'field'      => 'mult1',
                    ],
                    [
                        'id'         => 11,
                        'languageId' => 1,
                        'field'      => 'mult2',
                    ],
                ]
            )
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(2, $statement->rowCount());

        $result = $this->getQueryBuilderConnection()
            ->select('count(1) as counter')
            ->from('querybuilder_tests')
            ->getOneField('counter');

        $this->assertEquals(12, $result);
    }

}