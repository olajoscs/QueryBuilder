<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements\Common;

use OlajosCs\QueryBuilder\Contracts\Clauses\WhereContainer as WhereContainerInterface;
use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\Contracts\Statements\Common\WhereStatement as WhereStatementInterface;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement;
use OlajosCs\QueryBuilder\Operator;


/**
 * Class WhereStatement
 *
 * Parent of all the statements which can have where clauses
 */
abstract class WhereStatement extends Statement implements WhereStatementInterface
{
    /**
     * @var WhereContainerInterface
     */
    protected $whereContainer;

    /**
     * @var array The binding parameters for the query
     */
    protected $parameters = [];


    public function __construct(Connection $connection)
    {
        parent::__construct($connection);

        $this->whereContainer = new WhereContainer();
    }


    /**
     * @inheritdoc
     */
    public function where($field, $operator, $value)
    {
        $this->whereContainer->add(
            new WhereElement($field, $operator, $value, WhereElement::GLUE_AND)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereOr($field, $operator, $value)
    {
        $this->whereContainer->add(
            new WhereElement($field, $operator, $value, WhereElement::GLUE_OR)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereIn($field, array $values)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::IN, $values)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereNotIn($field, array $values)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::NOTIN, $values)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereBetween($field, $min, $max)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::BETWEEN, [$min, $max])
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereNull($field)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::IS_NULL, null)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereNotNull($field)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::IS_NOT_NULL, null)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereNullOr($field)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::IS_NULL, null, WhereElement::GLUE_OR)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereNotNullOr($field)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::IS_NOT_NULL, null, WhereElement::GLUE_OR)
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


    /**
     * @inheritDoc
     */
    public function asString()
    {
        $query = '';
        if ($this->whereContainer->has()) {
            $query = $this->whereContainer->asString();

            $this->parameters = array_merge(
                $this->parameters,
                $this->whereContainer->getParameters()
            );
        }

        return $query;
    }
}
