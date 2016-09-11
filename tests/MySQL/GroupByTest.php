<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\MySQL\Clauses\GroupByContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\GroupByElement;

/**
 * Class GroupByTest
 *
 * Test mysql group by clauses
 */
class GroupByTest extends MySQL
{
    /**
     * Test a single group by element
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\GroupByElement::__construct()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\GroupByElement::getField()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\GroupByElement::asString()
     *
     * @return void
     */
    public function testGroupBy()
    {
        $groupBy = new GroupByElement('languageId');

        $this->assertEquals('languageId', $groupBy->getField());
        $this->assertEquals('languageId', $groupBy->asString());
    }


    /**
     * Test a group by container
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\GroupByContainer::add()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\GroupByContainer::get()
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\GroupByContainer::has
     * @covers \OlajosCs\QueryBuilder\MySQL\Clauses\GroupByContainer::asString()
     *
     * @return void
     */
    public function testGroupByContainer()
    {
        $container = new GroupByContainer();

        $this->assertEquals(false, $container->has());
        $this->assertEquals([], $container->get());

        $groupBy1 = new GroupByElement('languageId');
        $groupBy2 = new GroupByElement('id');

        $container->add($groupBy1)->add($groupBy2);

        $this->assertEquals(true, $container->has());
        $this->assertEquals([$groupBy1, $groupBy2], $container->get());

        $string = ' GROUP BY languageId, id';
        $this->assertEquals($string, $container->asString());
    }


    /**
     * Test group by in select statement
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::groupBy()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::asString()
     *
     * @return void
     */
    public function testGroupByInSelect()
    {
        $connection = $this->getConnection();

        $query = $connection
            ->select('*')
            ->from('strings')
            ->groupBy('id');

        $string = 'SELECT * FROM strings GROUP BY id';

        $this->assertEquals($string, $query->asString());
    }
}
