<?php

/**
 * Логирование.
 *
 * Class LoggerComponent
 */
class LoggerComponent
{
    protected $config;

    public function __contruct($config)
    {
        $this->config = $config;
    }

    public function log($message)
    {
        error_log($message . PHP_EOL . PHP_EOL, $this->config['log']['type'], $this->config['log']['destination']);
    }
}
