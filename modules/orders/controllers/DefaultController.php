<?php

namespace app\modules\orders\controllers;

use yii\web\Controller;
use app\modules\orders\models\Index;
use app\modules\orders\models\Status;
use app\modules\orders\models\Mode;
use app\modules\orders\models\Service;
use app\modules\orders\models\Search;

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
    public $vars;

    public function actionIndex()
    {

        $vars = (new Index())->index();

        $this->vars = $vars;

        return $this->render('index', $vars);
    }

    /**
     * @param $data
     * @return string
     */
    public function actionStatus($data)
    {

        $vars = (new Status())->status($data);

        $this->vars = $vars;

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
        $vars = (new Mode())->mode($data, $name, $mode);

        $this->vars = $vars;

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

        $vars = (new Service())->service($data, $name, $mode);

        $this->vars = $vars;

        return $this->render('index', $vars);
    }

    /**
     * @return string
     */
    public function actionSearch()
    {

        $vars = (new Search())->search($_GET);

        $this->vars = $vars;

        return $this->render('index', $vars);
    }

}