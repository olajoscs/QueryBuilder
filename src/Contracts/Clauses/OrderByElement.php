<?php

namespace OlajosCs\QueryBuilder\Contracts\Clauses;


/**
 * Interface OrderByElement
 *
 * Defines what an orde by element has to know
 */
interface OrderByElement extends Element
{
    /**
     * Return the field to order
     *
     * @return string
     */
    public function getField();


    /**
     * Return the order of the order
     *
     * @return string
     */
    public function getOrder();


    /**
     * Return the nulls position
     *
     * @return string
     */
    public function getNullsPosition();
}