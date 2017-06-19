<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\WhereElement as WhereElementCommon;
use OlajosCs\QueryBuilder\Operator;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class WhereElement
 *
 * Represents a where statement
 */
class WhereElement extends WhereElementCommon
{
    use NameNormalizer;

    /**
     * @inheritdoc
     */
    public function asString()
    {
        if ($this->hasNullValueOperator()) {
            $this->values = [];

            return sprintf(
                '%s %s',
                $this->normalize($this->getField()),
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
            return 'false';
        }

        if ($this->operator === Operator::NOTIN && empty($this->values)) {
            return 'true';
        }

        return sprintf(
            '%s %s %s',
            $this->normalize($this->getField()),
            $this->getOperator(),
            $name
        );
    }
}
