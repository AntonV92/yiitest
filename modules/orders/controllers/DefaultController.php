<?php

namespace app\modules\orders\controllers;

use yii\web\Controller;
use app\modules\orders\models\IndexModel;
use app\modules\orders\models\StatusModel;
use app\modules\orders\models\ModeModel;
use app\modules\orders\models\ServiceModel;
use app\modules\orders\models\SearchModel;

/**
 * Class DefaultController
 * @package app\modules\orders\controllers
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $vars = (new IndexModel())->index();

        return $this->render('index', $vars);
    }

    /**
     * @param $data
     * @return string
     */
    public function actionStatus($data)
    {

        $vars = (new StatusModel())->status($data);

        return $this->render('index', $vars);
    }

    /**
     * @param $data
     * @param $name
     * @param $mode
     * @return string
     */
    public function actionMode($data, $name, $mode)
    {
        $vars = (new ModeModel())->mode($data, $name, $mode);

        return $this->render('index', $vars);

    }

    /**
     * @param false $data
     * @param $name
     * @param $mode
     * @return string
     */
    public function actionService($data = false, $name, $mode)
    {

        $vars = (new ServiceModel())->service($data, $name, $mode);

        return $this->render('index', $vars);
    }

    /**
     * @return string
     */
    public function actionSearch()
    {

        $vars = (new SearchModel())->search($_GET);

        return $this->render('index', $vars);
    }

}