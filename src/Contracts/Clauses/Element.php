<?php

namespace OlajosCs\QueryBuilder\Contracts\Clauses;

/**
 * Interface Element
 *
 * Defines a clause element
 */
interface Element
{
    /**
     * Return the clause as a string
     *
     * @return string
     */
    public function asString();
}
