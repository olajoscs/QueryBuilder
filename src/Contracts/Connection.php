<?php

namespace OlajosCs\QueryBuilder\Contracts;

use OlajosCs\QueryBuilder\Contracts\Statements;

/**
 * Interface Connection
 *
 * Defines a Connection based on PDO
 */
interface Connection
{
    /**
     * Create a select statement
     *
     * @return Statements\SelectStatement
     */
    public function select();


    /**
     * Create an update statement
     *
     * @return Statements\UpdateStatement
     */
    public function update();


    /**
     * Create an insert statement
     *
     * @return Statements\InsertStatement
     */
    public function insert();


    /**
     * Create a delete statment
     *
     * @return Statements\DeleteStatement
     */
    public function delete();

}
