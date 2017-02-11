<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Statements;

use OlajosCs\QueryBuilder\Common\Statements\InsertStatement as InsertStatementCommon;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class InsertStatement
 *
 * PostgreSQL specific Select statement
 */
class InsertStatement extends InsertStatementCommon
{
    use NameNormalizer;

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
            $this->normalize($this->table),
            implode(
                ', ',
                array_map(
                    function($value) {
                        return $this->normalize($value);
                    },
                    array_keys(reset($this->names))
                )
            ),
            implode(', ', $values)
        );

        return $query;
    }
}
