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
        'options'  => [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
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
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ],
    ],

    'sqlite' => [
        'type'     => 'sqlite',
        'host'     => 'localhost',
        'database' => 'querybuilder',
        'user'     => 'travis',
        'password' => '',
        'options'  => [
            \PDO::ATTR_CASE => \PDO::CASE_NATURAL
        ],
    ],
];
