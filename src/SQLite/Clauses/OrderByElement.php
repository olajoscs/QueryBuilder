<?php

namespace OlajosCs\QueryBuilder\SQLite\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\OrderByElement as OrderByElementCommon;

/**
 * Class OrderByElement
 *
 * Defines an element in the order by clause
 */
class OrderByElement extends OrderByElementCommon
{
    /**
     * @inheritdoc
     */
    public function asString()
    {
        if ($this->nullsPosition === null) {
            $this->nullsPosition = $this->order === self::ORDER_ASC ? self::NULLS_LAST : self::NULLS_FIRST;
        }

        if (
            ($this->order === self::ORDER_DESC && $this->nullsPosition === self::NULLS_LAST) ||
            ($this->order === self::ORDER_ASC && $this->nullsPosition === self::NULLS_FIRST)
        ) {
            $this->field         = '-' . $this->field;
            $this->order         = self::ORDER_ASC ? self::ORDER_DESC : self::ORDER_ASC;
            $this->nullsPosition = self::NULLS_FIRST;
        }

        return sprintf('%s %s', $this->field, $this->order);
    }
}
