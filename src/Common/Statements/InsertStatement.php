<?php

namespace OlajosCs\QueryBuilder\Common\Statements;

use OlajosCs\QueryBuilder\Common\Statements\Common\Statement;
use OlajosCs\QueryBuilder\Contracts\Statements\InsertStatement as InsertStatementInterface;

/**
 * Class InsertStatement
 *
 * The database independent InsertStatmeent model
 * Contains only the logic to build the model
 */
abstract class InsertStatement extends Statement implements InsertStatementInterface
{
    /**
     * @var array The binding parameters for the query
     */
    protected $parameters = [];

    /**
     * @var array The array of the binding
     */
    protected $names = [];


    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->connection->execute($this->asString(), $this->parameters);
    }


    /**
     * @inheritdoc
     */
    public function into($table)
    {
        $this->table = $table;

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function values(array $values)
    {
        $this->names      = [];
        $this->parameters = [];

        foreach ($values as $field => $value) {
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
}