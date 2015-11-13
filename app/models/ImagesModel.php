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

    /**
     * @param array $config
     * @param string $elementSessionName
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Вернуть параметры всех изображений в файле $file.
     *
     * @param string $elementSessionID уникальный ID элемента (для сессии)
     * @param bool|false $file путь к файлу
     * @param string $EOL перевод строки, используемый в файле $file
     * @return array
     * @throws Exception
     */
    public function getImagesParameters($elementSessionID, $file = false, $EOL = PHP_EOL)
    {
        $clientImagesParameters = [];

        $reader = false;

        session_start();
        if (isset($_SESSION[$elementSessionID]) && isset($_SESSION[$elementSessionID]['reader']))
        {
            $reader = unserialize($_SESSION[$elementSessionID]['reader']);
        }
        else
        {
            $reader = new StringReaderComponent($this->config);
        }

        $file = $file ? $file : APP_DIR . $this->defaultFile;
        $reader->addFile($file, $this->config['brickworkImages']['file']['EOL']);

        while ($string = $reader->getNextString())
        {
            if ($info = $this->getImageInfo($string))
            {
                $clientImagesParameters[] = $info;
            }
        }

        if (!isset($_SESSION[$elementSessionID]))
        {
            $_SESSION[$elementSessionID] = [];
        }
        $_SESSION[$elementSessionID]['reader'] = serialize($reader);

        return $clientImagesParameters;
    }

    /**
     * Вернуть информацию об изображении (ширина, высота, название) или пустой масссив в случае неудачи.
     *
     * @param string $imagePath путь к изображению
     * @return array
     */
    protected function getImageInfo($imagePath)
    {
        $retInfo = [];

        $info = getimagesize($imagePath);
        if ($info)
        {
            $retInfo['width'] = $info[0];
            $retInfo['height'] = $info[1];
            $retInfo['uid'] = md5($imagePath);
            #$retInfo['name'] = urldecode(pathinfo($imagePath, PATHINFO_FILENAME));
            #$retInfo['path'] = ;
        }
        else
        {
            (new LoggerComponent($this->config))->log("Файл $imagePath не найден.");
        }

        return $retInfo;
    }
}