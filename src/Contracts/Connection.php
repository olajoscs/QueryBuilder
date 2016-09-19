<?php

namespace OlajosCs\QueryBuilder\Contracts;

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
     * @param string[]|string $fields
     *
     * @return Statements\SelectStatement
     */
    public function select($fields = []);


    /**
     * @inheritdoc
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
     * @return object[]
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
     * @return object
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
     */
    public function getList($query, array $parameters = [], $field);


    /**
     * Return the result of the query as an array of stdClasses which has the key by the $keyField value
     *
     * @param string $query
     * @param array  $parameters
     * @param string $keyField
     *
     * @return object[]
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
     * @return array[]
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
}
