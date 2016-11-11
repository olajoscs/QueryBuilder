<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\RawWhereElement as RawWhereElementCommon;


/**
 * Class RawWhereElement
 *
 * Defines a PostgreSQL specific raw where object
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
