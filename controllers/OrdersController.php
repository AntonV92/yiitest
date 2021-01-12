<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    

    public function actionSay($message = 'Привет')
    {
        return $this->render('say', ['message' => $message]);
    }
}
