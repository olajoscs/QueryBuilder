<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\Exceptions\InvalidGlueException;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement;

/**
 * Class WhereTest
 *
 * Testing where clauses of the query builder
 */
class SelectWhereTest extends MySQL
{
    /**
     *
     * @return void
     */
    public function testWhereClause()
    {
        $where1 = new WhereElement('id', '>', 1);
        $this->assertEquals('id', $where1->getField());
        $this->assertEquals('>', $where1->getOperator());
        $this->assertEquals(['where0' => 1], $where1->getValues());
        $this->assertEquals(WhereElement::GLUE_AND, $where1->getGlue());
        $this->assertEquals('id > :where0', $where1->asString());

        $where2 = new WhereElement('id', '=', 2, WhereElement::GLUE_OR);
        $this->assertEquals('id', $where2->getField());
        $this->assertEquals('=', $where2->getOperator());
        $this->assertEquals(['where1' => 2], $where2->getValues());
        $this->assertEquals(WhereElement::GLUE_OR, $where2->getGlue());
        $this->assertEquals('id = :where1', $where2->asString());
    }


    /**
     *
     * @return void
     */
    public function testWhereContainer()
    {
        $where1 = new WhereElement('id', '>', 1);
        $where2 = new WhereElement('id', '=', 2, WhereElement::GLUE_OR);

        $whereContainer = new WhereContainer();
        $whereContainer->add($where1);
        $whereContainer->add($where2);

        $this->assertEquals([$where1, $where2], $whereContainer->get());
        $this->assertEquals(' WHERE id > :where2 OR id = :where3', $whereContainer->asString());
        $this->assertEquals(
            [
                'where2' => 1,
                'where3' => 2,
            ],
            $whereContainer->getParameters()
        );
    }


    /**
     * Test where conditions
     *
     *
     * @return void
     */
    public function testWhere()
    {
        $connection = $this->getConnection();

        $string = 'SELECT * FROM strings WHERE id > :where4';
        $query = $connection
            ->select()
            ->from('strings')
            ->where('id', '>', 1);
        $this->assertEquals($string, $query->asString());
    }


    /**
     * Test where conditions with or
     *
     *
     * @return void
     */
    public function testWhereOr()
    {
        $connection = $this->getConnection();

        $query = $connection
            ->select('id')
            ->from('strings')
            ->whereOr('id', '=', 1)
            ->whereOr('id', '=', 2);
        $string = 'SELECT id FROM strings WHERE id = :where5 OR id = :where6';

        $this->assertEquals($string, $query->asString());
    }


    /**
     * Tests where in condition
     *
     *
     * @return void
     */
    public function testWhereIn()
    {
        $connection = $this->getConnection();

        $query = $connection
            ->select('id')
            ->from('strings')
            ->whereIn('id', [1, 2, 3, 4]);

        $string = 'SELECT id FROM strings WHERE id IN (:where7,:where8,:where9,:where10)';

        $this->assertEquals($string, $query->asString());
    }


    /**
     * Tests where in condition
     *
     *
     * @return void
     */
    public function testWhereNotIn()
    {
        $connection = $this->getConnection();

        $query = $connection
            ->select('id')
            ->from('strings')
            ->whereNotIn('id', [1, 2, 3, 4]);

        $string = 'SELECT id FROM strings WHERE id NOT IN (:where11,:where12,:where13,:where14)';

        $this->assertEquals($string, $query->asString());
    }


    /**
     * Tests where between condition
     *
     *
     * @return void
     */
    public function testWhereBetween()
    {
        $connection = $this->getConnection();

        $query = $connection
            ->select('id')
            ->from('strings')
            ->whereBetween('id', 1, 8);

        $string = 'SELECT id FROM strings WHERE id BETWEEN :where15 AND :where16';

        $this->assertEquals($string, $query->asString());
    }


    /**
     * Test that in case of nok glue exception is thrown
     *
     *
     * @return void
     */
    public function testInvalidGlue()
    {
        $this->expectException(InvalidGlueException::class);

        $where = new WhereElement('id', '=', 2, 'xor');
        $container = new WhereContainer();

        $container->add($where);
        $container->asString();
    }


    /**
     * Test the where field is null clause
     *
     *
     *
     * @return void
     */
    public function testIsNull()
    {
        $connection = $this->getConnection();

        $statement = $connection->select()
            ->from('strings')
            ->whereNull('languageId');
        $string = 'SELECT * FROM strings WHERE languageId IS NULL';
        $this->assertEquals($string, $statement->asString());

        $statement = $connection->select()
            ->from('strings')
            ->whereNotNull('languageId');
        $string = 'SELECT * FROM strings WHERE languageId IS NOT NULL';
        $this->assertEquals($string, $statement->asString());

        $statement = $connection->select()
            ->from('strings')
            ->whereNull('a')
            ->whereNotNull('b')
            ->whereNullOr('c')
            ->whereNotNullOr('d');
        $string = 'SELECT * FROM strings WHERE a IS NULL AND b IS NOT NULL OR c IS NULL OR d IS NOT NULL';
        $this->assertEquals($string, $statement->asString());
    }
}
