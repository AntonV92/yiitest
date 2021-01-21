<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;
use app\modules\orders\models\Base;

/**
 * Class SearchModel
 * @package app\modules\orders\models
 */
class Search extends Model
{
    /**
     * @param $data
     * @return array
     */
    public function search($data)
    {

        $search = [];

        $_GET['search'] = trim($_GET['search']);

        $condition = [];

        switch ($data['search-type']) {
            case Base::SEARCH_ID:
                $condition['orders.id'] = $_GET['search'];
                break;
            case Base::SEARCH_LINK:
                $condition['orders.link'] = $_GET['search'];
                break;
        }

        if ($data['search-type'] != Base::SEARCH_USERNAME) {
            $query = (new Query())->select([
                'link',
                'first_name',
                'last_name',
                'orders.id',
                'quantity',
                'services.name',
                'created_at',
                'orders.status',
                'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join(
                'JOIN',
                'services',
                'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC]);

            $getpag = (new Base())->getPagination($query);
        } else {
            $arr = explode(' ', $_GET['search']);
            if (count($arr) > 1) {
                $first_name = $arr[0];
                $last_name = $arr[1];

                $query = (new Query())->select([
                    'link',
                    'first_name',
                    'last_name',
                    'orders.id',
                    'quantity',
                    'services.name',
                    'created_at',
                    'orders.status',
                    'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join(
                    'JOIN',
                    'services',
                    'orders.service_id = services.id')->where(['users.first_name' => $first_name, 'users.last_name' => $last_name])->orWhere(['users.first_name' => $last_name, 'users.last_name' => $first_name])->orderBy(['orders.id' => SORT_DESC]);

                $getpag = (new Base())->getPagination($query);
            } else {
                $name = $_GET['search'];
                $query = (new Query())->select([
                    'link',
                    'first_name',
                    'last_name',
                    'orders.id',
                    'quantity',
                    'services.name',
                    'created_at',
                    'orders.status',
                    'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join(
                    'JOIN',
                    'services',
                    'orders.service_id = services.id')->where(['users.first_name' => $name])->orWhere(['users.last_name' => $name])->orderBy(['orders.id' => SORT_DESC]);

                $getpag = (new Base())->getPagination($query);
            }

        }

        $search['search-type'] = $data['search-type'];
        $search['search'] = $data['search'];
        $getpag['search'] = $search;
        $getpag['status'] = 'all';

        return $getpag;
    }
}