<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;
use app\modules\orders\models\Base;

/**
 * Class ServiceModel
 * @package app\modules\orders\models
 */
class Service extends Model
{
    /**
     * @param $data
     * @param $name
     * @param $mode
     * @param $type
     * @param $search
     * @return array
     */
    public function service($data, $name, $mode, $type, $search)
    {
        $status = $data;

        $condition = [];
        $arrsearch['search-type'] = $type;
        $arrsearch['search'] = $search;

        $condition['services.name'] = $name;

        if ($type != 'none') {
            if ($type == 2) {
                $condition['orders.link'] = $search;
            }
            if ($type == 3) {
                $condition['users.first_name'] = $search;
            }  
        }

        if ($mode != 7) {
            $condition['orders.mode'] = $mode;
        }
        if ($status < 5) {
            $condition['orders.status'] = $status;

            $query = (new Query())->select(['link', 'first_name', 'last_name' , 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC]);

            $getpag = (new Base())->getPagination($query);

        } else {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC]);

            $getpag = (new Base())->getPagination($query);
        }

        $getpag['search'] = $arrsearch;
        $getpag['status'] = $data;
        $getpag['name'] = $name;
        $getpag['mode'] = $mode;
        $getpag['class'] = (new Base())->getClass($data);

        return $getpag;

    }
}