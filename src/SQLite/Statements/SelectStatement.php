<?php

namespace OlajosCs\QueryBuilder\SQLite\Statements;

use OlajosCs\QueryBuilder\Common\Statements\SelectStatement as SelectStatementCommon;
use OlajosCs\QueryBuilder\Contracts\RawExpression;
use OlajosCs\QueryBuilder\SQLite\Clauses\GroupByContainer;
use OlajosCs\QueryBuilder\SQLite\Clauses\GroupByElement;
use OlajosCs\QueryBuilder\SQLite\Clauses\JoinContainer;
use OlajosCs\QueryBuilder\SQLite\Clauses\JoinElement;
use OlajosCs\QueryBuilder\SQLite\Clauses\OrderByContainer;
use OlajosCs\QueryBuilder\SQLite\Clauses\OrderByElement;
use OlajosCs\QueryBuilder\SQLite\Clauses\RawWhereElement;
use OlajosCs\QueryBuilder\SQLite\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\SQLite\Clauses\WhereElement;

/**
 * Class SelectStatement
 *
 * SQLite specific select statement
 */
class SelectStatement extends SelectStatementCommon
{
    /**
     * @inheritdoc
     */
    public function asString()
    {
        $this->parameters = [];

        $query = sprintf(
            'SELECT %s FROM %s',
            implode(', ', $this->fields),
            $this->table
        );

        if ($this->joinContainer->has()) {
            $query .= $this->joinContainer->asString();
        }

        if ($this->whereContainer->has()) {
            $query .= $this->whereContainer->asString();
            $this->parameters += $this->whereContainer->getParameters();
        }

        if ($this->orderByContainer->has()) {
            $query .= $this->orderByContainer->asString();
        }

        if ($this->groupByContainer->has()) {
            $query .= $this->groupByContainer->asString();
        }

        if ($this->limit !== null) {
            $query .= sprintf(' LIMIT %s', $this->limit);
        }

        if ($this->offset !== null) {
            $query .= sprintf(' OFFSET %s', $this->offset);
        }

        return $query;
    }


    /**
     * @inheritDoc
     */
    protected function createJoinContainer()
    {
        return new JoinContainer();
    }


    /**
     * @inheritDoc
     */
    protected function createGroupByContainer()
    {
        return new GroupByContainer();
    }


    /**
     * @inheritDoc
     */
    protected function createOrderByContainer()
    {
        return new OrderByContainer();
    }


    /**
     * @inheritDoc
     */
    protected function createJoinElement($tableLeft, $fieldLeft, $operator, $tableRight, $fieldRight, $type)
    {
        return new JoinElement($tableLeft, $fieldLeft, $operator, $tableRight, $fieldRight, $type);
    }


    /**
     * @inheritDoc
     */
    protected function createOrderByElement($field, $order = null, $nullsPosition = null)
    {
        return new OrderByElement($field, $order, $nullsPosition);
    }


    /**
     * @inheritDoc
     */
    protected function createGroupByElement($field)
    {
        return new GroupByElement($field);
    }


    /**
     * @inheritDoc
     */
    protected function createWhereContainer()
    {
        return new WhereContainer();
    }


    /**
     * @inheritDoc
     */
    protected function createWhereElement($field, $operator, $value, $glue = WhereElement::GLUE_AND)
    {
        return new WhereElement($this->whereContainer, $field, $operator, $value, $glue);
    }


    /**
     * @inheritDoc
     */
    protected function createRawWhereElement(RawExpression $expression, array $bindings = [])
    {
        return new RawWhereElement($this->whereContainer, $expression, $bindings);
    }
}
