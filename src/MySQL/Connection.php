<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\MySQL\Statements;

/**
 * Class Connection
 *
 * Defines a Mysql Connection based on PDO
 */
class Connection extends \PDO implements \OlajosCs\QueryBuilder\Contracts\Connection
{
    /**
     * Return an empty select statement
     *
     * @param string[]|string $fields
     *
     * @return Statements\SelectStatement
     */
    public function select($fields = [])
    {
        return new Statements\SelectStatement($fields);
    }


    /**
     * Return an empty update statement
     *
     * @return Statements\UpdateStatement
     */
    public function update()
    {
        return new Statements\UpdateStatement();
    }


    /**
     * Return an empty insert statement
     *
     * @return Statements\InsertStatement
     */
    public function insert()
    {
        return new Statements\InsertStatement();
    }


    /**
     * Return an empty delete statement
     *
     * @return Statements\DeleteStatement
     */
    public function delete()
    {
        return new Statements\DeleteStatement();
    }
}
