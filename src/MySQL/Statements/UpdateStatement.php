<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\UpdateStatement as UpdateStatementCommon;
use OlajosCs\QueryBuilder\Contracts\RawExpression;
use OlajosCs\QueryBuilder\MySQL\Clauses\RawWhereElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement;


/**
 * Class UpdateStatement
 *
 * Defines an update statement
 */
class UpdateStatement extends UpdateStatementCommon
{
    /**
     * @inheritDoc
     */
    public function asString()
    {
        $values = [];
        foreach ($this->names as $field => $name) {
            $values[] = $field . ' = ' . $name;
        }

        $query = sprintf(
            'UPDATE %s SET %s',
            $this->table,
            implode(', ', $values)
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
