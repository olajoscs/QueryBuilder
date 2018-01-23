<?php

namespace OlajosCs\QueryBuilder\SQLite\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\JoinContainer as JoinContainerCommon;

/**
 * Class JoinContainer
 *
 * Defines the join container for SQLite
 */
class JoinContainer extends JoinContainerCommon
{
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
