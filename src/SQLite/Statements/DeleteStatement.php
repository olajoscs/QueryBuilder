<?php

namespace OlajosCs\QueryBuilder\SQLite\Statements;

use OlajosCs\QueryBuilder\Common\Statements\DeleteStatement as DeleteStatementCommon;
use OlajosCs\QueryBuilder\Contracts\RawExpression;
use OlajosCs\QueryBuilder\SQLite\Clauses\RawWhereElement;
use OlajosCs\QueryBuilder\SQLite\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\SQLite\Clauses\WhereElement;

/**
 * Class DeleteStatement
 *
 * Defines a delete statement
 */
class DeleteStatement extends DeleteStatementCommon
{
    /**
     * @inheritDoc
     */
    public function asString()
    {
        $query = sprintf(
            'DELETE FROM %s',
            $this->table
        );

        if ($this->whereContainer->has()) {
            $query .= $this->whereContainer->asString();
            $this->parameters += $this->whereContainer->getParameters();
        }

        return $query;
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
