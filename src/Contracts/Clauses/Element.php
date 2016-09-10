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
     * @return mixed
     */
    public function asString();


    /**
     * Return the binding values of the clause
     *
     * @return array
     */
    public function getValues();
}
