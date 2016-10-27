<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements;

use OlajosCs\QueryBuilder\Contracts\Statements\Common\WhereStatement;

/**
 * Interface DeleteStatement
 *
 * Defines a delete statement
 */
interface DeleteStatement extends WhereStatement
{
    /**
     * Set the table to query
     *
     * @param string $table
     *
     * @return DeleteStatement
     */
    public function from($table);


    /**
     * @inheritdoc
     * @return DeleteStatement
     */
    public function where($field, $operator, $value);


    /**
     * @inheritdoc
     * @return DeleteStatement
     */
    public function whereOr($field, $operator, $value);


    /**
     * @inheritdoc
     * @return DeleteStatement
     */
    public function whereIn($field, array $values);


    /**
     * @inheritdoc
     * @return DeleteStatement
     */
    public function whereNotIn($field, array $values);


    /**
     * @inheritdoc
     * @return DeleteStatement
     */
    public function whereBetween($field, $min, $max);


    /**
     * @inheritdoc
     * @return DeleteStatement
     */
    public function whereNull($field);


    /**
     * @inheritdoc
     * @return DeleteStatement
     */
    public function whereNotNull($field);


    /**
     * @inheritdoc
     * @return DeleteStatement
     */
    public function whereNullOr($field);


    /**
     * @inheritdoc
     * @return DeleteStatement
     */
    public function whereNotNullOr($field);
}
