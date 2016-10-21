<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\JoinContainer as JoinContainerCommon;
use OlajosCs\QueryBuilder\Contracts\Clauses\JoinContainer as JoinContainerInterface;

/**
 * Class JoinContainer
 *
 * Defines the join container for mysql
 */
class JoinContainer extends JoinContainerCommon implements JoinContainerInterface
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
