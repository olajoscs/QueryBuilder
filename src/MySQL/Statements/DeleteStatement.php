<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\DeleteStatement as DeleteStatementCommon;
use OlajosCs\QueryBuilder\Common\Statements\DeleteStatement as DeleteStatementTrait;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer;

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
    protected function createWhereContainer()
    {
        return new WhereContainer();
	}


    /**
     * @inheritDoc
     */
    protected function createWhereElement($field, $operator, $value, $glue = WhereElement::GLUE_AND)
    {
        return new WhereContainer($field, $operator, $value, $glue);
    }


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
        }

        return $query;
    }
}
