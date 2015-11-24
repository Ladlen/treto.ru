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

    /**
     * Добавить изображения из файла.
     *
     * @param string $path путь к файлу
     * @param string $EOL разделитель строк в файле
     */
    public function addFile($path, $EOL)
    {
        $readerSess = new StringReaderSessionHashComponent($this->config, $this->elementSessionKey);
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

        $readerSess = new StringReaderSessionHashComponent($this->config, $this->elementSessionKey);
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

    public function showImageByHash($hash)
    {
        $readerSess = new StringReaderSessionHashComponent($this->config, $this->elementSessionKey);
        $imagePath = $readerSess->getStringByHash($hash);

        $info = getimagesize($imagePath);

        print_r($info);
        exit;

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

        // TODO: сделать что-то с ini_set
        ini_set('display_errors', 0);
        $info = getimagesize($imagePath);
        ini_set('display_errors', 1);
        if ($info)
        {
            $retInfo['width'] = $info[0];
            $retInfo['height'] = $info[1];
            $retInfo['mime'] = $info['mime'];
            $retInfo['uid'] = md5($imagePath);
        }
        else
        {
            (new LoggerComponent($this->config))->log("Файл $imagePath не найден.");
        }

        return $retInfo;
    }
}