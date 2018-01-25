<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\JoinContainer as JoinContainerInterface;


/**
 * Class JoinContainer
 *
 * Database independent JoinContainer model
 * Contains only the logic to build the model
 */
abstract class JoinContainer extends Container implements JoinContainerInterface
{
    /**
     * @var JoinElement[]
     */
    protected $list = [];


    /**
     * Return the join of clauses as a string
     *
     * @return mixed
     */
    public function asString()
    {
        $query = '';

        if (!empty($this->list)) {
            foreach ($this->list as $clause) {
                $query .= $clause->asString();
            }
        }

        return $query;
    }
}