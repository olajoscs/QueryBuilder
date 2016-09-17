<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements;

use OlajosCs\QueryBuilder\Contracts\Statements\Common\WhereStatement;
use OlajosCs\QueryBuilder\Exceptions\FieldNotFoundException;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;

/**
 * Interface SelectStatement
 *
 * Defines a select statement
 */
interface SelectStatement extends WhereStatement
{
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
     * Return the result of the query as array of stdClasses
     *
     * @return object[]
     */
    public function get();


    /**
     * Return the result of the query as array of explicit classes
     *
     * @param string $class
     * @param array  $constructorParameters
     *
     * @return array
     */
    public function getAsClasses($class, array $constructorParameters = []);


    /**
     * Return the first row from a query as an stdClass
     *
     * @return object
     * @throws RowNotFoundException
     * @throws MultipleRowFoundException
     */
    public function getOne();


    /**
     * Return the first row from a query as an explicit class
     *
     * @param string $class
     * @param array  $constructorParameters
     *
     * @return mixed
     * @throws RowNotFoundException
     * @throws MultipleRowFoundException
     */
    public function getOneClass($class, array $constructorParameters = []);


    /**
     * Return one field of the first row from a query
     *
     * @param string $field
     *
     * @return string
     * @throws FieldNotFoundException
     */
    public function getOneField($field = null);


    /**
     * Return an array of the given field
     *
     * @param string $field
     *
     * @return array
     */
    public function getList($field = null);


    /**
     * Return the result of the query as an array of stdClasses which has the key by the $keyField value
     *
     * @param string $keyField
     *
     * @return object[]
     */
    public function getWithKey($keyField);


    /**
     * Return the result of the query as an array of explicit classes which has the key by the $keyField value
     *
     * @param string $class
     * @param array  $constructorParameters
     * @param string $keyField
     *
     * @return array[]
     */
    public function getClassesWithKey($class, array $constructorParameters = [], $keyField);
}
