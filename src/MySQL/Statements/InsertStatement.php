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
        // Gathering the array of the bracketed rows into the insert statement
        $values = array_map(
            function($values) {
                return '(' . implode(', ', $values) . ')';
            },
            $this->names
        );

        $query = sprintf(
            'INSERT INTO %s (%s) VALUES %s',
            $this->table,
            implode(', ', array_keys(reset($this->names))),
            implode(', ', $values)
        );

        return $query;
    }
}
