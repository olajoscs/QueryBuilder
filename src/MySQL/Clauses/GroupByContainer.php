<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByContainer as GroupByContainerInterface;

/**
 * Class GroupByElement
 *
 * Defines a group by element to the query
 */
class GroupByContainer extends Container implements GroupByContainerInterface
{
    /**
     * @var GroupByElement[]
     */
    protected $list = [];


    /**
     * @inheritdoc
     */
    public function asString()
    {
        $strings = array_map(
            function (GroupByElement $element) {
                return $element->asString();
            },
            $this->get()
        );

        return sprintf(' GROUP BY %s', implode(', ', $strings));
    }
}
