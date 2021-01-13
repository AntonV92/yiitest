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

    	$query = (new \yii\db\Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->orderBy(['orders.id' => SORT_DESC ]);
        // $countQuery = clone $query;
    	$countQuery = clone $query;
    	$pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10 ]);
    	$models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
    return $this->render('index', [
         'models' => $models,
         'pages' => $pages,
    ]);
    }
}
