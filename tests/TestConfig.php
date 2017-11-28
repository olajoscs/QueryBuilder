<?php

namespace OlajosCs\QueryBuilder;

/**
 * Class Config
 *
 * Config object transformed from the config array
 */
class TestConfig implements Config
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $databaseType;

    /**
     * @var array
     */
    private $options = [];


    /**
     * Create a new connfig object from the config array
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->host         = $config['host'];
        $this->user         = $config['user'];
        $this->password     = $config['password'];
        $this->database     = $config['database'];
        $this->databaseType = $config['type'];

        if (!empty($config['options'])) {
            $this->options = $config['options'];
        }
    }


    /**
     * Return the host address
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }


    /**
     * Return the usernamne
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Return the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Return the database name
     *
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }


    /**
     * Return the connection options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * Return the database type
     *
     * @return string
     */
    public function getDatabaseType()
    {
        return $this->databaseType;
    }
}