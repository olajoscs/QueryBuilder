<?php

namespace OlajosCs\QueryBuilder\Common\Statements;

use OlajosCs\QueryBuilder\Common\Statements\Common\WhereStatement;
use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByContainer;
use OlajosCs\QueryBuilder\Contracts\Clauses\GroupByElement;
use OlajosCs\QueryBuilder\Contracts\Clauses\JoinContainer;
use OlajosCs\QueryBuilder\Contracts\Clauses\JoinElement;
use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByContainer;
use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByElement;
use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\Contracts\Statements\SelectStatement as SelectStatementInterface;


/**
 * Class SelectStatement
 *
 * Database independent SelectStatement
 * Contains only the logic to build the model
 */
abstract class SelectStatement extends WhereStatement implements SelectStatementInterface
{
    /**
     * @var array The name of the fields to get in the query
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
     * @var JoinContainer
     */
    protected $joinContainer;

    /**
     * @var OrderByContainer
     */
    protected $orderByContainer;

    /**
     * @var GroupByContainer
     */
    protected $groupByContainer;


    /**
     * Create and return a new JoinContainer object
     *
     * @return JoinContainer
     */
    abstract protected function createJoinContainer();


    /**
     * Create and return a new GroupByContainer object
     *
     * @return GroupByContainer
     */
    abstract protected function createGroupByContainer();


    /**
     * Create and return a new OrderByContainer
     *
     * @return OrderByContainer
     */
    abstract protected function createOrderByContainer();


    /**
     * Create and return a JoinElement
     *
     * @param string $tableLeft
     * @param string $fieldLeft
     * @param string $operator
     * @param string $tableRight
     * @param string $fieldRight
     * @param string $type
     *
     * @return JoinElement
     */
    abstract protected function createJoinElement($tableLeft, $fieldLeft, $operator, $tableRight, $fieldRight, $type);


    /**
     * Create and return an OrderByElement
     *
     * @param string $field         Name of the field to order by
     * @param string $order         Type of the order (one of the OrderByElement::ORDER_ constants)
     * @param string $nullsPosition Position of the null values (one of the OrderByElement::NULLS_ constans)
     *
     * @return OrderByElement
     */
    abstract protected function createOrderByElement($field, $order = null, $nullsPosition = null);


    /**
     * Create and return a GroupByElement
     *
     * @param string $field
     *
     * @return GroupByElement
     */
    abstract protected function createGroupByElement($field);


    /**
     * SelectStatement constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);

        $this->joinContainer    = $this->createJoinContainer();
        $this->orderByContainer = $this->createOrderByContainer();
        $this->groupByContainer = $this->createGroupByContainer();
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
            $this->createJoinElement(
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
     * @inheritDoc
     */
    public function joinLeft($tableRight, $fieldRight, $operator, $fieldLeft, $tableLeft = null)
    {
        $this->joinContainer->add(
            $this->createJoinElement(
                $tableLeft ?: $this->table,
                $fieldLeft,
                $operator,
                $tableRight,
                $fieldRight,
                JoinElement::TYPE_LEFT
            )
        );

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function joinRight($tableRight, $fieldRight, $operator, $fieldLeft, $tableLeft = null)
    {
        $this->joinContainer->add(
            $this->createJoinElement(
                $tableLeft ?: $this->table,
                $fieldLeft,
                $operator,
                $tableRight,
                $fieldRight,
                JoinElement::TYPE_RIGHT
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
            $this->createOrderByElement($field, $order, $nullsPosition)
        );

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function groupBy($field)
    {
        $this->groupByContainer->add(
            $this->createGroupByElement($field)
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


    /**
     * Return the select statement as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->asString();
    }
}