<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\JoinElement as JoinElementCommon;

/**
 * Class JoinElement
 *
 * Define a join element
 */
class JoinElement extends JoinElementCommon
{
    /**
     * @inheritdoc
     */
    public function asString()
    {
        return sprintf(
            ' %s JOIN %s ON %s.%s %s %s.%s',
            $this->getType(),
            $this->getTableRight(),
            $this->getTableLeft(),
            $this->getFieldLeft(),
            $this->getOperator(),
            $this->getTableRight(),
            $this->getFieldRight()
        );
    }
}
