<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\JoinElement as JoinElementInterface;

/**
 * Class JoinElement
 *
 * Define a join element
 */
class JoinElement implements JoinElementInterface
{
    /**
     * Inner Join type
     */
    const TYPE_INNER = 'INNER';

    /**
     * Outer Join type
     */
    const TYPE_OUTER = 'OUTER';

    /**
     * Left Join type
     */
    const TYPE_LEFT = 'LEFT';

    /**
     * Right Join type
     */
    const TYPE_RIGHT = 'RIGHT';

    /**
     * @var string Name of the table on the left
     */
    private $tableLeft;

    /**
     * @var string Name of the table on the right
     */
    private $tableRight;

    /**
     * @var string Name of the field on the left
     */
    private $fieldLeft;

    /**
     * @var string Name of the field on the right
     */
    private $fieldRight;

    /**
     * @var string The operator to connect the 2 fields
     */
    private $operator;

    /**
     * @var string The type of the join - one of the TYPE_ constants
     */
    private $type;


    /**
     * Create a new Join element to the query
     *
     * @param string $tableLeft
     * @param string $fieldLeft
     * @param string $operator
     * @param string $tableRight
     * @param string $fieldRight
     * @param string $type
     */
    public function __construct($tableLeft, $fieldLeft, $operator, $tableRight, $fieldRight, $type)
    {
        $this->tableLeft  = $tableLeft;
        $this->fieldLeft  = $fieldLeft;
        $this->operator   = $operator;
        $this->tableRight = $tableRight;
        $this->fieldRight = $fieldRight;
        $this->type       = $type;
    }


    public function asString()
    {
        return sprintf(
            ' %s JOIN %s ON %s.%s %s %s.%s',
            $this->getType(),
            $this->getTableRight(),
            $this->getTableLeft(),
            $this->getFieldLeft(),
            $this->getOperator(),
            $this->getTableRight(),
            $this->getFieldRight()
        );
    }


    /**
     * @inheitdoc
     */
    public function getTableLeft()
    {
        return $this->tableLeft;
    }


    /**
     * @inheitdoc
     */
    public function getTableRight()
    {
        return $this->tableRight;
    }


    /**
     * @inheitdoc
     */
    public function getFieldLeft()
    {
        return $this->fieldLeft;
    }


    /**
     * @inheitdoc
     */
    public function getFieldRight()
    {
        return $this->fieldRight;
    }


    /**
     * @inheitdoc
     */
    public function getOperator()
    {
        return $this->operator;
    }


    /**
     * @inheitdoc
     */
    public function getType()
    {
        return $this->type;
    }

}
