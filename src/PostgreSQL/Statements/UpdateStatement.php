<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\UpdateStatement as UpdateStatementCommon;
use OlajosCs\QueryBuilder\Contracts\RawExpression;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\RawWhereElement;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\PostgreSQL\Clauses\WhereElement;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class UpdateStatement
 *
 * Defines an update statement
 */
class UpdateStatement extends UpdateStatementCommon
{
    use NameNormalizer;

    /**
     * @inheritDoc
     */
    public function asString()
    {
        $values = [];
        foreach ($this->names as $field => $name) {
            $values[] = $this->normalize($field) . ' = ' . $name;
        }

        $query = sprintf(
            'UPDATE %s SET %s',
            $this->normalize($this->table),
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
