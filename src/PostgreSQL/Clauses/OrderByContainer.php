<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\OrderByContainer as OrderByContainerCommon;

/**
 * Class OrderByContainer
 *
 * Contains all the order by clauses for a query
 */
class OrderByContainer extends OrderByContainerCommon
{
    /**
     * @inheritdoc
     */
    public function asString()
    {
        $strings = array_map(
            function(OrderByElement $element) {
                return $element->asString();
            },
            $this->get()
        );

        return sprintf(' ORDER BY %s', implode(', ', $strings));
    }
}