<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\WhereContainer as WhereContainerInterface;
use OlajosCs\QueryBuilder\Exceptions\InvalidGlueException;


/**
 * Class WhereContainer
 *
 * Database independent WhereContainer object
 * Contains only the logic to build the model
 */
abstract class WhereContainer extends Container implements WhereContainerInterface
{
    /**
     * @var array The list of the binding parameters
     */
    protected $parameters = [];

    /**
     * @var WhereElement[]
     */
    protected $list = [];

    /**
     * @var int Counter of the parameters
     */
    protected $bindingCount = 0;


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
    public function getBindingCount()
    {
        return $this->bindingCount++;
    }


    /**
     * @inheritdoc
     * @throws InvalidGlueException
     */
    public function asString()
    {
        $andList   = [];
        $orList    = [];
        $query = ' WHERE ';

        foreach ($this->list as $clause) {
            switch ($clause->getGlue()) {
                case WhereElement::GLUE_AND:
                    $andList[] = $clause->asString();
                    break;
                case WhereElement::GLUE_OR:
                    $orList[] = $clause->asString();
                    break;
                default:
                    throw new InvalidGlueException('Invalid glue to where: ' . $clause->getGlue());
            }

            $this->parameters = array_merge($this->parameters, $clause->getValues());
        }

        if (!empty($andList)) {
            $query .= implode(' ' . WhereElement::GLUE_AND . ' ', $andList);
        }

        if (!empty($orList)) {
            if (!empty($andList)) {
                $query .= ' ' . WhereElement::GLUE_OR . ' ';
            }

            $query .= implode(' ' . WhereElement::GLUE_OR . ' ', $orList);
        }

        return $query;
    }
}