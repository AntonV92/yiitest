<?php

namespace app\modules\orders\controllers;

use yii\web\Controller;
use yii\db\Query;
use yii\data\Pagination;
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

        $data = $_GET;
        $search = [];

        if ($data['search-type'] == 1) {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['orders.id' => $_GET['search']])->orderBy(['orders.id' => SORT_DESC ]);
        
            $getpag = self::getPagination($query);
        }

        if ($data['search-type'] == 2) {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['orders.link' => $_GET['search']])->orderBy(['orders.id' => SORT_DESC ]);
        
            $getpag = self::getPagination($query);
        }

        if ($data['search-type'] == 3) {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['users.first_name' => $_GET['search']])->orderBy(['orders.id' => SORT_DESC ]);
        
            $getpag = self::getPagination($query);
        }

        $search['search-type'] = $data['search-type'];
        $search['search'] = $data['search'];

        return $this->render('index', [
         'models' => $getpag['models'],
         'pages' => $getpag['pages'],
         'count' => $getpag['count'],
         'status' => '5',
         'class' => 'all',
         'services' => self::getService(),
         'arr' => self::getArray(),
         'search' => $search,
        
     ]);
    }

    private function getPagination($query)
    {
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 100 ]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        $count = $countQuery->count();
        return [
            'models' => $models,
            'pages' => $pages,
            'count' => $count,
        ];
    }

    private function getService()
    {
        return (new Query())->select(['services.name','services.id'])->from('services')->all();
    }

    private function getArray()
    {
       $arr = [];
       foreach (self::getService() as $key => $value) {
            $arr[$value['name']] = (new Query())->select('COUNT(*) AS val')->from('orders')->join('JOIN', 'services', 'orders.service_id = services.id')->where("services.id={$value['id']}")->all()[0]['val'];
        }
        
        arsort($arr);
        return $arr;

    }

    private function getClass($arg)
    {
        switch ($arg[0]) {
            case 0:
            $class = 'pending';
            break;
            case 1:
            $class = 'inprogress';
            break;
            case 2:
            $class = 'completed';
            break;
            case 3:
            $class = 'canceled';
            break;
            case 4:
            $class = 'error';
            break;
            case 5:
            $class = 'all';
            break;
        }

        return $class;
    }


}
