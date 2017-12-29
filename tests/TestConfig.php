<?php

namespace OlajosCs\QueryBuilder;

/**
 * Class Config
 *
 * Config object transformed from the config array
 */
class TestConfig extends ConnectionConfig
{
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
}
