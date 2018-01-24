<?php

namespace OlajosCs\QueryBuilder\SQLite;

use OlajosCs\QueryBuilder\PDO;
use OlajosCs\QueryBuilder\TestConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class ConnectionMemoryTest
 *
 *
 */
class ConnectionCreatingTest extends TestCase
{
    /**
     * @var array
     */
    private $configArray;


    /**
     * Constructs a test case with the given name.
     *
     * @param string $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->configArray = require(__DIR__ . '/../../config/config.php');
    }


    public function testCreateMemoryConnection()
    {
        $config = new TestConfig($this->configArray['sqlite_memory']);

        $pdo = new PDO($config);

        $this->assertInstanceOf(\PDO::class, $pdo);
    }


    public function testCreateNotMemoryConnection()
    {
        $config = new TestConfig($this->configArray['sqlite']);

        $pdo = new PDO($config);

        $this->assertInstanceOf(\PDO::class, $pdo);
    }
}