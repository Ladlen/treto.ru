<?php

/**
 * Class RouterHelper
 *
 * Роутинг.
 */
class RouterComponent
{
    /**
     * части URL страницы по умолчанию.
     * @var array
     */
    protected $pageDefault = ['controller' => 'site', 'action' => 'index'];

    /**
     * части URL пустой страницы.
     * @var array
     */
    protected $page404 = ['controller' => 'site', 'action' => '404'];

    /**
     * Части URL.
     * @var array|null
     */
    protected $parts;

    /**
     * Конфигурация.
     * @var array
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Создать название контроллера.
     *
     * @param string $controllerPart части URL контроллера
     * @return string название контроллера
     */
    protected function getControllerName($controllerPart)
    {
        $controller = $controllerPart ? $controllerPart : $this->pageDefault['controller'];
        $controller = ucfirst($controllerPart) . 'Controller';
        return $controller;
    }

    /**
     * Создать название действия.
     *
     * @param string $actionName часть URL действия
     * @return string название функции действия
     */
    protected function getActionName($actionName)
    {
        $action = $actionName ? $actionName : $this->pageDefault['action'];
        $action = 'action' . ucfirst($actionName);
        return $action;
    }

    /**
     * Проанализировать URL, затем исполнить действие контроллера.
     */
    public function run()
    {
        $controllerName = $this->getControllerName($this->pageDefault['controller']);
        $actionName = $this->getActionName($this->pageDefault['action']);

        if (isset($_REQUEST['route']))
        {
            $route = trim($_REQUEST['route'], '/\\');
            $this->parts = explode('/', $route);

            if (isset($this->parts[0]))
            {
                $controllerName = $this->getControllerName($this->parts[0]);
            }
            if (isset($this->parts[1]))
            {
                $actionName = $this->getActionName($this->parts[1]);
            }
        }

        if (!is_readable(APP_DIR . "controllers/$controllerName.php"))
        {
            // Нет такой страницы.
            $controllerName = $this->getControllerName($this->page404['controller']);
            $actionName = $this->getActionName($this->page404['action']);
        }
        elseif (!is_callable(array($controllerName, $actionName)))
        {
            // Нет такого действия в контроллере.
            $actionName = $this->getActionName('index');
        }

        (new $controllerName($this->config))->$actionName($this->parts);
    }
}
