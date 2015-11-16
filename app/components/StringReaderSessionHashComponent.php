<?php

class StringReaderSessionHashComponent
{
    protected $config;

    /**
     * @var string сессионный ключ текущего элемента
     */
    protected $elementSessionKey;

    protected $reader;

    public function __construct($config, $elementSessionKey)
    {
        $this->config = $config;
        $this->elementSessionKey = $elementSessionKey;

        session_start();
        if (!isset($_SESSION[$this->elementSessionKey]))
        {
            $_SESSION[$this->elementSessionKey] = [];
        }

        if (isset($_SESSION[$this->elementSessionKey]['reader']))
        {
            $this->reader = unserialize($_SESSION[$this->elementSessionKey]['reader']);
        }
        else
        {
            $this->reader = new StringReaderHashComponent($this->config);
        }
    }

    public function getNextString()
    {
        return $this->reader->getNextString();
    }

    public function addFile($fileName, $EOL)
    {
        return $this->reader->addFile($fileName, $EOL);
    }

    public function __destruct()
    {
        $_SESSION[$this->elementSessionKey]['reader'] = serialize($this->reader);
    }
}