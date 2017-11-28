<?php

namespace OlajosCs\QueryBuilder;

use OlajosCs\QueryBuilder\Exceptions\InvalidDriverException;
use OlajosCs\QueryBuilder\MySQL\Connection as MySqlConnection;
use OlajosCs\QueryBuilder\PostgreSQL\Connection as PostgreSqlConnection;
use PHPUnit\Framework\TestCase;

/**
 * Class ConnectionFactoryTest
 *
 * Tests the ConnectionFactory object
 */
class ConnectionFactoryTest extends TestCase
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var ConnectionFactory
     */
    private $factory;


    /**
     * Test the creation of a mysql connection
     */
    public function test_mysql_connection()
    {
        $configArray = $this->config['mysql'];

        $config = new TestConfig($configArray);
        $pdo = new PDO($config);

        $connection = $this->factory->create($pdo);

        $this->assertInstanceOf(MySqlConnection::class, $connection);
    }


    /**
     * Test the creation of a postgresql connection
     */
    public function test_postgresql_connection()
    {
        $configArray = $this->config['pgsql'];

        $config = new TestConfig($configArray);
        $pdo = new PDO($config);

        $connection = $this->factory->create($pdo);

        $this->assertInstanceOf(PostgreSqlConnection::class, $connection);
    }


    /**
     * Test the creation of an invalid connection
     */
    public function test_invalid_driver()
    {
        $pdo = $this->createMock(PDO::class);
        $pdo->method('getDatabaseType')->willReturn('unknown');

        $this->expectException(InvalidDriverException::class);

        $connection = $this->factory->create($pdo);
    }


    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->config = require(__DIR__ . '/../config/config.php');

        $this->factory = new ConnectionFactory();
    }

}