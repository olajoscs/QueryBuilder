<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\GroupByElement as GroupByElementCommon;

/**
 * Class GroupByElement
 *
 * Defines a group by element to the query
 */
class GroupByElement extends GroupByElementCommon
{

    /**
     * @inheritdoc
     */
    public function asString()
    {
        return $this->field;
    }
}
