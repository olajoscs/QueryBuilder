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
     * @param string $field
     * @param string $operator
     * @param mixed  $value
     *
     * @return SelectStatement
     */
    public function whereOr($field, $operator, $value);


    /**
     * Set a where in condition
     *
     * @param string $field
     * @param array  $values
     *
     * @return SelectStatement
     */
    public function whereIn($field, array $values);


    /**
     * Set a where not in condition
     *
     * @param string $field
     * @param array  $values
     *
     * @return SelectStatement
     */
    public function whereNotIn($field, array $values);


    /**
     * Set a where between condition
     *
     * @param string $field
     * @param mixed  $min
     * @param mixed  $max
     *
     * @return SelectStatement
     */
    public function whereBetween($field, $min, $max);


    /**
     * Join an other table to the query
     *
     * @param string $tableRight The table to join
     * @param string $fieldRight The field in the right table to join
     * @param string $operator   The operator
     * @param string $fieldLeft  The field in the left table
     * @param string $tableLeft  The left table name
     *
     * @return SelectStatement
     */
    public function join($tableRight, $fieldRight, $operator, $fieldLeft, $tableLeft = null);


    /**
     * Create an order by clause to the container
     *
     * @param string $field         Name of the field to order by
     * @param string $order         Type of the order (one of the OrderByElement::ORDER_ constants)
     * @param string $nullsPosition Position of the null values (one of the OrderByElement::NULLS_ constans)
     *
     * @return SelectStatement
     */
    public function orderBy($field, $order = null, $nullsPosition = null);


    /**
     * Create a group by clause to the container
     *
     * @param string $field
     *
     * @return SelectStatement
     */
    public function groupBy($field);


    /**
     * Set the limit for the query
     *
     * @param int $limit
     *
     * @return SelectStatement
     */
    public function limit($limit);


    /**
     * Set the offset for the query
     *
     * @param int $offset
     *
     * @return SelectStatement
     */
    public function offset($offset);


    /**
     * Returns the query as a string
     *
     * @return string
     */
    public function asString();
}
