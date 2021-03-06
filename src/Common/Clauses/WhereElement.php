<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\WhereContainer as WhereContainerInterface;
use OlajosCs\QueryBuilder\Contracts\Clauses\WhereElement as WhereElementInterface;
use OlajosCs\QueryBuilder\Operator;


/**
 * Class WhereElement
 *
 * Database independent WhereElement
 * Contains only the logic to build the model
 */
abstract class WhereElement implements WhereElementInterface
{
    /**
     * @var WhereContainerInterface Counter of the parameters
     */
    protected $whereContainer;

    /**
     * @var array The array operators
     */
    protected static $arrayOperators = [
        Operator::IN,
        Operator::NOTIN,
        Operator::BETWEEN,
    ];

    /**
     * @var array The operators, which does not need any bindig value
     */
    protected static $nullValueOperators = [
        Operator::IS_NULL,
        Operator::IS_NOT_NULL,
    ];

    /**
     * @var string The name of the field to check
     */
    protected $field;

    /**
     * @var string The operator of the comparison
     */
    protected $operator;

    /**
     * @var string The glue before the clause
     */
    protected $glue;

    /**
     * @var array The values which have to be given to binding array
     */
    protected $values = [];

    /**
     * @var array Name of the parameters for the query
     */
    protected $names = [];


    /**
     * WhereElement constructor.
     *
     * @param WhereContainerInterface $whereContainer
     * @param string                  $field
     * @param string                  $operator
     * @param mixed                   $value
     * @param string                  $glue
     */
    public function __construct(WhereContainerInterface $whereContainer, $field, $operator, $value, $glue = self::GLUE_AND)
    {
        $this->whereContainer = $whereContainer;
        $this->field          = $field;
        $this->operator       = $operator;

        if (!\in_array($operator, self::$nullValueOperators)) {
            if (!\is_array($value)) {
                $value = [$value];
            }

            foreach ($value as $item) {
                $this->names[] = $this->addValue($item);
            }
        }


        $this->glue = $glue;
    }


    /**
     * @inheritdoc
     */
    public function asString()
    {
        if ($this->hasNullValueOperator()) {
            $this->values = [];

            return sprintf(
                '%s %s',
                $this->getNormalizedField(),
                $this->getOperator()
            );
        }

        if ($this->hasArrayOperator()) {
            if ($this->operator === Operator::BETWEEN) {
                $name = $this->names[0] . ' AND ' . $this->names[1];
            } else {
                $name = '(' . implode(',', $this->names) . ')';
            }
        } else {
            $name = $this->names[0];
        }

        if ($this->operator === Operator::IN && empty($this->values)) {
            return '1 = 0';
        }

        if ($this->operator === Operator::NOTIN && empty($this->values)) {
            return '1 = 1';
        }

        return sprintf(
            '%s %s %s',
            $this->getNormalizedField(),
            $this->getOperator(),
            $name
        );
    }


    /**
     * Add a value to the value list
     *
     * @param mixed $value
     *
     * @return string The name of the parameter at binding
     */
    protected function addValue($value)
    {
        $name                = 'where' . $this->whereContainer->getBindingCount();
        $this->values[$name] = $value;

        return ':' . $name;
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
     * Return that the where clause has an operator which handles array values
     *
     * @return bool
     */
    protected function hasArrayOperator()
    {
        return in_array($this->getOperator(), self::$arrayOperators);
    }


    /**
     * @inheritdoc
     */
    public function getOperator()
    {
        return $this->operator;
    }


    /**
     * Return that the where clause has an operator which does not need any binding value or not
     *
     * @return bool
     */
    protected function hasNullValueOperator()
    {
        return in_array($this->getOperator(), self::$nullValueOperators);
    }


    /**
     * Return the normalized field name
     *
     * @return string
     */
    protected function getNormalizedField()
    {
        return $this->field;
    }
}