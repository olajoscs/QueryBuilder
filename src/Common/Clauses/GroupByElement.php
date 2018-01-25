<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByElement as GroupByElementInterface;


/**
 * Class GroupByElement
 *
 * Database indepednent GroupByElement model
 * Contains only the logic to build the model
 */
abstract class GroupByElement implements GroupByElementInterface
{
    /**
     * @var string Field name to group by
     */
    protected $field;


    /**
     * Create a new group by element
     *
     * @param string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }


    /**
     * @inheritdoc
     */
    public function getField()
    {
        return $this->field;
    }


    /**
     * @inheritdoc
     */
    public function asString()
    {
        return $this->field;
    }
}