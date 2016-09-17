<?php

namespace OlajosCs\QueryBuilder\Mysql\Statements\Common;

use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\Contracts\Statements\Common\Statement as StatementInterface;


/**
 * Class Statement
 *
 * Parent class of all the statements
 */
abstract class Statement implements StatementInterface
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
