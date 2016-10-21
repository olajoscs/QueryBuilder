<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\OrderByElement as OrderByElementCommon;
use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByElement as OrderByElementInterface;

/**
 * Class OrderByElement
 *
 * Defines an element in the order by clause
 */
class OrderByElement extends OrderByElementCommon implements OrderByElementInterface
{
    /**
     * @inheritdoc
     */
    public function asString()
    {
        if ($this->nullsPosition === self::NULLS_LAST) {
            $this->field         = '-' . $this->field;
            $this->order         = self::ORDER_ASC ? self::ORDER_DESC : self::ORDER_ASC;
            $this->nullsPosition = self::NULLS_FIRST;
        }

        return sprintf('%s %s', $this->field, $this->order);
    }
}
