<?php

namespace OlajosCs\QueryBuilder\SQLite;

use OlajosCs\QueryBuilder\Common\Connection as ConnectionCommon;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;
use OlajosCs\QueryBuilder\SQLite\Statements;

/**
 * Class Connection
 *
 * Defines a SQLite Connection based on PDO
 */
class Connection extends ConnectionCommon
{
    /**
     * @inheritDoc
     */
    protected function createSelectStatement()
    {
        return new Statements\SelectStatement($this);
    }


    /**
     * @inheritDoc
     */
    protected function createDeleteStatement()
    {
        return new Statements\DeleteStatement($this);
    }


    /**
     * @inheritDoc
     */
    protected function createUpdateStatement()
    {
        return new Statements\UpdateStatement($this);
    }


    /**
     * @inheritDoc
     */
    protected function createInsertStatement()
    {
        return new Statements\InsertStatement($this);
    }


    /**
     * @inheritDoc
     */
    public function createRawExpression($expression)
    {
        return new RawExpression($expression);
    }


    /**
     * @inheritdoc
     */
    public function getOne($query, array $parameters = [])
    {
        $statement = $this->readOne($query, $parameters);
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);
        $this->checkResultCount($result, $query);

        return reset($result);
    }


    /**
     * @inheritdoc
     */
    public function getOneClass($query, array $parameters = [], $class, array $constructorParameters = [])
    {
        $statement = $this->readOne($query, $parameters);
        $statement->setFetchMode(\PDO::FETCH_CLASS, $class, $constructorParameters);
        $result = $statement->fetchAll();

        $this->checkResultCount($result, $query);

        return reset($result);
    }


    /**
     * @inheritdoc
     */
    protected function readOne($query, $parameters)
    {
        $statement = $this->execute($query, $parameters);

        return $statement;
    }


    /**
     * Checks the result against the proper row number
     *
     * @param array  $result
     * @param string $query
     *
     * @return void
     *
     * @throws MultipleRowFoundException
     * @throws RowNotFoundException
     */
    private function checkResultCount(array $result, $query)
    {
        if (count($result) === 0) {
            throw new RowNotFoundException('Row not found for query: ' . $query);
        }

        if (count($result) > 1) {
            throw new MultipleRowFoundException('Multiple row found for query: ' . $query);
        }
    }
}
