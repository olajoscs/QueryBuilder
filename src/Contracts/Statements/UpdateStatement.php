<?php

namespace OlajosCs\QueryBuilder\Contracts\Statements;

use OlajosCs\QueryBuilder\Contracts\Statements\Common\WhereStatement;

/**
 * Interface UpdateStatement
 *
 * Defines an update statement
 */
interface UpdateStatement extends WhereStatement
{
    /**
     * Set the fields to update as an associative array.
     * Keys are the field names, values are the new values
     *
     * @param array $fields
     *
     * @return UpdateStatement
     */
    public function set(array $fields);


    /**
     * Set the table which is updated
     *
     * @param string $table
     *
     * @return UpdateStatement
     */
    public function setTable($table);


    /**
     * @inheritdoc
     * @return UpdateStatement
     */
    public function where($field, $operator, $value);


    /**
     * @inheritdoc
     * @return UpdateStatement
     */
    public function whereOr($field, $operator, $value);


    /**
     * @inheritdoc
     * @return UpdateStatement
     */
    public function whereIn($field, array $values);


    /**
     * @inheritdoc
     * @return UpdateStatement
     */
    public function whereNotIn($field, array $values);


    /**
     * @inheritdoc
     * @return UpdateStatement
     */
    public function whereBetween($field, $min, $max);


    /**
     * @inheritdoc
     * @return UpdateStatement
     */
    public function whereNull($field);


    /**
     * @inheritdoc
     * @return UpdateStatement
     */
    public function whereNotNull($field);


    /**
     * @inheritdoc
     * @return UpdateStatement
     */
    public function whereNullOr($field);


    /**
     * @inheritdoc
     * @return UpdateStatement
     */
    public function whereNotNullOr($field);
}
