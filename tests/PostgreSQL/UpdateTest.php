<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;


/**
 * Class UpdateTest
 *
 * Test update statment
 */
class UpdateTest extends PostgreSQLTestCase
{
    /**
     * Test a basic update statement as string
     *
     * @return void
     */
    public function testUpdateClause()
    {
        $connection = $this->getQueryBuilderConnection();

        $query = $connection->update('strings')->set(['value' => 'asdf'])->asString();
        $expected = 'UPDATE "strings" SET "value" = :value';

        $this->assertEquals($expected, $query);
    }


    /**
     * Test an update statement with where condition
     * Test that only the row which fits the condition is updated
     *
     * @return void
     */
    public function testUpdateWhere()
    {
        $connection = $this->getQueryBuilderConnection();

        $statement = $connection
            ->update('querybuilder_tests')
            ->set(['field' => 'asdf'])
            ->where('id', '=', 1)
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(1, $statement->rowCount());

        $result = $connection
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '=', 1)
            ->getOneField();

        $this->assertEquals('asdf', $result);

        $result = $connection
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '!=', 1)
            ->limit(1)
            ->getOneField();

        $this->assertNotEquals('asdf', $result);
    }


    /**
     * Test an update statement with whereOr condition
     *
     * @return void
     */
    public function testUpdateWhereOr()
    {
        $connection = $this->getQueryBuilderConnection();

        $statement = $connection
            ->update('querybuilder_tests')
            ->set(['field' => 'asdf'])
            ->where('id', '=', 1)
            ->whereOr('id', '=', 2)
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(2, $statement->rowCount());

        $result = $connection
            ->select()
            ->from('querybuilder_tests')
            ->where('id', '=', 1)
            ->whereOr('id', '=', 2)
            ->getList('field');

        $this->assertEquals(['asdf', 'asdf'], $result);
    }


    /**
     * Test an update statement with whereOr condition
     *
     * @return void
     */
    public function testUpdateWhereIn()
    {
        $connection = $this->getQueryBuilderConnection();

        $statement = $connection
            ->update('querybuilder_tests')
            ->set(['field' => 'qwer'])
            ->whereIn('id', [1, 2, 3, 4])
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(4, $statement->rowCount());

        $result = $connection
            ->select()
            ->from('querybuilder_tests')
            ->whereIn('id', [1, 2, 3, 4])
            ->get();

        $expected = [
            (object)[
                'id'         => '1',
                'languageId' => '1',
                'field'      => 'qwer',
            ],
            (object)[
                'id'         => '2',
                'languageId' => '1',
                'field'      => 'qwer',
            ],
            (object)[
                'id'         => '3',
                'languageId' => '1',
                'field'      => 'qwer',
            ],
            (object)[
                'id'         => '4',
                'languageId' => '1',
                'field'      => 'qwer',
            ],
        ];

        $this->assertEquals($expected, $result);
    }


    /**
     * Test an update statement with whereOr condition
     *
     * @return void
     */
    public function testUpdateWhereNotIn()
    {
        $connection = $this->getQueryBuilderConnection();

        $statement = $connection
            ->update('querybuilder_tests')
            ->set(['field' => 'wert'])
            ->whereNotIn('id', [5, 6, 7, 8, 9])
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(5, $statement->rowCount());

        $result = $connection
            ->select()
            ->from('querybuilder_tests')
            ->whereNotIn('id', [5, 6, 7, 8, 9])
            ->get();

        $expected = [
            (object)[
                'id'         => '0',
                'languageId' => '1',
                'field'      => 'wert',
            ],
            (object)[
                'id'         => '1',
                'languageId' => '1',
                'field'      => 'wert',
            ],
            (object)[
                'id'         => '2',
                'languageId' => '1',
                'field'      => 'wert',
            ],
            (object)[
                'id'         => '3',
                'languageId' => '1',
                'field'      => 'wert',
            ],
            (object)[
                'id'         => '4',
                'languageId' => '1',
                'field'      => 'wert',
            ],
        ];

        $this->assertEquals($expected, $result);
    }


    /**
     * Test an update statement with whereOr condition
     *
     * @return void
     */
    public function testUpdateWhereBetween()
    {
        $connection = $this->getQueryBuilderConnection();

        $statement = $connection
            ->update('querybuilder_tests')
            ->set(['field' => 'sdfg'])
            ->whereBetween('id', 2, 4)
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(3, $statement->rowCount());

        $result = $connection
            ->select()
            ->from('querybuilder_tests')
            ->whereBetween('id', 2, 4)
            ->get();

        $expected = [
            (object)[
                'id'         => '2',
                'languageId' => '1',
                'field'      => 'sdfg',
            ],
            (object)[
                'id'         => '3',
                'languageId' => '1',
                'field'      => 'sdfg',
            ],
            (object)[
                'id'         => '4',
                'languageId' => '1',
                'field'      => 'sdfg',
            ],
        ];

        $this->assertEquals($expected, $result);
    }
}