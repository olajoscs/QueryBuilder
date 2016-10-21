<?php

namespace OlajosCs\QueryBuilder\Common\Statements\Common;

use OlajosCs\QueryBuilder\Contracts\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\Contracts\Clauses\WhereElement;
use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\Contracts\Statements\Common\WhereStatement as WhereStatementInterface;
use OlajosCs\QueryBuilder\Operator;


/**
 * Class WhereStatement
 *
 * Database independent WhereStatement
 */
abstract class WhereStatement extends Statement implements WhereStatementInterface
{
    /**
     * @var WhereContainer
     */
    protected $whereContainer;

    /**
     * @var array The binding parameters for the query
     */
    protected $parameters = [];


    /**
     * Create and return and empty database specific WhereContainer object
     *
     * @return WhereContainer
     */
    abstract protected function createWhereContainer();


    /**
     * Create and return a database specific WhereElement object
     *
     * @param string $field
     * @param string $operator
     * @param mixed  $value
     * @param string $glue
     *
     * @return WhereElement
     */
    abstract protected function createWhereElement($field, $operator, $value, $glue = WhereElement::GLUE_AND);


    /**
     * Create a new WhereStatement object
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);

        $this->whereContainer = $this->createWhereContainer();
    }


    /**
     * @inheritdoc
     */
    public function where($field, $operator, $value)
    {
        $this->whereContainer->add(
            $this->createWhereElement($field, $operator, $value, WhereElement::GLUE_AND)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereOr($field, $operator, $value)
    {
        $this->whereContainer->add(
            $this->createWhereElement($field, $operator, $value, WhereElement::GLUE_OR)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereIn($field, array $values)
    {
        $this->whereContainer->add(
            $this->createWhereElement($field, Operator::IN, $values)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereNotIn($field, array $values)
    {
        $this->whereContainer->add(
            $this->createWhereElement($field, Operator::NOTIN, $values)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereBetween($field, $min, $max)
    {
        $this->whereContainer->add(
            $this->createWhereElement($field, Operator::BETWEEN, [$min, $max])
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereNull($field)
    {
        $this->whereContainer->add(
            $this->createWhereElement($field, Operator::IS_NULL, null)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereNotNull($field)
    {
        $this->whereContainer->add(
            $this->createWhereElement($field, Operator::IS_NOT_NULL, null)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereNullOr($field)
    {
        $this->whereContainer->add(
            $this->createWhereElement($field, Operator::IS_NULL, null, WhereElement::GLUE_OR)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereNotNullOr($field)
    {
        $this->whereContainer->add(
            $this->createWhereElement($field, Operator::IS_NOT_NULL, null, WhereElement::GLUE_OR)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->connection->execute($this->asString(), $this->parameters);
    }
}