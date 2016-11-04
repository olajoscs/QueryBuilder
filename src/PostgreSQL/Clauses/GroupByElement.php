<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\GroupByElement as GroupByElementCommon;
use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByElement as GroupByElementInterface;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class GroupByElement
 *
 * Defines a group by element to the query
 */
class GroupByElement extends GroupByElementCommon implements GroupByElementInterface
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
