<?php

namespace OlajosCs\QueryBuilder\Contracts\Clauses;

/**
 * Interface ContainerWithBinding
 *
 * Defines a container which has binding parameters
 */
interface ContainerWithBinding extends Container
{
    /**
     * Returns the parameters passed to where clauses - to use in bindings
     *
     * @return array
     */
    public function getParameters();
}
