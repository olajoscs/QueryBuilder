<?php

namespace OlajosCs\QueryBuilder;

use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\Exceptions\InvalidDriverException;
use OlajosCs\QueryBuilder\MySQL\Connection as MySqlConnection;
use OlajosCs\QueryBuilder\PostgreSQL\Connection as PostgreSqlConnection;
use OlajosCs\QueryBuilder\SQLite\Connection as SQLiteConnection;

/**
 * Class ConnectionFactory
 *
 * Factory object for creatin database specific connection objectss
 */
class ConnectionFactory
{
    /**
     * Create a new Connection based on the config
     *
     * @param PDO $pdo
     *
     * @return Connection
     * @throws InvalidDriverException
     */
    public function create(PDO $pdo)
    {
        switch ($pdo->getDatabaseType()) {
            case 'mysql':
                $connection = new MySqlConnection($pdo);
                break;
            case 'pgsql':
                $connection = new PostgreSqlConnection($pdo);
                break;
            case 'sqlite':
                $connection = new SQLiteConnection($pdo);
                break;
            default:
                throw new InvalidDriverException('Not implemented driver: ' . $pdo->getDatabaseType());
        }

        return $connection;
    }
}
