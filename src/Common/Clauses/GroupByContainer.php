<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByContainer as GroupByContainerInterface;

/**
 * Class GroupByContainer
 *
 * Database independent GroupByContainer
 * Contains only the logic to build the model
 */
abstract class GroupByContainer extends Container implements GroupByContainerInterface
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
            function(GroupByElement $element) {
                return $element->asString();
            },
            $this->get()
        );

        return sprintf(' GROUP BY %s', implode(', ', $strings));
    }
}