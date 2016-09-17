<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\Contracts\Clauses\WhereContainer as WhereContainerInterface;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\WhereElement;
use OlajosCs\QueryBuilder\Operator;


/**
 * Class UpdateStatement
 *
 * Defines an update statement
 */
class UpdateStatement implements \OlajosCs\QueryBuilder\Contracts\Statements\UpdateStatement
{
    /**
     * @var WhereContainerInterface
     */
    protected $whereContainer;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var array The array of the binding
     */
    protected $names = [];

    /**
     * @var string[]
     */
    protected $parameters = [];

    /**
     * @var string The name of the table
     */
    protected $table;


    /**
     * @inheritDoc
     */
    public function __construct(Connection $connection)
    {
        $this->connection     = $connection;
        $this->whereContainer = new WhereContainer();
    }


    /**
     * @inheritDoc
     */
    public function set(array $fields)
    {
        $this->names      = [];
        $this->parameters = [];

        foreach ($fields as $field => $value) {
            $this->addValue($field, $value);
        }

        return $this;
    }


    /**
     * Add a value to the update statement.
     * It is added as a placeholder to the values, and the real value is added to the binding list
     *
     * @param string $field
     * @param mixed  $value
     *
     * @return void
     */
    private function addValue($field, $value)
    {
        $name = ':' . $field;

        $this->names[$field]      = $name;
        $this->parameters[$field] = $value;
    }


    /**
     * @inheritDoc
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function where($field, $operator, $value)
    {
        $this->whereContainer->add(
            new WhereElement($field, $operator, $value, WhereElement::GLUE_AND)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereOr($field, $operator, $value)
    {
        $this->whereContainer->add(
            new WhereElement($field, $operator, $value, WhereElement::GLUE_OR)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereIn($field, array $values)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::IN, $values)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereNotIn($field, array $values)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::NOTIN, $values)
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function whereBetween($field, $min, $max)
    {
        $this->whereContainer->add(
            new WhereElement($field, Operator::BETWEEN, [$min, $max])
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->connection->execute($this->asString(), $this->parameters);
    }


    /**
     * @inheritDoc
     */
    public function asString()
    {
        $values = [];
        foreach ($this->names as $field => $name) {
            $values[] = $field . ' = ' . $name;
        }

        $query = 'UPDATE ' . $this->table;
        $query .= ' SET ' . implode(', ', $values);

        if ($this->whereContainer->has()) {
            $query .= $this->whereContainer->asString();
        }

        $this->parameters = array_merge($this->parameters, $this->whereContainer->getParameters());

        return $query;
    }

}