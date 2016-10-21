<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\WhereElement as WhereElementCommon;
use OlajosCs\QueryBuilder\Contracts\Clauses\WhereElement as WhereElementInterface;
use OlajosCs\QueryBuilder\Operator;

/**
 * Class WhereElement
 *
 * Represents a where statement
 */
class WhereElement extends WhereElementCommon implements WhereElementInterface
{
    /**
     * @inheritdoc
     */
    public function asString()
    {
        if ($this->hasNullValueOperator()) {
            $this->values = [];

            return sprintf(
                '%s %s',
                $this->getField(),
                $this->getOperator()
            );
        } else {
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
}
