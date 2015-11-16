<?php

/**
 * Родительский контроллер.
 *
 * Class ControllerController
 */
abstract class ControllerController
{
    /**
     * Заголовок страницы по умолчанию.
     * @var string
     */
    protected $title = '';

    /**
     * JS скрипт распологается в заголовке страницы.
     */
    const JS_POS_HEADER = 'header';

    /**
     * JS скрипт распологается в конце страницы.
     */
    const JS_POS_END = 'end';

    /**
     * Список путей к скриптам.
     * @var array
     */
    private static $scripts = ['header' => [], 'end' => []];

    /**
     * Список путей к CSS.
     * @var array
     */
    private static $css = [];

    /**
     * Данные конфигурации.
     * @var array
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Добавить скрипт.
     *
     * @param string $path путь к скрипту
     * @param int $location где распологается скрипт
     * @param bool|false $realpath нужно ли к $path применить функцию realpath() (для локальных путей)
     */
    public static function addScript($path, $location, $realpath = false)
    {
        $path = trim($path);
        $path = $realpath ? realpath($path) : $path;
        if (!in_array($path, self::$scripts))
        {
            self::$scripts[$location][] = $path;
        }
    }

    /**
     * Добавить стили CSS.
     *
     * @param string $path путь к файлу стилей
     * @param bool|false $realpath нужно ли к $path применить функцию realpath() (для локальных путей)
     */
    public static function addCSS($path, $realpath = false)
    {
        $path = trim($path);
        $path = $realpath ? realpath($path) : $path;
        if (!in_array($path, self::$css))
        {
            self::$css[] = $path;
        }
    }

    /**
     * Рендеринг PHP файла.
     *
     * @param string $file название файла
     * @param array $params переменные для файла $file
     * @return string сгенерированное содержимое
     */
    protected function renderPhpFile($file, $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require($file);

        return ob_get_clean();
    }

    /**
     * Сгенерировать основной вью и отправить в главный шаблон.
     *
     * @param string $view название вью
     * @param array $params переменные для генерируемого файла
     */
    protected function render($view, $params = [])
    {
        $file = $this->getViewsPath() . "$view.php";

        $content = $this->renderPhpFile($file, $params);

        $cssScripts = $this->getCssScriptsCode();
        $jsScripts = $this->getJsScriptsCode();

        require(APP_DIR . 'views/layouts/main.php');
    }

    protected function renderPartial($view, $params = [])
    {
        $file = $this->getViewsPath() . "$view.php";
        extract($params, EXTR_OVERWRITE);
        require($file);
    }

    private function getJsScriptsCode()
    {
        $jsCode = ['header' => '', 'end' => ''];
        foreach (self::$scripts['header'] as $path)
        {
            $jsCode['header'] .= "<script type='text/javascript' src='$path'></script>\n";
        }
        foreach (self::$scripts['end'] as $path)
        {
            $jsCode['end'] .= "<script type='text/javascript' src='$path'></script>\n";
        }
        return $jsCode;
    }

    private function getCssScriptsCode()
    {
        $cssCode = '';
        foreach (self::$css as $path)
        {
            $cssCode .= "<link rel='stylesheet' type='text/css' href='$path'/>\n";
        }
        return $cssCode;
    }

    protected function getViewsPath()
    {
        $className = get_class($this);
        $folderName = substr($className, 0, -strlen('Controller'));
        return APP_DIR . "views/$folderName/";
    }

    /**
     * Получить переменную отформатированную для кода html.
     *
     * @param string $name название переменной
     * @return string
     * @throws Exception
     */
    public function htmlVar($name)
    {
        if (isset($this->$name))
        {
            return htmlspecialchars($this->$name, ENT_QUOTES, 'UTF-8');
        }
        else
        {
            throw new Exception(sprintf(_("Переменная %s отсутствует.", $name)));
        }
    }

    public abstract function actionIndex();
}