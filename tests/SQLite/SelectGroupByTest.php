<?php

namespace OlajosCs\QueryBuilder\SQLite;

use OlajosCs\QueryBuilder\SQLite\Clauses\GroupByContainer;
use OlajosCs\QueryBuilder\SQLite\Clauses\GroupByElement;

/**
 * Class GroupByTest
 *
 * Test SQLite group by clauses
 */
class SelectGroupByTest extends SQLiteTestCase
{
    /**
     * Test a single group by element
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
     * @return void
     */
    public function testGroupByInSelect()
    {
        $connection = $this->getQueryBuilderConnection();

        $query = $connection
            ->select('*')
            ->from('strings')
            ->groupBy('id');

        $string = 'SELECT * FROM strings GROUP BY id';

        $this->assertEquals($string, $query->asString());
    }
}
