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
     * Defines the nulls last order
     */
    const NULLS_LAST = 'nl';

    /**
     * Defines the nulls first order
     */
    const NULLS_FIRST = 'nf';

    /**
     * Ascending order
     */
    const ORDER_ASC = 'ASC';

    /**
     * Descending order
     */
    const ORDER_DESC = 'DESC';


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
