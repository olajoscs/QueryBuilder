<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByElement as GroupByElementInterface;

/**
 * Class GroupByElement
 *
 * Defines a group by element to the query
 */
class GroupByElement implements GroupByElementInterface
{
    /**
     * @var string Field name to group by
     */
    private $field;


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
    public function asString()
    {
        return $this->field;
    }


    /**
     * @inheritdoc
     */
    public function getField()
    {
        return $this->field;
    }

}