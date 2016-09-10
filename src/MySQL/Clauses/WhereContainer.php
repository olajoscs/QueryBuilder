<?php

namespace OlajosCs\QueryBuilder\Mysql\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\Container;
use OlajosCs\QueryBuilder\Contracts\Clauses\Element;
use OlajosCs\QueryBuilder\Exceptions\InvalidGlueException;

/**
 * Class WhereContainer
 *
 * Defines a where container for the query builder
 */
class WhereContainer implements Container
{
    /**
     * @var WhereElement[] The list of the where elements in the container
     */
    private $list;

    /**
     * @var array The list of the binding parameters
     */
    private $parameters = [];


    /**
     * @inheritdoc
     */
    public function add(Element $element)
    {
        $this->list[] = $element;

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function get()
    {
        return $this->list;
    }


    /**
     * @inheritdoc
     * @throws InvalidGlueException
     */
    public function asString()
    {
        $query = '';

        if (empty($this->list)) {
            return $query;
        }

        $and   = array();
        $or    = array();
        $query = ' WHERE ';

        foreach ($this->list as $clause) {
            switch ($clause->getGlue()) {
                case WhereElement::GLUE_AND:
                    $and[] = $clause->asString();
                    break;
                case WhereElement::GLUE_OR:
                    $or[] = $clause->asString();
                    break;
                default:
                    throw new InvalidGlueException('Invalid glue to where: ' . $clause->getGlue());
            }

            $this->parameters = array_merge($this->parameters, $clause->getValues());
        }

        if (!empty($and)) {
            $query .= implode(' ' . WhereElement::GLUE_AND . ' ', $and);
        }

        if (!empty($or)) {
            if (!empty($and)) {
                $query .= ' ' . WhereElement::GLUE_OR . ' ';
            }

            $query .= implode(' ' . WhereElement::GLUE_OR . ' ', $or);
        }

        return $query;
    }


    /**
     * @inheritdoc
     */
    public function getParameters()
    {
        return $this->parameters;
    }


    /**
     * @inheritdoc
     */
    public function has()
    {
        return !empty($this->get());
    }
}