<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\Mysql\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\Mysql\Clauses\WhereElement;
use OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement;
use OlajosCs\QueryBuilder\Operator;

/**
 * Class WhereTest
 *
 * Testing where clauses of the query builder
 */
class WhereTest extends MySQL
{
    /**
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement::__construct()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement::getField()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement::getOperator()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement::getGlue()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement::getValues()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement::asString()
     *
     * @return void
     */
    public function testWhereClause()
    {
        $where1 = new WhereElement('id', '>', 1);

        $this->assertEquals('id', $where1->getField());
        $this->assertEquals('>', $where1->getOperator());
        $this->assertEquals([':where0' => 1], $where1->getValues());
        $this->assertEquals(WhereElement::GLUE_AND, $where1->getGlue());
        $this->assertEquals('id > :where0', $where1->asString());

        $where2 = new WhereElement('id', '=', 2, WhereElement::GLUE_OR);
        $this->assertEquals('id', $where2->getField());
        $this->assertEquals('=', $where2->getOperator());
        $this->assertEquals([':where1' => 2], $where2->getValues());
        $this->assertEquals(WhereElement::GLUE_OR, $where2->getGlue());
        $this->assertEquals('id = :where1', $where2->asString());
    }


    /**
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer::getParameters()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer::add()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer::get()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer::has()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer::asString()
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
                ':where2' => 1,
                ':where3' => 2,
            ],
            $whereContainer->getParameters()
        );
    }


    /**
     * Test where conditions
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::where()
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
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::whereOr()
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
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::whereIn()
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
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::whereNotIn()
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
}
