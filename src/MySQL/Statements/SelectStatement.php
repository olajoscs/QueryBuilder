<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Contracts\Query;
use OlajosCs\QueryBuilder\Contracts\Statements\SelectStatement as SelectStatementInterface;

/**
 * Class SelectStatement
 *
 * Defines a select statement
 */
class SelectStatement implements SelectStatementInterface, Query
{
    /**
     * @var string[] The name of the fields to get in the query
     */
    protected $fields;

    /**
     * @var string The name of the table
     */
    protected $table;


    /**
     * SelectStatement constructor.
     *
     * @param array $fields
     */
    public function __construct($fields = [])
    {
        $this->setFields($fields);
    }


    /**
     * @inheritdoc
     */
    public function setFields($fields)
    {
        if (empty($fields)) {
            $fields = ['*'];
        }

        if (!is_array($fields)) {
            $fields = [$fields];
        }

        $this->fields = $fields;

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function from($table)
    {
        $this->table = $table;

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function asString()
    {
        $query = 'SELECT ' . implode(',', $this->fields) . ' ';
        $query .= 'FROM ' . $this->table;

        return $query;
    }


    public function __toString()
    {
        return $this->asString();
    }


}