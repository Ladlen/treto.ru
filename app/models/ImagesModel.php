<?php

class ImagesModel
{
    /**
     * @var array конфигурация
     */
    protected $config;

    /**
     * @var string сессионный ключ текущей модели
     */
    protected $elementSessionKey;

    /**
     * @param array $config конфигурация
     * @param string $elementSessionKey сессионный ключ этой модели
     */
    public function __construct($config, $elementSessionKey)
    {
        $this->config = $config;
        $this->elementSessionKey = $elementSessionKey;
    }

    /*protected function getReader()
    {
        $reader = false;

        session_start();
        if (!isset($_SESSION[$this->elementSessionKey]))
        {
            $_SESSION[$this->elementSessionKey] = [];
        }

        if (isset($_SESSION[$this->elementSessionKey]['reader']))
        {
            $reader = unserialize($_SESSION[$this->elementSessionKey]['reader']);
        }
        else
        {
            $reader = new StringReaderComponent($this->config);
        }

        return $reader;
    }*/

    /**
     * Добавить изображения из файла.
     *
     * @param string $path путь к файлу
     * @param string $elementSessionKey сессионный ключ текущего элемента
     * @param string $EOL разделитель строк в файле
     * @throws Exception
     */
    public function addFile($path, $EOL)
    {
        $readerSess = new StringReaderSessionComponent($this->config, $this->elementSessionKey);
        $readerSess->addFile($path, $EOL);
    }

    /**
     * Вернуть параметры всех изображений в файле $file.
     *
     * @param bool|false $file путь к файлу
     * @param string $EOL перевод строки, используемый в файле $file
     * @return array
     * @throws Exception
     */
    public function getImagesParameters($count)
    {
        $clientImagesParameters = [];

        $readerSess = new StringReaderSessionComponent($this->config);
        while ($imagePath = $readerSess->getNextString())
        {
            if ($info = $this->getImageInfo($imagePath))
            {
                $clientImagesParameters[] = $info;
            }
        }

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