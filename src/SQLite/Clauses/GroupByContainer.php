<?php

namespace OlajosCs\QueryBuilder\SQLite\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\GroupByContainer as GroupByContainerCommon;
use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByContainer as GroupByContainerInterface;

/**
 * Class GroupByElement
 *
 * Defines a group by element to the query
 */
class GroupByContainer extends GroupByContainerCommon implements GroupByContainerInterface
{
    /**
     * @inheritdoc
     */
    public function asString()
    {
        $strings = array_map(
            function(GroupByElement $element) {
                return $element->asString();
            },
            $this->get()
        );

        return sprintf(' GROUP BY %s', implode(', ', $strings));
    }
}
