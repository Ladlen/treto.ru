<?php

class ImagesController extends ControllerController
{
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function actionIndex()
    {
        $args = func_get_args();
        session_start();
        $t = 1;
        #$this->renderPartial('index');
    }

    public function actionInitHtml()
    {
        self::addScript('/js/brickworkImages.js', self::JS_POS_END);
        $this->renderPartial('index');
    }

    public function actionRetrieve()
    {
        $model = new ImagesModel($this->config, $this->config['brickworkImages']['elementSessionKey']);
        $imagesParameters = $model->getImagesParameters($_REQUEST['amount']);
        AjaxHelper::sendResult($imagesParameters);
    }

    public function actionAddFile()
    {
        $model = new ImagesModel($this->config, $this->config['brickworkImages']['elementSessionKey']);
        $model->addFile($_FILES['file']['tmp_name'], $this->config['brickworkImages']['file']['EOL']);
        AjaxHelper::sendResult('file added');
    }

    public function actionShowImage()
    {
        header('Content-Type: image/png');
        $im = @imagecreatetruecolor(120, 20)
        or die('Невозможно инициализировать GD поток');
        $text_color = imagecolorallocate($im, 233, 14, 91);
        imagestring($im, 1, 5, 5,  'Простая Текстовая Строка', $text_color);
        imagepng($im);
        imagedestroy($im);
    }

}