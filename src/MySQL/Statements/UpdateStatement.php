<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Contracts\Statements\UpdateStatement as UpdateStatementInterface;
use OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement;


/**
 * Class UpdateStatement
 *
 * Defines an update statement
 */
class UpdateStatement extends WhereStatement   implements UpdateStatementInterface
{
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