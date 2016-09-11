<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

class JoinContainer extends Container
{
    /**
     * @var JoinContainer[]
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
