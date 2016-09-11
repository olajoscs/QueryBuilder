<?php

namespace OlajosCs\QueryBuilder\Contracts\Clauses;

/**
 * Interface GroupByElement
 *
 * Defines what a group by element has to know
 */
interface GroupByElement extends Element
{
    /**
     * Return the field name to group by
     *
     * @return string
     */
    public function getField();
}