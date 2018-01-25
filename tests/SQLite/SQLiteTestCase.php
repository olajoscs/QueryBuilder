<?php

namespace OlajosCs\QueryBuilder\SQLite;

use OlajosCs\QueryBuilder\ConnectionFactory;
use OlajosCs\QueryBuilder\Contracts\Connection;
use OlajosCs\QueryBuilder\PDO;
use OlajosCs\QueryBuilder\TestConfig;


/**
 * Class SQLiteDatabaseTestCase
 *
 *
 */
abstract class SQLiteTestCase extends \PHPUnit_Extensions_Database_TestCase
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
            $configArray = require(__DIR__ . '/../../config/config.php');
            $config      = new TestConfig($configArray['sqlite_memory']);

            $connectionFactory = new ConnectionFactory();
            $pdo               = new PDO($config);
            $this->queryBuilderConnection  = $connectionFactory->create($pdo);
            $this->connection  = $this->createDefaultDBConnection($this->queryBuilderConnection->getPdo());
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


    /**
     * Create tables if not exist
     */
    protected function setUp()
    {
        $connection = $this->getConnection()->getConnection();

        $connection->exec(
            'CREATE TABLE IF NOT EXISTS querybuilder_test_languages (id INT PRIMARY KEY, code VARCHAR(2))'
        );

        $connection->exec(
            'CREATE TABLE IF NOT EXISTS querybuilder_tests (id INT PRIMARY KEY, languageId INT, field VARCHAR(6))'
        );

        parent::setUp();
    }

}