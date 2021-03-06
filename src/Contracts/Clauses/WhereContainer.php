<?php

namespace OlajosCs\QueryBuilder\Contracts\Clauses;


/**
 * Interface WhereContainer
 *
 * Defines what a where container has to know
 */
interface WhereContainer extends ContainerWithBinding
{
    /**
     * Return the binding counter, then increment it
     *
     * @return int
     */
    public function getBindingCount();
}
