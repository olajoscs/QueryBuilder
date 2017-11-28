<?php

/**
 * Config for the connections for the test
 */

return [
    'mysql' => [
        'type'     => 'mysql',
        'host'     => 'localhost',
        'database' => 'sample_database',
        'user'     => 'travis',
        'password' => '',
        'charset'  => 'utf8',
        'options'  => [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        ],
    ],

    'pgsql' => [
        'type'     => 'pgsql',
        'host'     => 'localhost',
        'database' => 'sample_database',
        'user'     => 'travis',
        'password' => '',
        'options'  => [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        ],
    ],
];