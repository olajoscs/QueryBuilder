<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Contracts\Query;
use OlajosCs\QueryBuilder\Contracts\Statements\SelectStatement as SelectStatementInterface;
use OlajosCs\QueryBuilder\MySQL\Clauses\JoinContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\OrderByContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\OrderByElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement;
use OlajosCs\QueryBuilder\Operator;

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
     * @var JoinContainer
     */
    protected $joinContainer;

    /**
     * @var OrderByContainer
     */
    protected $orderByContainer;


    /**
     * SelectStatement constructor.
     *
     * @param array $fields
     */
    public function __construct($fields = [])
    {
        $this->setFields($fields);
        $this->whereContainer   = new WhereContainer();
        $this->joinContainer    = new JoinContainer();
        $this->orderByContainer = new OrderByContainer();
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
    public function whereIn($field, array $values)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::IN, $values)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereNotIn($field, array $values)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::NOTIN, $values)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function join($tableRight, $fieldRight, $operator, $fieldLeft, $tableLeft = null)
    {
        $this->joinContainer->add(
            new JoinElement(
                $tableLeft ?: $this->table,
                $fieldLeft,
                $operator,
                $tableRight,
                $fieldRight,
                JoinElement::TYPE_INNER
            )
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function whereBetween($field, $min, $max)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::BETWEEN, [$min, $max])
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function orderBy($field, $order = null, $nullsPosition = null)
    {
        $this->orderByContainer->add(
            new OrderByElement($field, $order, $nullsPosition)
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

        if ($this->joinContainer->has()) {
            $query .= $this->joinContainer->asString();
        }

        if ($this->whereContainer->has()) {
            $query .= $this->whereContainer->asString();
        }

        if ($this->orderByContainer->has()) {
            $query .= $this->orderByContainer->asString();
        }

        return $query;
    }


    public function __toString()
    {
        return $this->asString();
    }
}