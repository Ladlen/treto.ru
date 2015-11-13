<?php

class ImagesController extends ControllerController
{
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function actionIndex()
    {
        self::addScript('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js');
        $this->renderPartial('index');
    }

    public function actionRetrieve()
    {
        $file = isset($_REQUEST['file']) ? trim($_REQUEST['file']) : false;
        $model = new ImagesModel($this->config);
        $imagesParameters = $model->getImagesParameters('commonPanel', $file);
        AjaxHelper::sendResult($imagesParameters);
    }

    public function actionAddFile()
    {
        die('sdfdsffd');
    }

}