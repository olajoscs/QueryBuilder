<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\ContainerWithBinding;
use OlajosCs\QueryBuilder\Exceptions\InvalidGlueException;

/**
 * Class WhereContainer
 *
 * Defines a where container for the query builder
 */
class WhereContainer extends Container implements ContainerWithBinding
{
    /**
     * @var array The list of the binding parameters
     */
    private $parameters = [];

    /**
     * @var WhereElement[]
     */
    protected $list = [];


    /**
     * @inheritdoc
     * @throws InvalidGlueException
     */
    public function asString()
    {
        $query = '';

        if (empty($this->get())) {
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
}