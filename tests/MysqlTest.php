<?php

namespace OlajosCs\QueryBuilder;

use OlajosCs\QueryBuilder\Contracts\Connection as ConnectionInterface;
use OlajosCs\QueryBuilder\MySQL\Connection;
use OlajosCs\QueryBuilder\MySQL\Statements\DeleteStatement;
use OlajosCs\QueryBuilder\MySQL\Statements\InsertStatement;
use OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement;
use OlajosCs\QueryBuilder\MySQL\Statements\UpdateStatement;

/**
 * Class MysqlTest
 *
 * Tests for the Mysql Connection Class
 * @covers \OlajosCs\QueryBuilder\MySQL\Connection
 */
class MysqlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Connection object
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Connection::select()
     * @covers \OlajosCs\QueryBuilder\MySQL\Connection::insert()
     * @covers \OlajosCs\QueryBuilder\MySQL\Connection::update()
     * @covers \OlajosCs\QueryBuilder\MySQL\Connection::delete()
     */
    public function testConnection()
    {
        $connection = $this->getConnection();

        $this->assertInstanceOf(ConnectionInterface::class, $connection);
        $this->assertInstanceOf(Connection::class, $connection);

        $select = new SelectStatement();
        $this->assertEquals($connection->select(), $select);

        $update = new UpdateStatement();
        $this->assertEquals($connection->update(), $update);

        $delete = new DeleteStatement();
        $this->assertEquals($connection->delete(), $delete);

        $insert = new InsertStatement();
        $this->assertEquals($connection->insert(), $insert);
    }


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


    /**
     * Return a connection based on the config file
     *
     * @return Connection
     */
    private function getConnection()
    {
        static $connection;
        if ($connection === null) {
            $config = require_once(__DIR__ . '/../config/config.php');

            $connection = new Connection(
                $config['type'] . ':host=' . $config['host'] . ';dbname=' . $config['database'] . ';charset=' . $config['charset'],
                $config['user'],
                $config['password'],
                $config['options']
            );
        }

        return $connection;
    }
}