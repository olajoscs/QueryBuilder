<?php

namespace OlajosCs\QueryBuilder\Common\Statements;

use OlajosCs\QueryBuilder\Common\Statements\Common\WhereStatement;
use OlajosCs\QueryBuilder\Contracts\Statements\DeleteStatement as DeleteStatementInterface;


/**
 * Class DeleteStatement
 */
abstract class DeleteStatement extends WhereStatement implements DeleteStatementInterface
{
    /**
     * @inheritDoc
     */
    public function from($table)
    {
        $this->table = $table;

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function asString()
    {
        $query = sprintf(
            'DELETE FROM %s',
            $this->getNormalizedTableName()
        );

        if ($this->whereContainer->has()) {
            $query .= $this->whereContainer->asString();
            $this->parameters += $this->whereContainer->getParameters();
        }

        return $query;
    }


    /**
     * Return the table name normalized
     *
     * @return string
     */
    protected function getNormalizedTableName()
    {
        return $this->table;
    }
}