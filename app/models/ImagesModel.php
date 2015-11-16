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
     * @param string $EOL разделитель строк в файле
     */
    public function addFile($path, $EOL)
    {
        $readerSess = new StringReaderSessionComponent($this->config, $this->elementSessionKey);
        $readerSess->addFile($path, $EOL);
    }

    /**
     * Вернуть параметры изображений.
     *
     * @param int $count количество изображений
     * @return array
     */
    public function getImagesParameters($count)
    {
        $clientImagesParameters = [];

        $readerSess = new StringReaderSessionComponent($this->config, $this->elementSessionKey);
        /*while (($count-- > 0) && ($imagePath = $readerSess->getNextString()))
        {
            if ($info = $this->getImageInfo($imagePath))
            {
                $clientImagesParameters[] = $info;
            }
        }*/
        while ($count > 0)
        {
            if (($imagePath = $readerSess->getNextString()) !== false)
            {
                if ($info = $this->getImageInfo($imagePath))
                {
                    $clientImagesParameters[] = $info;
                    --$count;
                }
            }
            else
            {
                break;
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

        ini_set('display_errors', 0);
        $info = getimagesize($imagePath);
        ini_set('display_errors', 1);
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