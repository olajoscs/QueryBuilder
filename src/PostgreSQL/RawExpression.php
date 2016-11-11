<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;

use OlajosCs\QueryBuilder\Common\RawExpression as RawExpressionCommon;


/**
 * Class RawExpression
 *
 * Defines a PostgreSQL specific RawExpression object
 */
class RawExpression extends RawExpressionCommon
{
    /**
     * @inheritdoc
     */
    public function asString()
    {
        return $this->expression;
    }
}
