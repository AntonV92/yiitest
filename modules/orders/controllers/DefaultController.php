<?php

namespace app\modules\orders\controllers;

use yii\web\Controller;
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

    /**
     * @return string
     */
    public function actionSearch()
    {
        $model = new OrdersSearch();
        $vars = $model->search($_GET);

        if ($model->validate()) {
            $this->vars = $vars;
            return $this->render('index', $vars);
        } else {
            return 'Error';
        }
    }
}