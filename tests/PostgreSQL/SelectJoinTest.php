<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;

use OlajosCs\QueryBuilder\PostgreSQL\Clauses\JoinContainer;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\JoinElement;
use OlajosCs\QueryBuilder\Operator;

/**
 * Class JoinTest
 *
 * Tests Join clause
 */
class SelectJoinTest extends PostgreSQLTestCase
{
    /**
     * Tests join clause in a full select query
     *
     * @return void
     */
    public function testInnerJoin()
    {
        $connection = $this->getQueryBuilderConnection();

        $query = $connection
            ->select('id')
            ->from('strings')
            ->join('languages', 'id', Operator::EQ, 'languageId');

        $string = 'SELECT "id" FROM "strings" INNER JOIN "languages" ON "strings"."languageId" = "languages"."id"';

        $this->assertEquals($string, $query->asString());
    }


    /**
     * Test left join result
     *
     * @return void
     */
    public function testLeftJoin()
    {
        $connection = $this->getQueryBuilderConnection();

        $query = $connection
            ->select('id')
            ->from('strings')
            ->joinLeft('languages', 'id', Operator::EQ, 'languageId');

        $string = 'SELECT "id" FROM "strings" LEFT JOIN "languages" ON "strings"."languageId" = "languages"."id"';

        $this->assertEquals($string, $query->asString());
    }


    /**
     * Test right join result
     *
     * @return void
     */
    public function testRightJoin()
    {
        $connection = $this->getQueryBuilderConnection();

        $query = $connection
            ->select('id')
            ->from('strings')
            ->joinRight('languages', 'id', Operator::EQ, 'languageId');

        $string = 'SELECT "id" FROM "strings" RIGHT JOIN "languages" ON "strings"."languageId" = "languages"."id"';

        $this->assertEquals($string, $query->asString());
    }


    /**
     * Test an individual join caluse
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

        $string = ' INNER JOIN "language" ON "strings"."languageId" = "language"."id"';
        $this->assertEquals($string, $join->asString());
    }


    /**
     * Test an individual join container
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

        $string = ' INNER JOIN "language" ON "strings"."languageId" = "language"."id" LEFT JOIN "source" ON "strings"."sourceId" = "source"."id"';
        $this->assertEquals($string, $container->asString());
    }
}
