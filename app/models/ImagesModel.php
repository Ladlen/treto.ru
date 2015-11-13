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

    /**
     * Вернуть параметры всех изображений в файле $file.
     *
     * @param bool|false $file путь к файлу
     * @param string $EOL перевод строки, используемый в файле $file
     * @return array
     * @throws Exception
     */
    public function getImagesParameters($file = false, $EOL = PHP_EOL)
    {
        $imagesParameters = [];

        $reader = new StringReaderComponent($this->config);

        $file = $file ? $file : APP_DIR . $this->defaultFile;
        $reader->addFile($file, $this->config['brickworkImages']['file']['EOL']);

        while ($string = $reader->getNextString())
        {
            if ($info = $this->getImageInfo($string))
            {
                $imagesParameters[] = $info;
            }
        }

        return $imagesParameters;
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
            $retInfo['name'] = urldecode(pathinfo($imagePath, PATHINFO_FILENAME));
        }

        return $retInfo;
    }
}