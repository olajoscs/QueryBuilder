<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements;

/**
 * Interface SelectStatement
 *
 * Defines a select statement
 */
interface SelectStatement
{
    /**
     * SelectStatement constructor.
     *
     * @param string[]|string $fields
     */
    public function __construct($fields = []);


    /**
     * Set the fields to get in the query
     *
     * @param string[]|string $fields
     *
     * @return SelectStatement
     */
    public function setFields($fields);


    /**
     * Set the table to query
     *
     * @param string $table
     *
     * @return SelectStatement
     */
    public function from($table);


    /**
     * Set a where condition
     *
     * @param string $field
     * @param string $operator One of the Operator constants
     * @param mixed  $value
     *
     * @return SelectStatement
     */
    public function where($field, $operator, $value);


    /**
     * Set a where condition with or glue
     *
     * @param $field
     * @param $operator
     * @param $value
     *
     * @return SelectStatement
     */
    public function whereOr($field, $operator, $value);


    /**
     * Returns the query as a string
     *
     * @return string
     */
    public function asString();
}
