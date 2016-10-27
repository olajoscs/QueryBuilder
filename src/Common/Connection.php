<?php

namespace OlajosCs\QueryBuilder\Common;

use OlajosCs\QueryBuilder\Common\Statements\InsertStatement;
use OlajosCs\QueryBuilder\Contracts\Connection as ConnectionInterface;
use OlajosCs\QueryBuilder\Contracts\Statements\DeleteStatement;
use OlajosCs\QueryBuilder\Contracts\Statements\SelectStatement;
use OlajosCs\QueryBuilder\Contracts\Statements\UpdateStatement;
use OlajosCs\QueryBuilder\Exceptions\FieldNotFoundException;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;

/**
 * Class Connection
 *
 * Database independent behavior of the connection object
 */
abstract class Connection extends \PDO implements ConnectionInterface
{
    /**
     * Return a new empty select statement
     *
     * @return SelectStatement
     */
    abstract protected function createSelectStatement();


    /**
     * Return a new empty delete statement
     *
     * @return DeleteStatement
     */
    abstract protected function createDeleteStatement();


    /**
     * Return a new empty update statement
     *
     * @return UpdateStatement
     */
    abstract protected function createUpdateStatement();


    /**
     * Return a new empty insert statement
     *
     * @return InsertStatement
     */
    abstract protected function createInsertStatement();


    /**
     * @inheritdoc
     */
    public function select($fields = [])
    {
        return $this->createSelectStatement()->setFields($fields);
    }


    /**
     * @inheritdoc
     */
    public function update($table)
    {
        return $this->createUpdateStatement()->setTable($table);
    }


    /**
     * @inheritdoc
     */
    public function insert(array $values = [])
    {
        $statement = $this->createInsertStatement();
        if (!empty($values)) {
            $statement->values($values);
        }

        return $statement;
    }


    /**
     * @inheritdoc
     */
    public function delete()
    {
        return $this->createDeleteStatement();
    }


    /**
     * @inheritdoc
     */
    public function get($query, array $parameters = [])
    {
        $statement = $this->execute($query, $parameters);

        return $statement->fetchAll(static::FETCH_OBJ);
    }


    /**
     * @inheritdoc
     */
    public function getAsClasses($query, array $parameters = [], $class, array $constructorParameters = [])
    {
        $statement = $this->execute($query, $parameters);

        return $statement->fetchAll(static::FETCH_CLASS, $class, $constructorParameters);
    }


    /**
     * @inheritdoc
     */
    public function getOne($query, array $parameters = [])
    {
        $statement = $this->readOne($query, $parameters);

        return $statement->fetch(static::FETCH_OBJ);
    }


    /**
     * @inheritdoc
     */
    public function getOneClass($query, array $parameters = [], $class, array $constructorParameters = [])
    {
        $statement = $this->readOne($query, $parameters);

        $statement->setFetchMode(static::FETCH_CLASS, $class);

        return $statement->fetch();
    }


    /**
     * @inheritdoc
     */
    public function getOneField($query, array $parameters = [], $field)
    {
        $result = $this->getOne($query, $parameters);

        if (!isset($result->$field)) {
            throw new FieldNotFoundException($field . ' field not found in result of the query: ' . $query);
        }

        return $result->$field;
    }


    /**
     * @inheritdoc
     */
    public function getList($query, array $parameters = [], $field)
    {
        $rows = $this->get($query, $parameters);

        $first = reset($rows);

        if (!isset($first->$field)) {
            throw new FieldNotFoundException($field . ' field not found in result of the query: ' . $query);
        }

        $result = [];
        foreach ($rows as $row) {
            $result[] = $row->$field;
        }

        return $result;
    }


    /**
     * @inheritdoc
     */
    public function getWithKey($query, array $parameters = [], $keyField)
    {
        $rows = $this->get($query, $parameters);

        return $this->processWithKey($rows, $keyField);
    }


    /**
     * @inheritdoc
     */
    public function getClassesWithKey($query, array $parameters = [], $class, array $constructorParameters = [], $keyField)
    {
        $rows = $this->getAsClasses($query, $parameters, $class, $constructorParameters);

        return $this->processWithKey($rows, $keyField);
    }


    /**
     * @inheritdoc
     */
    public function execute($query, array $parameters = [])
    {
        $statement = $this->prepare($query);

        if (!empty($parameters)) {
            foreach ($parameters as $key => $value) {
                $parameters[':' . $key] = $value;
                unset($parameters[$key]);
            }

            $statement = $this->bindParameters($statement, $parameters);
        }

        $statement->execute();

        return $statement;
    }


    /**
     * Bind the parameters to the statement
     *
     * @param \PDOStatement $statement
     * @param array         $parameters
     *
     * @return \PDOStatement
     */
    protected function bindParameters(\PDOStatement $statement, array $parameters)
    {
        foreach ($parameters as $key => $value) {
            switch (true) {
                case is_int($value):
                    $type = static::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = static::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = static::PARAM_NULL;
                    break;
                case $value instanceof \DateTimeInterface:
                    $type  = static::PARAM_STR;
                    $value = $value->format('Y-m-d H:i:s.u');
                    break;
                default:
                    $type = static::PARAM_STR;
            }

            $statement->bindValue($key, $value, $type);
        }

        return $statement;
    }


    /**
     * Return the statement checked that the result contains only 1 row
     *
     * @param string $query
     * @param array  $parameters
     *
     * @return \PDOStatement
     * @throws MultipleRowFoundException
     * @throws RowNotFoundException
     */
    private function readOne($query, $parameters)
    {
        $statement = $this->execute($query, $parameters);

        $rowCount = $statement->rowCount();
        if ($rowCount > 1) {
            throw new MultipleRowFoundException('Multiple row found for query: ' . $query);
        }

        if ($rowCount === 0) {
            throw new RowNotFoundException('Row not found for query: ' . $query);
        }

        return $statement;
    }


    /**
     * Process the queried rows into an array which has the keyField keys
     *
     * @param array  $rows
     * @param string $keyField
     *
     * @return array
     * @throws FieldNotFoundException
     */
    private function processWithKey(array $rows, $keyField)
    {
        $first = reset($rows);

        if (!isset($first->$keyField)) {
            throw new FieldNotFoundException($keyField . ' field not found in result of the query');
        }

        $result = [];
        foreach ($rows as $row) {
            $result[$row->$keyField] = $row;
        }

        return $result;
    }
}