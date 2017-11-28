<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;

use OlajosCs\QueryBuilder\Common\Connection as ConnectionCommon;
use OlajosCs\QueryBuilder\PostgreSQL\Statements;

/**
 * Class Connection
 *
 * Defines a PostgreSQL Connection based on PDO
 */
class Connection extends ConnectionCommon
{
    /**
     * @inheritDoc
     */
    protected function createSelectStatement()
    {
        return new Statements\SelectStatement($this);
    }


    /**
     * @inheritDoc
     */
    protected function createDeleteStatement()
    {
        return new Statements\DeleteStatement($this);
    }


    /**
     * @inheritDoc
     */
    protected function createUpdateStatement()
    {
        return new Statements\UpdateStatement($this);
    }


    /**
     * @inheritDoc
     */
    protected function createInsertStatement()
    {
        return new Statements\InsertStatement($this);
    }


    /**
     * @inheritDoc
     */
    public function createRawExpression($expression)
    {
        return new RawExpression($expression);
    }
}
