<?php

namespace OlajosCs\QueryBuilder\Contracts\Clauses;

/**
 * Interface WhereElement
 *
 * Defines what a where container has to know
 */
interface WhereElement extends ElementWithBinding
{
    /**
     * AND glue between clauses
     */
    const GLUE_AND = 'AND';

    /**
     * OR glue between clauses
     */
    const GLUE_OR = 'OR';


    /**
     * Return the glue before the clause
     *
     * @return string
     */
    public function getGlue();
}
