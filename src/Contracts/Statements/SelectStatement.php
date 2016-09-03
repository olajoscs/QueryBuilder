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
     * Returns the query as a string
     *
     * @return string
     */
    public function asString();
}
