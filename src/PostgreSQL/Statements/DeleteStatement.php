<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\DeleteStatement as DeleteStatementCommon;
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
     * @inheritDoc
     */
    public function asString()
    {
        $query = sprintf(
            'DELETE FROM %s',
            $this->normalize($this->table)
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
}
