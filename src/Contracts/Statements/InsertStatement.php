<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements;

use OlajosCs\QueryBuilder\Contracts\Statements\Common\Statement;

/**
 * Interface InsertStatement
 *
 * Defines what an insert statement has to know
 */
interface InsertStatement extends Statement
{
    /**
     * Set the table where the insert is going
     *
     * @param string $table
     *
     * @return InsertStatement
     */
    public function into($table);


    /**
     * Set the values to insert as an associative array
     *
     * @param array $values
     *
     * @return InsertStatement
     */
    public function values(array $values);
}
