<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByElement as GroupByElementInterface;


/**
 * Class GroupByElement
 *
 *
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
}