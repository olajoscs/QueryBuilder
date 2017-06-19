<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;

use OlajosCs\QueryBuilder\Contracts\RawExpression as RawExpressionInterface;

/**
 * Trait NameNormalizer
 *
 * Name normalizer for Postgre database, as it is case-sensitive.
 */
trait NameNormalizer
{
    /**
     * Normalize the name for PGSQL
     * Quotes are put around all the words, which are divided with dot, as PG is case sensitive
     *
     * <code>
     * schemeName.tableName.fieldName => "schemeName"."tableName"."fieldName"
     * </code>
     *
     * @param string|RawExpression $name
     *
     * @return string
     */
    public function normalize($name)
    {
        if ($name instanceof RawExpressionInterface) {
            return (string)$name;
        }

        return implode(
            '.',
            array_map(
                function($value) {
                    return $value === '*' ? $value : '"' . $value . '"';
                },
                explode('.', $name)
            )
        );
    }
}