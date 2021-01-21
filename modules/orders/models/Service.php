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

        $condition = [];
        $arrsearch['search-type'] = $type;
        $arrsearch['search'] = $search;

        if ($data != 'all') {
            $condition['orders.status'] = (new Base())->getStatus($data);;
        }
        if ($name != 'none') {
            $condition['services.name'] = $name;
        }
        if ($mode != Base::ALL_MODE) {
            $condition['orders.mode'] = $mode;
        }
        if ($type == Base::SEARCH_LINK) {
            $condition['orders.link'] = $search;
        }
        $query = (new Query())->select([
            'link',
            'first_name',
            'last_name',
            'orders.id',
            'quantity',
            'services.name',
            'created_at',
            'orders.status',
            'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC]);

        $getpag = (new Base())->getPagination($query);


        $getpag['search'] = $arrsearch;
        $getpag['status'] = $data;
        $getpag['name'] = $name;
        $getpag['mode'] = $mode;

        return $getpag;

    }
}