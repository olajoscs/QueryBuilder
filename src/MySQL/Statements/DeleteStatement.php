<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Contracts\Statements\DeleteStatement as DeleteStatementInterface;
use OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement;

/**
 * Class DeleteStatement
 *
 * Defines a delete statement
 */
class DeleteStatement extends WhereStatement implements DeleteStatementInterface
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
            $this->table
        );

        $query .= parent::asString();

        return $query;
    }

}