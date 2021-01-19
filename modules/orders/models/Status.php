<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;
use app\modules\orders\models\Base;

/**
 * Class StatusModel
 * @package app\modules\orders\models
 */
class Status extends Model
{
    /**
     * @param $data
     * @return array
     */
    public function status($data)
    {
        $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['orders.status' => $data])->orderBy(['orders.id' => SORT_DESC]);

        $getpag = (new Base())->getPagination($query);
        $getpag['class'] = (new Base())->getClass($data);
        $getpag['status'] = $data;

        return $getpag;
    }
}