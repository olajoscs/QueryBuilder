<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\GroupByElement as GroupByElementCommon;
use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByElement as GroupByElementInterface;

/**
 * Class GroupByElement
 *
 * Defines a group by element to the query
 */
class GroupByElement extends GroupByElementCommon implements GroupByElementInterface
{

    /**
     * @inheritdoc
     */
    public function asString()
    {
        return $this->field;
    }
}
