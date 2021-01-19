<?php

namespace app\modules\orders\controllers;

use yii\web\Controller;
use app\modules\orders\Model;

/**
 * Default controller for the `orders` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {	
 
        $vars = (new Model())->index();
        
        return $this->render('index', $vars);
    }

    public function actionStatus($data)
    {   
 
        $vars = (new Model())->status($data);
        
        return $this->render('index', $vars);
    }

    public function actionMode($data, $name, $mode)
    {
        $vars = (new Model())->mode($data, $name, $mode);
        
        return $this->render('index', $vars);
       
    }

    public function actionService($data = false, $name, $mode)
    {

        $vars = (new Model())->service($data, $name, $mode);

        return $this->render('index', $vars);
    }

    public function actionSearch()
    {   

        $vars = (new Model())->search($_GET);

        return $this->render('index', $vars);
    }

}