<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\SelectStatement as SelectStatementCommon;
use OlajosCs\QueryBuilder\Contracts\RawExpression;
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
class SelectStatement extends SelectStatementCommon
{
    use NameNormalizer;


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


    /**
     * Return the imploded field names into the select statement
     *
     * @return string
     */
    protected function getImplodedFields()
    {
        return implode(
            ', ',
            array_map(
                function ($field) {
                    return $this->normalize($field);
                },
                $this->fields
            )
        );
    }


    /**
     * Return the normalized table name
     *
     * @return string
     */
    protected function getNormalizedTableName()
    {
        return $this->normalize($this->table);
    }
}
