<?php

/**
 * Config for the connections for the test
 */
return [
    'mysql' => [
        'type'     => 'mysql',
        'host'     => 'localhost',
        'database' => 'sample_database',
        'user'     => 'sample_user',
        'password' => 'sample_password',
        'charset'  => 'utf8',
        'options'  => [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        ],
        'class' => \OlajosCs\QueryBuilder\MySQL\Connection::class // Needed only for testing
    ],

    'pgsql' => [
        'type'     => 'pgsql',
        'host'     => 'localhost',
        'database' => 'sample_database',
        'user'     => 'sample_user',
        'password' => 'sample_password',
        'options'  => [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        ],
        'class' => \OlajosCs\QueryBuilder\PostgreSQL\Connection::class // Needed only for testing
    ]
];