<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\JoinElement as JoinElementInterface;


/**
 * Class JoinElement
 *
 * Database independent join model
 * Contains only the logic to build the model
 */
abstract class JoinElement implements JoinElementInterface
{
    /**
     * @var string Name of the table on the left
     */
    protected $tableLeft;

    /**
     * @var string Name of the table on the right
     */
    protected $tableRight;

    /**
     * @var string Name of the field on the left
     */
    protected $fieldLeft;

    /**
     * @var string Name of the field on the right
     */
    protected $fieldRight;

    /**
     * @var string The operator to connect the 2 fields
     */
    protected $operator;

    /**
     * @var string The type of the join - one of the TYPE_ constants
     */
    protected $type;


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