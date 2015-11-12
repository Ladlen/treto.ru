<?php

class SiteController extends ControllerController
{
    /**
     * Заголовок страницы по умолчанию.
     *
     * @var string
     */
    public $title;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->title = _('Изображения');
    }

    public function actionIndex()
    {
        #$this->render($this->getViewsPath() . 'index.php', ['model' => $model->rows, 'cities' => $cities->rows]);
        self::addCSS('/css/site.css');
        $this->render('index');
    }


}