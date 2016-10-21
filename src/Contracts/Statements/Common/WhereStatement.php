<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements\Common;

/**
 * Interface WhereStatement
 *
 * Defines what a statement has to know if where clause can be used
 */
interface WhereStatement extends Statement
{
    /**
     * Set a where condition
     *
     * @param string $field
     * @param string $operator One of the Operator constants
     * @param mixed  $value
     *
     * @return WhereStatement
     */
    public function where($field, $operator, $value);


    /**
     * Set a where condition with or glue
     *
     * @param string $field
     * @param string $operator
     * @param mixed  $value
     *
     * @return WhereStatement
     */
    public function whereOr($field, $operator, $value);


    /**
     * Set a where in condition
     *
     * @param string $field
     * @param array  $values
     *
     * @return WhereStatement
     */
    public function whereIn($field, array $values);


    /**
     * Set a where not in condition
     *
     * @param string $field
     * @param array  $values
     *
     * @return WhereStatement
     */
    public function whereNotIn($field, array $values);


    /**
     * Set a where between condition
     *
     * @param string $field
     * @param mixed  $min
     * @param mixed  $max
     *
     * @return WhereStatement
     */
    public function whereBetween($field, $min, $max);


    /**
     * Set a where field is null condition
     *
     * @param string $field
     *
     * @return WhereStatement
     */
    public function whereNull($field);


    /**
     * Set a where field is not null condition
     *
     * @param string $field
     *
     * @return WhereStatement
     */
    public function whereNotNull($field);


    /**
     * Set a where field is null condition with "or" glue
     *
     * @param string $field
     *
     * @return WhereStatement
     */
    public function whereNullOr($field);


    /**
     * Set a where field is not null condition with "or" glue
     *
     * @param string $field
     *
     * @return WhereStatement
     */
    public function whereNotNullOr($field);
}
