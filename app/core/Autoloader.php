<?php

/**
 * Автозагрузка классов.
 *
 * @param string $className название класса
 * @throws Exception
 */
function __autoload($className)
{
    $matches = array();
    $matchesCount = preg_match_all("/.*([A-Z].*)/", $className, $matches);
    if ($matchesCount == 1)
    {
        // Путь к директории.
        $dirName = APP_DIR . strtolower($matches[1][0]) . 's';
        if (is_dir($dirName))
        {
            $fileName = "$dirName/$className.php";
            if (is_readable($fileName))
            {
                require($fileName);
            }
            else
            {
                throw new Exception(sprintf(_("Не получилось загрузить класс '%s' потому что нет файла '%s'."), $className, $fileName));
            }
        }
        else
        {
            throw new Exception(sprintf(_("Не получилось загрузить класс '%s' потому что нет директории '%s'."), $className, $dirName));
        }
    }
}
