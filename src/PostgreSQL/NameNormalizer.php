<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;


/**
 * Trait NameNormalizer
 *
 * Name normalizer for Postgre database, as it is case-sensitive.
 */
trait NameNormalizer
{
    /**
     * @var array
     */
    private $specCharacters = ['*', '(', ')', ' '];


    /**
     * Normalize the name for PGSQL
     * Quotes are put around all the words, which are divided with dot, as PG is case sensitive
     *
     * <code>
     * schemeName.tableName.fieldName => "schemeName"."tableName"."fieldName"
     * </code>
     *
     * @param string $name
     *
     * @return string
     */
    public function normalize($name)
    {
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