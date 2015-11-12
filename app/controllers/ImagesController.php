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

        $model->getImagesParameters($file);

        $res = ['success' => false, "messages" => ['one 1', 'some 2']];
        echo json_encode($res);
        exit;
    }

    public function actionUpdate()
    {
        $ret = ['success' => false];

        $_REQUEST['value'] = trim($_REQUEST['value']);

        $model = new User();
        $win1251Value = mb_convert_encoding($_REQUEST['value'], DOCUMENT_ENCODING, 'UTF-8');

        if ($errors = $model->verifyUserInfo([$_REQUEST['name'] => $win1251Value]))
        {
            $ret = ['success' => false, 'messages' => $errors];
        }
        else
        {
            if ($model->updateUser($_REQUEST['id'], $_REQUEST['name'], $win1251Value))
            {
                $ret = ['success' => true, 'value' => $_REQUEST['value']];
            }
        }

        echo prepareJSON::jsonEncode($ret);
        exit;
    }

}