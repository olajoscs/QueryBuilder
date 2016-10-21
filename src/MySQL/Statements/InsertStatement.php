<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\InsertStatement as InsertStatementCommon;


/**
 * Class InsertStatement
 *
 * MySQL specific Select statement
 */
class InsertStatement extends InsertStatementCommon
{
    /**
     * @inheritDoc
     */
    public function asString()
    {
        $query = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', array_keys($this->names)),
            implode(', ', $this->names)
        );

        return $query;
    }
}
