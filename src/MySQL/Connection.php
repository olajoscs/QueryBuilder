<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\Common\Connection as ConnectionCommon;
use OlajosCs\QueryBuilder\MySQL\Statements;

/**
 * Class Connection
 *
 * Defines a Mysql Connection based on PDO
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


    /**
     * Return the type of the database
     *
     * @return string
     */
    protected function getDatabaseType()
    {
        return 'mysql';
    }
}
