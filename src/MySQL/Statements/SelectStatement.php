<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\SelectStatement as SelectStatementCommon;
use OlajosCs\QueryBuilder\Contracts\RawExpression;
use OlajosCs\QueryBuilder\MySQL\Clauses\GroupByContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\GroupByElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\JoinContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\OrderByContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\OrderByElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\RawWhereElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement;

/**
 * Class SelectStatement
 *
 * MySQL specific select statement
 */
class SelectStatement extends SelectStatementCommon
{
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
