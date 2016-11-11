<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\Common\RawExpression as RawExpressionCommon;


/**
 * Class RawExpression
 *
 * Defines a MySQL specific RawExpression object
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


    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->asString();
    }
}
