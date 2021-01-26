<?php

namespace app\modules\orders\controllers;

use yii\web\Controller;
use yii\base\DynamicModel;
use app\modules\orders\models\Index;
use app\modules\orders\models\Status;
use app\modules\orders\models\Mode;
use app\modules\orders\models\Service;
use app\modules\orders\models\Search;
use app\modules\orders\models\OrdersSearch;

/**
 * Class DefaultController
 * @package app\modules\orders\controllers
 */
class DefaultController extends Controller
{
    public $vars;

    public function actionSearch()
    {   
        $model = new OrdersSearch();
        $vars = $model->search($_GET);

        if ($model->validate()) {
            $this->vars = $vars;
            return $this->render('index', $vars);
        } else {
            return 'error';
        }
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}