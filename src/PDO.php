<?php

namespace OlajosCs\QueryBuilder;

/**
 * Class PDO
 *
 *
 */
class PDO extends \PDO
{
    /**
     * @var string
     */
    private $databaseType;


    /**
     * Create a new PDO instance
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $dsn = sprintf(
            '%s:host=%s;dbname=%s',
            $config->getDatabaseType(),
            $config->getHost(),
            $config->getDatabase()
        );

        parent::__construct($dsn, $config->getUser(), $config->getPassword(), $config->getOptions());

        $this->databaseType = $config->getDatabaseType();
    }


    /**
     * Return the type of the database
     *
     * @return string
     */
    public function getDatabaseType()
    {
        return $this->databaseType;
    }
}