<?php

namespace OlajosCs\QueryBuilder;

/**
 * Class DbConfig
 *
 * Abstract config class.
 * Only the setter (constructor) implementation is necessary by extending this class.
 */
abstract class ConnectionConfig implements Config
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $databaseType;

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
