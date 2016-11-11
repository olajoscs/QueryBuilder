<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\WhereContainer as WhereContainerInterface;
use OlajosCs\QueryBuilder\Contracts\Clauses\WhereElement as WhereElementInterface;
use OlajosCs\QueryBuilder\Contracts\RawExpression;


/**
 * Class RawWhereEelement
 *
 * Defines the database independent raw where object
 */
abstract class RawWhereElement implements WhereElementInterface
{
    /**
     * @var WhereContainerInterface Counter of the parameters
     */
    protected $whereContainer;

    /**
     * @var RawExpression
     */
    protected $expression;

    /**
     * @var array The values which have to be given to binding array
     */
    protected $values = [];

    /**
     * @var array Name of the parameters for the query
     */
    protected $names = [];


    /**
     * Create a new RawWhereElement object
     *
     * @param WhereContainerInterface $container
     * @param RawExpression           $expression
     * @param array                   $bindings
     */
    public function __construct(WhereContainerInterface $container, RawExpression $expression, array $bindings = [])
    {
        $this->whereContainer = $container;
        $this->expression     = $expression;

        foreach ($bindings as $name => $value) {
            $this->names[$name] = $this->addValue($name, $value);
        }
    }


    /**
     * Add a value to the value list
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return string The name of the parameter at binding
     */
    protected function addValue($name, $value)
    {
        $this->values[$name] = $value;

        return ':' . $name;
    }


    /**
     * @inheritDoc
     */
    public function getValues()
    {
        return $this->values;
    }


    /**
     * @inheritDoc
     */
    public function getGlue()
    {
        return WhereElementInterface::GLUE_AND;
    }

}