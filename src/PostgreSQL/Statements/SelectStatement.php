<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\SelectStatement as SelectStatementCommon;
use OlajosCs\QueryBuilder\Contracts\RawExpression;
use OlajosCs\QueryBuilder\Contracts\Statements\SelectStatement as SelectStatementInterface;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\GroupByContainer;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\GroupByElement;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\JoinContainer;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\JoinElement;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\OrderByContainer;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\OrderByElement;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\RawWhereElement;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\WhereElement;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class SelectStatement
 *
 * PostgreSQL specific select statement
 */
class SelectStatement extends SelectStatementCommon implements SelectStatementInterface
{
    use NameNormalizer;

    /**
     * @inheritdoc
     */
    public function asString()
    {
        $this->parameters = [];

        $query = sprintf(
            'SELECT %s FROM %s',
            implode(
                ', ',
                array_map(
                    function($field) {
                        return $this->normalize($field);
                    },
                    $this->fields
                )
            ),
            $this->normalize($this->table)
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
