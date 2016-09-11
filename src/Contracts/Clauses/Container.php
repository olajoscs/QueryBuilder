<?php

namespace OlajosCs\QueryBuilder\Contracts\Clauses;

/**
 * Interface Container
 *
 * Defines a clause container
 */
interface Container
{
    /**
     * Add an element to the container
     *
     * @param Element $element
     *
     * @return static
     */
    public function add(Element $element);


    /**
     * Return the elements of the container
     *
     * @return Element[]
     */
    public function get();


    /**
     * Return the join of clauses as a string
     *
     * @return string
     */
    public function asString();


    /**
     * Return whether the container has elemnents or not
     *
     * @return bool
     */
    public function has();
}
