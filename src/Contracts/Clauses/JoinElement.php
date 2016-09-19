<?php

namespace OlajosCs\QueryBuilder\Contracts\Clauses;

/**
 * Interface JoinElement
 *
 * Defines what a join element has to know
 */
interface JoinElement extends Element
{
    /**
     * Returns the name of the table on the left
     *
     * @return string
     */
    public function getTableLeft();


    /**
     * Returns the name of the table on the right
     *
     * @return string
     */
    public function getTableRight();


    /**
     * Returns the name of the field on the left
     *
     * @return string
     */
    public function getFieldLeft();


    /**
     * Returns the name of the field on the right
     *
     * @return string
     */
    public function getFieldRight();


    /**
     * Returns the operator to join the 2 fields
     *
     * @return string
     */
    public function getOperator();


    /**
     * Returns the join type
     *
     * @return string
     */
    public function getType();
}
