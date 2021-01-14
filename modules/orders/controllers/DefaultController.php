<?php

namespace app\modules\orders\controllers;

use yii\web\Controller;
use yii\db\Query;
use yii\data\Pagination;
//use app\models\Order;


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

    	$query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->orderBy(['orders.id' => SORT_DESC ]);
        $services = (new Query())->select(['services.name','services.id'])->from('services')->all();

        $arr = [];

        foreach ($services as $key => $value) {
            $arr[$value['name']] = (new Query())->select('COUNT(*) AS val')->from('orders')->join('JOIN', 'services', 'orders.service_id = services.id')->where("services.id={$value['id']}")->all()[0]['val'];
        }
        
        arsort($arr);
        
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 100 ]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render('index', [
         'models' => $models,
         'pages' => $pages,
         'count' => $countQuery->count(),
         'class' => 'all',
         'services' => $services,
         'arr' => $arr,
        
     ]);
    }

    public function actionStatus($data)
    {   
        switch ($data) {
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
        }
        $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['orders.status' => $data])->orderBy(['orders.id' => SORT_DESC ]);
        $services = (new Query())->select(['services.name','services.id'])->from('services')->all();

        $arr = [];

        foreach ($services as $key => $value) {
            $arr[$value['name']] = (new Query())->select('COUNT(*) AS val')->from('orders')->join('JOIN', 'services', 'orders.service_id = services.id')->where("services.id={$value['id']}")->all()[0]['val'];
        }

        arsort($arr);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 100 ]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render('index', [
         'models' => $models,
         'pages' => $pages,
         'count' => $countQuery->count(),
         'class' => $class,
         'services' => $services,
         'arr' => $arr,
     ]);
    }

}
