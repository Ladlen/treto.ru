<?php

class ImagesModel
{
    /**
     * Конфигурация.
     * @var array
     */
    protected $config;

    /**
     * Файл по умолчанию со списком изображений.
     * @var string
     */
    protected $defaultFile = 'data/imageLists/test.txt';

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getImagesParameters($file = false, $EOL = PHP_EOL)
    {
        $reader = new StringReaderComponent($this->config);

        $file = $file ? $file : APP_DIR . $this->defaultFile;
        $reader->addFile($file, $this->config['file']['EOL']);
    }
}