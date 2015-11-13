<?php
/*
$path = 'http://treto.ru/img_lb/imola%20ceramica/cento%20per%20cento/per_sito/ambienti/z_Cento%20Per%20Cento-IMOLA%20CERAMICA-1.jpg#xpointer(Texture)';

$info = pathinfo($path, PATHINFO_FILENAME);

echo ($info) . "<br>";

echo urldecode($info);

exit;
*/
/*$noChange = ['str13', 'str12', 'str11', 'str10', 'str9', 'str8', 'str7'];
$change = ['str1', 'str8', 'str9', 'str1', 'str2', 'str10', 'str11', 'str12', 'str1'];

$ff = array_merge($noChange, $change);
print_r($ff);

$ff2 = array_unique($ff);
print_r($ff2);

$ff3 = array_values($ff2);
print_r($ff3);

exit;*/

if (version_compare(phpversion(), '5.4.0', '<') == true)
{
    die(_('Пожалуйста используйте версию PHP не ниже 5.4.'));
}

define('APP_DIR', realpath(__DIR__ . '/../app') . '/');

$config = require(APP_DIR . 'config/Common.php');

if ($config['debug'])
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
else
{
    error_reporting(0);
}

require(APP_DIR . 'core/Autoloader.php');

try
{
    (new RouterComponent($config))->run();
}
catch (Exception $e)
{
    $msg = sprintf(
        _('Произошла ошибка.') . PHP_EOL
        . _('Код: %s.') . PHP_EOL
        . _('Сообщение: %s.') . PHP_EOL
        . _('Файл: %s.') . PHP_EOL
        . _('Строка: %s.') . PHP_EOL
        . _('История: %s') . PHP_EOL,
        $e->getCode(),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    );

    (new LoggerComponent($config))->log($msg);

    if (!$config['debug'])
    {
        // Не будем показывать подробности пользователю если режим не отладочный.
        $msg = _('Ошибка на сервере');
    }

    if (AjaxHelper::whetherAjaxQuery())
    {
        AjaxHelper::sendErrorMessages($msg);
    }
    else
    {
        die($msg);
    }
}

