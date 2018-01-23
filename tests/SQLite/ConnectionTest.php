<?php

namespace OlajosCs\QueryBuilder\SQLite;

use OlajosCs\QueryBuilder\Contracts\Connection as ConnectionInterface;
use OlajosCs\QueryBuilder\SQLite\Statements\DeleteStatement;
use OlajosCs\QueryBuilder\SQLite\Statements\InsertStatement;
use OlajosCs\QueryBuilder\SQLite\Statements\SelectStatement;
use OlajosCs\QueryBuilder\SQLite\Statements\UpdateStatement;

/**
 * Class SQLiteTest
 *
 * Tests for the SQLite Connection Class
 */
class ConnectionTest extends SQLiteTestCase
{
    /**
     * Test Connection object
     *
     * @return void
     */
    public function testConnection()
    {
        $connection = $this->getQueryBuilderConnection();

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
