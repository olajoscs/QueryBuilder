<?php

namespace OlajosCs\QueryBuilder\Contracts\Clauses;

/**
 * Interface ElementWithBinding
 *
 * Defines an element which has binding parameters
 */
interface ElementWithBinding extends Element
{
    /**
     * Return the binding values of the clause
     *
     * @return array
     */
    public function getValues();
}
