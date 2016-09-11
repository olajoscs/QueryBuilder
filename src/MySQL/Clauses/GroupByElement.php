<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\Element;

/**
 * Class GroupByElement
 *
 * Defines a group by element to the query
 */
class GroupByElement implements Element
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
     * Return the field name to group by
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

}