<?php

namespace OlajosCs\QueryBuilder\SQLite\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\RawWhereElement as RawWhereElementCommon;


/**
 * Class RawWhereElement
 *
 * Defines a SQLite specific raw where object
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
