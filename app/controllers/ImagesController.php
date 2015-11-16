<?php

class ImagesController extends ControllerController
{
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function actionIndex()
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

    }

}