<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

/**
 * Class GroupByElement
 *
 * Defines a group by element to the query
 */
class GroupByContainer extends Container
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