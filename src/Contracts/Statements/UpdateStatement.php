<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements;

use OlajosCs\QueryBuilder\Contracts\Connection;

/**
 * Interface UpdateStatement
 *
 * Defines an update statement
 */
interface UpdateStatement
{
    /**
     * UpdateStatement constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection);


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
     * Set a where condition
     *
     * @param string $field
     * @param string $operator One of the Operator constants
     * @param mixed  $value
     *
     * @return UpdateStatement
     */
    public function where($field, $operator, $value);


    /**
     * Set a where condition with or glue
     *
     * @param string $field
     * @param string $operator
     * @param mixed  $value
     *
     * @return UpdateStatement
     */
    public function whereOr($field, $operator, $value);


    /**
     * Set a where in condition
     *
     * @param string $field
     * @param array  $values
     *
     * @return UpdateStatement
     */
    public function whereIn($field, array $values);


    /**
     * Set a where not in condition
     *
     * @param string $field
     * @param array  $values
     *
     * @return UpdateStatement
     */
    public function whereNotIn($field, array $values);


    /**
     * Set a where between condition
     *
     * @param string $field
     * @param mixed  $min
     * @param mixed  $max
     *
     * @return UpdateStatement
     */
    public function whereBetween($field, $min, $max);


    /**
     * Execute the query and return the statement
     *
     * @return \PDOStatement
     */
    public function execute();


    /**
     * Returns the query as a string
     *
     * @return string
     */
    public function asString();

}