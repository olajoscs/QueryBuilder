<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements;

use OlajosCs\QueryBuilder\Contracts\Statements\Common\WhereStatement;

/**
 * Interface DeleteStatement
 *
 * Defines a delete statement
 */
interface DeleteStatement extends WhereStatement
{
    /**
     * Set the table to query
     *
     * @param string $table
     *
     * @return DeleteStatement
     */
    public function from($table);
}
