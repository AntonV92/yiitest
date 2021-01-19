<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;
use app\modules\orders\models\BaseModel;

/**
 * 
 */
class SearchModel extends Model
{
	public function search($data)
    {
        $search = [];

        if ($data['search-type'] == 1) {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['orders.id' => $_GET['search']])->orderBy(['orders.id' => SORT_DESC]);

            $getpag = (new BaseModel())->getPagination($query);
        }

        if ($data['search-type'] == 2) {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['orders.link' => $_GET['search']])->orderBy(['orders.id' => SORT_DESC]);

            $getpag = (new BaseModel())->getPagination($query);
        }

        if ($data['search-type'] == 3) {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['users.first_name' => $_GET['search']])->orderBy(['orders.id' => SORT_DESC]);

            $getpag = (new BaseModel())->getPagination($query);
        }

        $search['search-type'] = $data['search-type'];
        $search['search'] = $data['search'];
        $getpag['search'] = $search;
        $getpag['class'] = 'all';
        $getpag['status'] = 5;

        return $getpag;
    }
}