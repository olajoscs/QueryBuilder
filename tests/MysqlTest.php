<?php

namespace OlajosCs\QueryBuilder;

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
     * @var Connection
     */
    private $connection;


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
        $connection = $this->connection();

        $this->assertInstanceOf(\OlajosCs\QueryBuilder\Contracts\Connection::class, $connection);
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
     * Return a connection based on the config file
     *
     * @return Connection
     */
    private function connection()
    {
        if ($this->connection === null) {
            $config = require_once(__DIR__ . '/../config/config.php');

            $this->connection = new Connection(
                $config['type'] . ':host=' . $config['host'] . ';dbname=' . $config['database'] . ';charset=' . $config['charset'],
                $config['user'],
                $config['password'],
                $config['options']
            );
        }

        return $this->connection;
    }
}