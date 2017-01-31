<?php

namespace OlajosCs\QueryBuilder\Contracts;


/**
 * Interface RawExpression
 *
 * Defines what a RawExpression object has to know
 */
interface RawExpression
{
    /**
     * Create a new RawExpression object
     *
     * @param string $expression
     */
    public function __construct($expression);


    /**
     * Return the expression as a stirng
     *
     * @return string
     */
    public function asString();


    /**
     * Return the raw expression as a string
     *
     * @return mixed
     */
    public function __toString();
}