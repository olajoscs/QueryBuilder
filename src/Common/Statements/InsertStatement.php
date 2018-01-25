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
     * @var array[] The binding parameters for the query. 2 dimensional array, as multiple rows can be added as well.
     */
    protected $parameters = [];

    /**
     * @var array[] The array of the binding. 2 dimensional array, as multiple rows can be added as well.
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

        $valueList = !is_array(reset($values)) ? [$values] : $values;

        foreach ($valueList as $key => $values) {
            $this->addValues($key, $values);
        }

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function asString()
    {
        $values = $this->generateValues();

        $query = sprintf(
            'INSERT INTO %s (%s) VALUES %s',
            $this->table,
            implode(', ', array_keys(reset($this->names))),
            implode(', ', $values)
        );

        return $query;
    }


    /**
     * Gather the array of the bracketed rows into the insert statement
     *
     * @return array
     */
    protected function generateValues()
    {
        // Gathering the array of the bracketed rows into the insert statement
        $values = array_map(
            function($values) {
                return '(' . implode(', ', $values) . ')';
            },
            $this->names
        );

        return $values;
    }


    private function addValues($arrayKey, array $values)
    {
        foreach ($values as $field => $value) {
            $this->addValue($field, $value, $arrayKey);
        }
    }


    /**
     * Add a value to the update statement.
     * It is added as a placeholder to the values, and the real value is added to the binding list
     *
     * @param string     $field
     * @param mixed      $value
     * @param int|string $arrayKey
     *
     * @return void
     */
    private function addValue($field, $value, $arrayKey)
    {
        $name = ':'. $arrayKey . $field;

        $this->names[$arrayKey][$field]      = $name;
        $this->parameters[$arrayKey][$field] = $value;
    }
}