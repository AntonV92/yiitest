<?php

namespace app\modules\orders\controllers;

use yii\web\Controller;
use yii\base\DynamicModel;
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
    public $vars;
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $vars = (new Index())->index();

        $this->vars = $vars;

        return $this->render('index', $vars);
    }

    /**
     * @param $data
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionStatus($data)
    {
        $model = DynamicModel::validateData(compact('data'), [
            [['data'], 'string', 'max' => 15],
        ]);
        if ($model->hasErrors()) {
            return 'Error';
        } else {
            $vars = (new Status())->status($data);

            $this->vars = $vars;

            return $this->render('index', $vars);
        }
    }

    /**
     * @param $data
     * @param $name
     * @param $mode
     * @param $type
     * @param $search
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionMode($data, $name, $mode, $type, $search)
    {
        $model = DynamicModel::validateData(compact('data', 'name', 'mode', 'type', 'search'), [
            [['data'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 25],
            [['mode'], 'integer', 'max' => 7],
            [['search'], 'string', 'max' => 125],
            [['type'], 'string', 'max' => 4]

        ]);
        if ($model->hasErrors()) {
            return 'Error';
        } else {
            $vars = (new Mode())->mode($data, $name, $mode, $type, $search);

            $this->vars = $vars;

            return $this->render('index', $vars);
        }
    }

    /**
     * @param $data
     * @param $name
     * @param $mode
     * @param $type
     * @param $search
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionService($data, $name, $mode, $type, $search)
    {
        $model = DynamicModel::validateData(compact('data', 'name', 'mode', 'type', 'search'), [
            [['data'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 25],
            [['mode'], 'integer', 'max' => 7],
            [['search'], 'string', 'max' => 125],
            [['type'], 'string', 'max' => 4]
        ]);
        if ($model->hasErrors()) {
            return 'Error';
        } else {
            $vars = (new Service())->service($data, $name, $mode, $type, $search);

            $this->vars = $vars;

            return $this->render('index', $vars);
        }
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSearch()
    {
        $search = $_GET['search'];
        $search_type = $_GET['search-type'];

        $model = DynamicModel::validateData(compact('search', 'search_type'), [
            [['search_type'], 'integer', 'max' => 3],
            [['search'], 'string', 'max' => 125],
        ]);
        if ($model->hasErrors()) {
            return 'Error';
        } else {
            $vars = (new Search())->search($_GET);

            $this->vars = $vars;

            return $this->render('index', $vars);
        }
    }
}