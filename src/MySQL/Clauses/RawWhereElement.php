<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\RawWhereElement as RawWhereElementCommon;


/**
 * Class RawWhereElement
 *
 * Defines a MySQL specific raw where object
 */
class RawWhereElement extends RawWhereElementCommon
{
    /**
     * @inheritDoc
     */
    public function asString()
    {
        return $this->expression->asString();
    }
}
