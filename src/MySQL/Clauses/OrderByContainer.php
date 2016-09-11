<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

/**
 * Class OrderByContainer
 *
 * Contains all the order by clauses for a query
 */
class OrderByContainer extends Container
{
    /**
     * @var OrderByElement[]
     */
    protected $list = [];


    /**
     * @inheritdoc
     */
    public function asString()
    {
        $strings = array_map(
            function (OrderByElement $element) {
                return $element->asString();
            },
            $this->get()
        );

        return sprintf(' ORDER BY %s', implode(', ', $strings));
    }

}
