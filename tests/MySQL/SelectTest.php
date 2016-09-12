<?php

namespace OlajosCs\QueryBuilder\MySQL;

/**
 * Class SelectTest
 *
 * Testing the select part of querybuilder
 */
class SelectTest extends MySQL
{
    /**
     * Testing selcect from and asString
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::__construct()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::setFields()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::from()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::asString()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::__toString()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::limit()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::offset()
     *
     * @return void
     */
    public function testSelect()
    {
        $connection = $this->getConnection();

        $string = 'SELECT * FROM strings';
        $query = $connection->select()->from('strings');

        $this->assertEquals($string, $query->asString());
        $this->assertEquals($string, (string)$query);

        $query = $connection->select('*')->from('strings');
        $this->assertEquals($string, $query->asString());
        $this->assertEquals($string, (string)$query);

        $query = $connection->select(['*'])->from('strings');
        $this->assertEquals($string, $query->asString());
        $this->assertEquals($string, (string)$query);

        $query = $connection->select()->from('strings')->setFields('*');
        $this->assertEquals($string, $query->asString());
        $this->assertEquals($string, (string)$query);

        $query = $connection->select()->from('strings')->limit(2)->offset(1);
        $string = 'SELECT * FROM strings LIMIT 2 OFFSET 1';
        $this->assertEquals($string, $query->asString());
        $this->assertEquals($string, (string)$query);
    }


    /**
     * Test if invalid limit is given, exception is thrown
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::limit()
     *
     * @return void
     */
    public function testInvalidLimit()
    {
        $connection = $this->getConnection();
        $this->expectException(\InvalidArgumentException::class);

        $query = $connection->select()->from('strings')->limit('hello');
    }


    /**
     * Test if invalid offset is given, exception is thrown
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::offset()
     *
     * @return void
     */
    public function testInvalidOffset()
    {
        $connection = $this->getConnection();
        $this->expectException(\InvalidArgumentException::class);

        $query = $connection->select()->from('strings')->offset('hello');
    }
}
