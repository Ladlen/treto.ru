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
        $this->addCSS('/css/site.css');

        $this->addScript('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', self::JS_POS_HEADER);
        $this->addScript('/js/brickworkImages.js', self::JS_POS_END);
        $this->addScript('/js/uploadImageFile.js', self::JS_POS_END);

        $this->render('index');
    }

    public function action404()
    {
        if (AjaxHelper::whetherAjaxQuery())
        {
            AjaxHelper::sendErrorMessages(_('Ошибка 404'));
        }
        else
        {
            $this->render('404');
        }
    }
}