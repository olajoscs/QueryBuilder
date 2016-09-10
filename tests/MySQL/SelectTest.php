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
    }
}
