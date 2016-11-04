<?php

namespace OlajosCs\QueryBuilder;

use OlajosCs\QueryBuilder\MySQL\Connection;

/**
 * Class ConnectionFactory
 *
 * Connection factory for the tests
 */
class ConnectionFactory
{
    /**
     * @var array Config of the connections for testing
     */
    private static $config;

    /**
     * @var Connection[] Connection instances
     */
    private static $instances = [];


    /**
     * Return the connection according to the type
     *
     * @param string $type
     *
     * @return Connection
     */
    public static function get($type)
    {
        if (!isset(self::$instances[$type])) {

            if (self::$config === null) {
                self::$config = require_once(__DIR__ . '/../config/config.php');
            }

            $config = self::$config[$type];
            $class = $config['class'];

            $dsn = "{$config['type']}:host={$config['host']};dbname={$config['database']};";

            if (isset($config['charset'])) {
                $dsn .= 'charset=' . $config['charset'];
            }

            self::$instances[$type] = new $class(
                $dsn,
                $config['user'],
                $config['password'],
                $config['options']
            );
        }

        return self::$instances[$type];
    }
}
