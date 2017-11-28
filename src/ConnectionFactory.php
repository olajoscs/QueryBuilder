<?php

namespace OlajosCs\QueryBuilder;

use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\Exceptions\InvalidDriverException;

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
                $connection = new Mysql\Connection($pdo);
                break;
            case 'pgsql':
                $connection = new PostgreSQL\Connection($pdo);
                break;
            default:
                throw new InvalidDriverException('Not implemented driver: ' . $pdo->getDatabaseType());
        }

        return $connection;
    }
}
