<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\WhereContainer as WhereContainerCommon;
use OlajosCs\QueryBuilder\Exceptions\InvalidGlueException;

/**
 * Class WhereContainer
 *
 * Defines a where container for the query builder
 */
class WhereContainer extends WhereContainerCommon
{
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
