<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\WhereElement as WhereElementCommon;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class WhereElement
 *
 * Represents a where statement
 */
class WhereElement extends WhereElementCommon
{
    use NameNormalizer;


    /**
     * Return the normalized field name
     *
     * @return string
     */
    protected function getNormalizedField()
    {
        return $this->normalize($this->getField());
    }
}
