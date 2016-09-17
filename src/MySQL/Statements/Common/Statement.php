<?php

namespace OlajosCs\QueryBuilder\Mysql\Statements\Common;

use OlajosCs\QueryBuilder\Contracts\Connection;


/**
 * Class Statement
 *
 * Parent class of all the statements
 */
abstract class Statement
{
    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * @var string The name of the table
     */
    protected $table;


    /**
     * Statement constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}