<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;

use OlajosCs\QueryBuilder\Contracts\Connection as ConnectionInterface;
use OlajosCs\QueryBuilder\PostgreSQL\Statements\DeleteStatement;
use OlajosCs\QueryBuilder\PostgreSQL\Statements\InsertStatement;
use OlajosCs\QueryBuilder\PostgreSQL\Statements\SelectStatement;
use OlajosCs\QueryBuilder\PostgreSQL\Statements\UpdateStatement;

/**
 * Class MysqlTest
 *
 * Tests for the Mysql Connection Class
 */
class ConnectionTest extends PostgreSQL
{
    /**
     * Test Connection object
     *
     * @return void
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
