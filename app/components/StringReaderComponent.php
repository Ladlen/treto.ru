<?php

/**
 * Class StringReaderComponent
 *
 * Отвечает за чтение строк из файлов.
 */
class StringReaderComponent
{
    /**
     * Данные конфигурации.
     * @var array
     */
    protected $config = [];

    /**
     * Список строк. Числовой массив.
     * @var array
     */
    protected $stringList = [];

    /**
     * Последняя возвращенная строка (указатель на номер элемента массива $this->stringList).
     * -1 обозначает что ни одна строка не была возвращена.
     * @var int
     */
    protected $lastString = -1;


    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Добавить файл с новым списком строк.
     *
     * @param string $fileName название файла
     * @param string $EOL перевод строки в файле
     * @throws Exception
     */
    public function addFile($fileName, $EOL)
    {
        $content = file_get_contents($fileName);
        if ($content === false)
        {
            throw new Exception('Не получилось открыть файл "' . $fileName . '"');
        }

        $lines = explode($EOL, $content);
        $lines = array_map('trim', $lines);
        $lines = array_unique($lines);

        // Текущий массив строк $this->stringList должен остаться без изменений.
        $newLines = array_merge($this->stringList, $lines);
        $newLines = array_unique($newLines);
        $this->stringList = array_values($newLines);
    }

    /**
     * Вернуть строку и увеличить счетчик или вернуть false если строки закончились.
     *
     * @return string|bool
     */
    public function getNextString()
    {
        $string = isset($this->stringList[$this->lastString + 1]) ? $this->stringList[++$this->lastString] : false;
        return $string;
    }
}