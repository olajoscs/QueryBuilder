<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\Contracts\Connection as ConnectionInterface;
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
class ConnectionTest extends MySQL
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

        $select = new SelectStatement($connection);
        $select->setFields('*');
        $this->assertEquals($connection->select(), $select);

        $update = new UpdateStatement($connection);
        $update->setTable('strings');
        $this->assertEquals($connection->update('strings'), $update);

        $delete = new DeleteStatement($connection);
        $this->assertEquals($connection->delete(), $delete);

        $insert = new InsertStatement();
        $this->assertEquals($connection->insert(), $insert);
    }
}
