<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\MySQL\Clauses\JoinContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement;
use OlajosCs\QueryBuilder\Operator;

/**
 * Class JoinTest
 *
 * Tests Join clause
 */
class JoinTest extends MySQL
{
    /**
     * Tests join clause in a full select query
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::join()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::asString()
     *
     * @return void
     */
    public function testInnerJoin()
    {
        $connection = $this->getConnection();

        $query = $connection
            ->select('id')
            ->from('strings')
            ->join('languages', 'id', Operator::EQ, 'languageId');

        $string = 'SELECT id FROM strings INNER JOIN languages ON strings.languageId = languages.id';

        $this->assertEquals($string, $query->asString());
    }


    /**
     * Test an individual join caluse
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement::__construct()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement::getTableLeft()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement::getTableRight()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement::getOperator()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement::getFieldLeft()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement::getFieldRight()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement::getType()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement::asString()
     *
     * @return void
     */
    public function testJoins()
    {
        $join = new JoinElement('strings', 'languageId', '=', 'language', 'id', JoinElement::TYPE_INNER);
        $this->assertEquals('strings', $join->getTableLeft());
        $this->assertEquals('languageId', $join->getFieldLeft());
        $this->assertEquals('=', $join->getOperator());
        $this->assertEquals('language', $join->getTableRight());
        $this->assertEquals('id', $join->getFieldRight());
        $this->assertEquals(JoinElement::TYPE_INNER, $join->getType());

        $string = ' INNER JOIN language ON strings.languageId = language.id';
        $this->assertEquals($string, $join->asString());
    }


    /**
     * Test an individual join container
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinContainer::has()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinContainer::get()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinContainer::add()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\JoinContainer::asString()
     *
     * @return void
     */
    public function testJoinContainer()
    {
        $join1 = new JoinElement('strings', 'languageId', '=', 'language', 'id', JoinElement::TYPE_INNER);
        $join2 = new JoinElement('strings', 'sourceId', '=', 'source', 'id', JoinElement::TYPE_LEFT);

        $container = new JoinContainer();

        $this->assertEquals(false, $container->has());
        $this->assertEquals([], $container->get());

        $container
            ->add($join1)
            ->add($join2);

        $this->assertEquals(true, $container->has());
        $this->assertEquals(
            [
                $join1,
                $join2,
            ],
            $container->get()
        );

        $string = ' INNER JOIN language ON strings.languageId = language.id LEFT JOIN source ON strings.sourceId = source.id';
        $this->assertEquals($string, $container->asString());
    }
}