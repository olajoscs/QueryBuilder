<?php

namespace OlajosCs\QueryBuilder\PostgreSQL\Clauses;

use OlajosCs\QueryBuilder\Common\Clauses\JoinElement as JoinElementCommon;
use OlajosCs\QueryBuilder\PostgreSQL\NameNormalizer;

/**
 * Class JoinElement
 *
 * Define a join element
 */
class JoinElement extends JoinElementCommon
{
    use NameNormalizer;

    /**
     * @inheritdoc
     */
    public function asString()
    {
        return sprintf(
            ' %s JOIN %s ON %s.%s %s %s.%s',
            $this->getType(),
            $this->normalize($this->getTableRight()),
            $this->normalize($this->getTableLeft()),
            $this->normalize($this->getFieldLeft()),
            $this->getOperator(),
            $this->normalize($this->getTableRight()),
            $this->normalize($this->getFieldRight())
        );
    }
}
