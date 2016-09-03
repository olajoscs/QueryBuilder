<?php

namespace OlajosCs\QueryBuilder\MySQL;

abstract class MySQL extends \PHPUnit_Framework_TestCase
{
    /**
     * Return a connection based on the config file
     *
     * @return Connection
     */
    protected function getConnection()
    {
        return ConnectionInstance::get();
    }
}