<?php

namespace OlajosCs\QueryBuilder\MySQL;

class ConnectionInstance
{
    private static $instance;


    public static function get()
    {
        if (self::$instance === null) {

            $config = require_once(__DIR__ . '/../../config/config.php');

            self::$instance = new Connection(
                $config['type'] . ':host=' . $config['host'] . ';dbname=' . $config['database'] . ';charset=' . $config['charset'],
                $config['user'],
                $config['password'],
                $config['options']
            );
        }

        return self::$instance;
    }
}
