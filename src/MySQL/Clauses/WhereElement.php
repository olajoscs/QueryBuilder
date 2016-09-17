<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\WhereElement as WhereElementInterface;
use OlajosCs\QueryBuilder\Operator;

/**
 * Class WhereElement
 *
 * Represents a where statement
 */
class WhereElement implements WhereElementInterface
{
    /**
     * AND glue between clauses
     */
    const GLUE_AND = 'AND';

    /**
     * OR glue between clauses
     */
    const GLUE_OR = 'OR';

    /**
     * @var int Counter of the parameters. Static to be able to iterate between multiple where clauses
     */
    private static $valueCount = 0;

    /**
     * @var string The name of the field to check
     */
    private $field;

    /**
     * @var string The operator of the comparison
     */
    private $operator;

    /**
     * @var string The glue before the clause
     */
    private $glue;

    /**
     * @var array The values which have to be given to binding array
     */
    private $values;

    /**
     * @var array The array operators
     */
    protected static $arrayOperators = [
        Operator::IN,
        Operator::NOTIN,
        Operator::BETWEEN,
    ];

    /**
     * @var array Paraméter nevek a query-be
     */
    private $names = [];


    /**
     * WhereElement constructor.
     *
     * @param string $field
     * @param string $operator
     * @param mixed  $value
     * @param string $glue
     */
    public function __construct($field, $operator, $value, $glue = self::GLUE_AND)
    {
        $this->field    = $field;
        $this->operator = $operator;

        if (is_array($value)) {
            foreach ($value as $item) {
                $this->names[] = $this->addValue($item);
            }
        } else {
            $this->names[] = $this->addValue($value);
        }

        $this->glue = $glue;
    }


    /**
     * @inheritdoc
     */
    public function getField()
    {
        return $this->field;
    }


    /**
     * Add a value to the value list
     *
     * @param mixed $value
     *
     * @return string The name of the parameter at binding
     */
    private function addValue($value)
    {
        $name                = self::$valueCount++;
        $name                = 'where' . $name;
        $this->values[$name] = $value;

        return ':' . $name;
    }


    /**
     * @inheritdoc
     */
    public function getOperator()
    {
        return $this->operator;
    }


    /**
     * @inheritdoc
     */
    public function getGlue()
    {
        return $this->glue;
    }


    /**
     * @inheritdoc
     */
    public function getValues()
    {
        return $this->values;
    }


    /**
     * Returns that the where clause has an operator which handles array values
     *
     * @return bool
     */
    private function hasArrayOperator()
    {
        return in_array($this->getOperator(), self::$arrayOperators);
    }


    /**
     * Return the where clause as string
     *
     * @return string
     */
    public function asString()
    {
        if ($this->hasArrayOperator()) {
            if ($this->operator === Operator::BETWEEN) {
                $name = $this->names[0] . ' AND ' . $this->names[1];
            } else {
                $name = '(' . implode(',', $this->names) . ')';
            }
        } else {
            $name = $this->names[0];
        }

        return sprintf(
            '%s %s %s',
            $this->getField(),
            $this->getOperator(),
            $name
        );
    }

}