<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\GroupByElement as GroupByElementCommon;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class GroupByElement
 *
 * Defines a group by element to the query
 */
class GroupByElement extends GroupByElementCommon
{
    use NameNormalizer;

    /**
     * @inheritdoc
     */
    public function asString()
    {
        return $this->normalize($this->field);
    }
}
