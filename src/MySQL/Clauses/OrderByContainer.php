<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByContainer as OrderByContainerInterface;

/**
 * Class OrderByContainer
 *
 * Contains all the order by clauses for a query
 */
class OrderByContainer extends Container implements OrderByContainerInterface
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
