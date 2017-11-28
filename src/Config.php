<?php

namespace OlajosCs\QueryBuilder;

/**
 * Interface Config
 *
 * Defines a config, which is accepted by the ConnectionFactory
 */
interface Config
{
    /**
     * Return the host address
     *
     * @return string
     */
    public function getHost();


    /**
     * Return the usernamne
     *
     * @return string
     */
    public function getUser();


    /**
     * Return the password
     *
     * @return string
     */
    public function getPassword();


    /**
     * Return the database name
     *
     * @return string
     */
    public function getDatabase();


    /**
     * Return the connection options
     *
     * @return array
     */
    public function getOptions();


    /**
     * Return the database type
     *
     * @return string
     */
    public function getDatabaseType();
}