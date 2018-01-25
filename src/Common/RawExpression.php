<?php

namespace OlajosCs\QueryBuilder\Common;

use OlajosCs\QueryBuilder\Contracts\RawExpression as RawExpressionInterface;


/**
 * Class Expression
 *
 * Defines a database independent RawExpression object
 */
abstract class RawExpression implements RawExpressionInterface
{
    /**
     * @var string The expression
     */
    protected $expression;


    /**
     * Create a new Expression object
     *
     * @param string $expression
     */
    public function __construct($expression)
    {
        $this->expression = $expression;
    }


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