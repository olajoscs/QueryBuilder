<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements\Common;

use OlajosCs\QueryBuilder\Contracts\Connection;


/**
 * Interface Statement
 *
 * Defines what all the statements have to know
 */
interface Statement
{
    /**
     * SelectStatement constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection);


    /**
     * Returns the query as a string
     *
     * @return string
     */
    public function asString();


    /**
     * Execute the query and return the statement
     *
     * @return \PDOStatement
     */
    public function execute();
}
