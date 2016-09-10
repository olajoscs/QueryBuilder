<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Contracts\Query;
use OlajosCs\QueryBuilder\Contracts\Statements\SelectStatement as SelectStatementInterface;
use OlajosCs\QueryBuilder\Mysql\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\Mysql\Clauses\WhereElement;

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
     * @var WhereContainer
     */
    protected $whereContainer;


    /**
     * SelectStatement constructor.
     *
     * @param array $fields
     */
    public function __construct($fields = [])
    {
        $this->setFields($fields);
        $this->whereContainer = new WhereContainer();
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
    public function where($field, $operator, $value)
    {
        $this->whereContainer->add(
            new WhereElement($field, $operator, $value, WhereElement::GLUE_AND)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereOr($field, $operator, $value)
    {
        $this->whereContainer->add(
            new WhereElement($field, $operator, $value, WhereElement::GLUE_OR)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function asString()
    {
        $query = 'SELECT ' . implode(',', $this->fields) . ' ';
        $query .= 'FROM ' . $this->table;

        if ($this->whereContainer->has()) {
            $query .= $this->whereContainer->asString();
        }

        return $query;
    }


    public function __toString()
    {
        return $this->asString();
    }
}