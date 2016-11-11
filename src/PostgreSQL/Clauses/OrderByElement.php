<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\OrderByElement as OrderByElementCommon;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class OrderByElement
 *
 * Defines an element in the order by clause
 */
class OrderByElement extends OrderByElementCommon
{
    use NameNormalizer;

    /**
     * @inheritdoc
     */
    public function asString()
    {
        $string = sprintf(
            '%s %s',
            $this->normalize($this->field),
            $this->order
        );

        if ($this->nullsPosition !== null) {
            $string .= $this->nullsPosition === self::NULLS_FIRST ? ' nulls first' : ' nulls last';
        }

        return $string;
    }
}
