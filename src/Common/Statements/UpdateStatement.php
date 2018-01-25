<?php

namespace OlajosCs\QueryBuilder\Common\Statements;

use OlajosCs\QueryBuilder\Common\Statements\Common\WhereStatement;
use OlajosCs\QueryBuilder\Contracts\Statements\UpdateStatement as UpdateStatementInterface;


/**
 * Class UpdateStatement
 *
 * Database independent Update statement
 * Contains only the logic to build the model
 */
abstract class UpdateStatement extends WhereStatement implements UpdateStatementInterface
{
    /**
     * @var array The array of the binding
     */
    protected $names = [];


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
     * @inheritDoc
     */
    public function asString()
    {
        $values = [];
        foreach ($this->names as $field => $name) {
            $values[] = $this->normalize($field) . ' = ' . $name;
        }

        $query = sprintf(
            'UPDATE %s SET %s',
            $this->normalize($this->table),
            implode(', ', $values)
        );

        if ($this->whereContainer->has()) {
            $query .= $this->whereContainer->asString();
            $this->parameters += $this->whereContainer->getParameters();
        }

        return $query;
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


    public function normalize($name)
    {
        return $name;
    }
}