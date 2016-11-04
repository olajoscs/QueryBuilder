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
        $query = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->normalize($this->table),
            implode(
                ', ',
                array_map(
                    function($value) {
                        return $this->normalize($value);
                    },
                    array_keys($this->names)
                )
            ),
            implode(', ', $this->names)
        );

        return $query;
    }
}
