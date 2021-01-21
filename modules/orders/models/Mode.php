<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;
use app\modules\orders\models\Base;

/**
 * Class ModeModel
 * @package app\modules\orders\models
 */
class Mode extends Model
{
    /**
     * @param $data
     * @param $name
     * @param $mode
     * @param $type
     * @param $search
     * @return array
     */
    public function mode($data, $name, $mode, $type, $search)
    {
        $status = (new Base())->getStatus($data);

        $condition = [];
        $arrsearch['search-type'] = $type;
        $arrsearch['search'] = $search;

        if ($status != Base::ALL_STATUS) {
            $condition['orders.status'] = $status;
        }
        if ($name != 'none') {
            $condition['services.name'] = $name;
        }
        if ($mode != Base::ALL_MODE) {
            $condition['orders.mode'] = $mode;
        }
        if ($type != 'none') {
            if ($type == Base::SEARCH_LINK) {
                $condition['orders.link'] = $search;
            }
        }


        $query = (new Query())->select(
            [
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
        $getpag['search'] = $arrsearch;
        $getpag['status'] = $data;
        $getpag['name'] = $name;
        $getpag['mode'] = $mode;
        $getpag['class'] = (new Base())->getClass($data);

        return $getpag;

    }
}