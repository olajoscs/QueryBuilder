<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\MySQL\Clauses\OrderByContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\OrderByElement;

/**
 * Class OrderByText
 *
 * Testing the order by clauses
 */
class SelectOrderByText extends MySQL
{
    /**
     * Test a single order by cluase
     *
     * @return void
     */
    public function testOrderBy()
    {
        $orderBy = new OrderByElement('strings');
        $this->assertEquals('strings', $orderBy->getField());
        $this->assertEquals(OrderByElement::ORDER_ASC, $orderBy->getOrder());
        $this->assertEquals(null, $orderBy->getNullsPosition());
        $this->assertEquals('strings ASC', $orderBy->asString());

        $orderBy = new OrderByElement('id', OrderByElement::ORDER_DESC, OrderByElement::NULLS_LAST);
        $this->assertEquals('id', $orderBy->getField());
        $this->assertEquals(OrderByElement::ORDER_DESC, $orderBy->getOrder());
        $this->assertEquals(OrderByElement::NULLS_LAST, $orderBy->getNullsPosition());
        $this->assertEquals('-id DESC', $orderBy->asString());
    }


    /**
     * Test an order by container with order by clauses
     *
     * @return void
     */
    public function testOrderByContainer()
    {
        $container = new OrderByContainer();

        $this->assertEquals(false, $container->has());
        $this->assertEquals([], $container->get());

        $orderBy1 = new OrderByElement('strings');
        $orderBy2 = new OrderByElement('id', OrderByElement::ORDER_DESC, OrderByElement::NULLS_LAST);

        $container
            ->add($orderBy1)
            ->add($orderBy2);

        $this->assertEquals(true, $container->has());
        $this->assertEquals([$orderBy1, $orderBy2], $container->get());

        $string = ' ORDER BY strings ASC, -id DESC';
        $this->assertEquals($string, $container->asString());
    }


    /**
     * Test the order by clause of the select statement
     *
     * @return void
     */
    public function testOrderByInSelect()
    {
        $connection = $this->getConnection();

        $query = $connection
            ->select('*')
            ->from('strings')
            ->orderBy('id', OrderByElement::ORDER_DESC);

        $string = 'SELECT * FROM strings ORDER BY id DESC';

        $this->assertEquals($string, $query->asString());
    }


    /**
     * Test when parameter is nok then exception is thrown
     *
     * @return void
     */
    public function testInvalidNullsPosition()
    {
        $this->expectException(\InvalidArgumentException::class);
        $connection = $this->getConnection();

        $connection
            ->select('id')
            ->from('strings')
            ->orderBy('id', OrderByElement::ORDER_ASC, 'asdf');
    }


    /**
     * Test when parameter is nok then exception is thrown
     *
     * @return void
     */
    public function testInvalidOrder()
    {
        $this->expectException(\InvalidArgumentException::class);
        $connection = $this->getConnection();

        $connection
            ->select('id')
            ->from('strings')
            ->orderBy('id', 'dasc');
    }
}
