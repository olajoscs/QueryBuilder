<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\ConnectionFactory;
use OlajosCs\QueryBuilder\Contracts\Connection;


/**
 * Class MySQLDatabaseTestCase
 *
 *
 */
abstract class MySQLTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var Connection
     */
    protected $queryBuilderConnection;

    /**
     * @var \PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $dataSet;


    /**
     * Returns the test database connection.
     *
     * @return \PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        if ($this->connection === null) {
            $this->queryBuilderConnection = ConnectionFactory::get('mysql');
            $this->connection             = $this->createDefaultDBConnection($this->queryBuilderConnection->getPdo());
        }

        return $this->connection;
    }


    /**
     * Returns the test dataset.
     *
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        if ($this->dataSet === null) {
            $this->dataSet = include(__DIR__ . '/../arraydataset.php');
        }

        return $this->createArrayDataSet($this->dataSet);
    }


    /**
     * Return a connection based on the config file
     *
     * @return Connection
     */
    protected function getQueryBuilderConnection()
    {
        return $this->queryBuilderConnection;
    }

}