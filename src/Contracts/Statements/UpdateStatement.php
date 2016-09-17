<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements;

use OlajosCs\QueryBuilder\Contracts\Statements\Common\WhereStatement;

/**
 * Interface UpdateStatement
 *
 * Defines an update statement
 */
interface UpdateStatement extends WhereStatement
{
    /**
     * Set the fields to update as an associative array.
     * Keys are the field names, values are the new values
     *
     * @param array $fields
     *
     * @return UpdateStatement
     */
    public function set(array $fields);


    /**
     * Set the table which is updated
     *
     * @param string $table
     *
     * @return UpdateStatement
     */
    public function setTable($table);


    /**
     * Execute the query and return the statement
     *
     * @return \PDOStatement
     */
    public function execute();

}