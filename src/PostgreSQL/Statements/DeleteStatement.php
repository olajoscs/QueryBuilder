<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\DeleteStatement as DeleteStatementCommon;
use OlajosCs\QueryBuilder\Contracts\RawExpression;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\RawWhereElement;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\WhereElement;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class DeleteStatement
 *
 * Defines a delete statement
 */
class DeleteStatement extends DeleteStatementCommon
{
    use NameNormalizer;


    /**
     * Return the table name normalized
     *
     * @return string
     */
    protected function getNormalizedTableName()
    {
        return $this->normalize($this->table);
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
