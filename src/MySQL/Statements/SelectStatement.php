<?php

namespace OlajosCs\QueryBuilder\MySQL\Statements;

use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\Contracts\Statements\SelectStatement as SelectStatementInterface;
use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByContainer as GroupByContainerInterface;
use OlajosCs\QueryBuilder\Contracts\Clauses\JoinContainer as JoinContainerInterface;
use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByContainer as OrderByContainerInterface;
use OlajosCs\QueryBuilder\MySQL\Clauses\GroupByContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\GroupByElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\JoinContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\JoinElement;
use OlajosCs\QueryBuilder\MySQL\Clauses\OrderByContainer;
use OlajosCs\QueryBuilder\MySQL\Clauses\OrderByElement;
use OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement;

/**
 * Class SelectStatement
 *
 * Defines a select statement
 */
class SelectStatement extends WhereStatement  implements SelectStatementInterface
{
    /**
     * @var string[] The name of the fields to get in the query
     */
    protected $fields;

    /**
     * @var int The limit for the query
     */
    protected $limit;

    /**
     * @var int The offset for the query
     */
    protected $offset;

    /**
     * @var JoinContainerInterface
     */
    protected $joinContainer;

    /**
     * @var OrderByContainerInterface
     */
    protected $orderByContainer;

    /**
     * @var GroupByContainerInterface
     */
    protected $groupByContainer;


    /**
     * SelectStatement constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);

        $this->joinContainer    = new JoinContainer();
        $this->orderByContainer = new OrderByContainer();
        $this->groupByContainer = new GroupByContainer();
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
    public function groupBy($field)
    {
        $this->groupByContainer->add(
            new GroupByElement($field)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function limit($limit)
    {
        if (!is_int($limit)) {
            throw new \InvalidArgumentException(sprintf('Limit must be int, %s given', $limit));
        }

        $this->limit = $limit;

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function offset($offset)
    {
        if (!is_int($offset)) {
            throw new \InvalidArgumentException(sprintf('Offset must be int, %s given', $offset));
        }

        $this->offset = $offset;

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function asString()
    {
        $this->parameters = [];

        $query = 'SELECT ' . implode(', ', $this->fields) . ' ';
        $query .= 'FROM ' . $this->table;

        if ($this->joinContainer->has()) {
            $query .= $this->joinContainer->asString();
        }

        $query .= parent::asString();

        if ($this->orderByContainer->has()) {
            $query .= $this->orderByContainer->asString();
        }

        if ($this->groupByContainer->has()) {
            $query .= $this->groupByContainer->asString();
        }

        if ($this->limit !== null) {
            $query .= sprintf(' LIMIT %s', $this->limit);
        }

        if ($this->offset !== null) {
            $query .= sprintf(' OFFSET %s', $this->offset);
        }

        return $query;
    }


    /**
     * @inheritDoc
     */
    public function get()
    {
        return $this->connection->get($this->asString(), $this->parameters);
    }


    /**
     * @inheritDoc
     */
    public function getAsClasses($class, array $constructorParameters = [])
    {
        return $this->connection->getAsClasses($this->asString(), $this->parameters, $class, $constructorParameters);
    }


    /**
     * @inheritDoc
     */
    public function getOne()
    {
        return $this->connection->getOne($this->asString(), $this->parameters);
    }


    /**
     * @inheritDoc
     */
    public function getOneClass($class, array $constructorParameters = [])
    {
        return $this->connection->getOneClass($this->asString(), $this->parameters, $class, $constructorParameters);
    }


    /**
     * @inheritDoc
     */
    public function getOneField($field = null)
    {
        if ($field === null) {
            $field = reset($this->fields);
        }

        return $this->connection->getOneField($this->asString(), $this->parameters, $field);
    }


    /**
     * @inheritDoc
     */
    public function getList($field = null)
    {
        if ($field === null) {
            $field = reset($this->fields);
        }

        return $this->connection->getList($this->asString(), $this->parameters, $field);
    }


    /**
     * @inheritDoc
     */
    public function getWithKey($keyField)
    {
        return $this->connection->getWithKey($this->asString(), $this->parameters, $keyField);
    }


    /**
     * @inheritDoc
     */
    public function getClassesWithKey($class, array $constructorParameters = [], $keyField)
    {
        return $this->connection->getClassesWithKey(
            $this->asString(),
            $this->parameters,
            $class,
            $constructorParameters,
            $keyField
        );
    }


    public function __toString()
    {
        return $this->asString();
    }
}