<?php

namespace OlajosCs\QueryBuilder\Contracts;

use OlajosCs\QueryBuilder\Contracts\Statements\UpdateStatement;
use OlajosCs\QueryBuilder\Exceptions\FieldNotFoundException;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;

/**
 * Interface Connection
 *
 * Defines a Connection based on PDO
 */
interface Connection
{
    /**
     * Return an empty select statement
     *
     * @param string[]|string|RawExpression $fields
     *
     * @return Statements\SelectStatement
     */
    public function select($fields = []);


    /**
     * Create an update statement
     *
     * @param string $table
     *
     * @return UpdateStatement
     */
    public function update($table);


    /**
     * Create an insert statement
     *
     * @param array $values The values to insert as an associative array
     *
     * @return Statements\InsertStatement
     */
    public function insert(array $values = []);


    /**
     * Create a delete statment
     *
     * @return Statements\DeleteStatement
     */
    public function delete();


    /**
     * Return the result of the query as array of stdClasses
     *
     * @param string $query
     * @param array  $parameters
     *
     * @return \stdClass[]
     */
    public function get($query, array $parameters = []);


    /**
     * Return the result of the query as array of explicit classes
     *
     * @param string $query
     * @param array  $parameters
     * @param string $class
     * @param array  $constructorParameters
     *
     * @return array
     */
    public function getAsClasses($query, array $parameters = [], $class, array $constructorParameters = []);


    /**
     * Return the first row from a query as an stdClass
     *
     * @param string $query
     * @param array  $parameters
     *
     * @return \stdClass
     * @throws RowNotFoundException
     * @throws MultipleRowFoundException
     */
    public function getOne($query, array $parameters = []);


    /**
     * Return the first row from a query as an explicit class
     *
     * @param string $query
     * @param array  $parameters
     * @param string $class
     * @param array  $constructorParameters
     *
     * @return mixed
     * @throws RowNotFoundException
     * @throws MultipleRowFoundException
     */
    public function getOneClass($query, array $parameters = [], $class, array $constructorParameters = []);


    /**
     * Return one field of the first row from a query
     *
     * @param string $query
     * @param array  $parameters
     * @param string $field
     *
     * @return string
     * @throws FieldNotFoundException
     * @throws RowNotFoundException
     * @throws MultipleRowFoundException
     */
    public function getOneField($query, array $parameters = [], $field);


    /**
     * Return an array of the given field
     *
     * @param string $query
     * @param array  $parameters
     * @param string $field
     *
     * @return array
     * @throws FieldNotFoundException
     */
    public function getList($query, array $parameters = [], $field);


    /**
     * Return the result of the query as an array of stdClasses which has the key by the $keyField value
     *
     * @param string $query
     * @param array  $parameters
     * @param string $keyField
     *
     * @return \stdClass[]
     * @throws FieldNotFoundException
     */
    public function getWithKey($query, array $parameters = [], $keyField);


    /**
     * Return the result of the query as an array of explicit classes which has the key by the $keyField value
     *
     * @param string $query
     * @param array  $parameters
     * @param string $class
     * @param array  $constructorParameters
     * @param string $keyField
     *
     * @return array
     * @throws FieldNotFoundException
     */
    public function getClassesWithKey($query, array $parameters = [], $class, array $constructorParameters = [], $keyField);


    /**
     * Execute the query and return the statement
     *
     * @param string $query
     * @param array  $parameters
     *
     * @return \PDOStatement
     */
    public function execute($query, array $parameters = []);


    /**
     * Return a new database specific RawExpression object with the expression in the parameter
     *
     * @param string $expression
     *
     * @return RawExpression
     */
    public function createRawExpression($expression);


    /**
     * Run the callable in a transaction. In case of failure changes are rollbacked.
     *
     * @param callable $callable A callable function with no parameters
     *
     * @return mixed The result of the callable
     * @throws \Exception
     */
    public function transaction(callable $callable);


    /**
     * Return the PDO instance
     *
     * @return \PDO
     */
    public function getPdo();
}
