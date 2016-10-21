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
 */
class ConnectionTest extends MySQL
{
    /**
     * Test Connection object
     *




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

        $insert = new InsertStatement($connection);
        $this->assertEquals($connection->insert(), $insert);
    }
}
