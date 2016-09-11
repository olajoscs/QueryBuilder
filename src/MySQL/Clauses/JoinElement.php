<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\Element;

class JoinElement implements Element
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
     * Returns the name of the table on the left
     *
     * @return string
     */
    public function getTableLeft()
    {
        return $this->tableLeft;
    }


    /**
     * Returns the name of the table on the right
     *
     * @return string
     */
    public function getTableRight()
    {
        return $this->tableRight;
    }



    /**
     * Returns the name of the field on the left
     *
     * @return string
     */
    public function getFieldLeft()
    {
        return $this->fieldLeft;
    }


    /**
     * Returns the name of the field on the right
     *
     * @return string
     */
    public function getFieldRight()
    {
        return $this->fieldRight;
    }


    /**
     * Returns the operator to join the 2 fields
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }


    /**
     * Returns the join type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}
