<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;
use app\modules\orders\models\Base;

/**
 * Class IndexModel
 * @package app\modules\orders\models
 */
class Index extends Model
{

    /**
     * @return array
     */
    public function index()
    {
        $query = (new Query())->select([
            'link',
            'first_name',
            'last_name',
            'orders.id',
            'quantity',
            'services.name',
            'created_at',
            'orders.status',
            'orders.mode'])->from('orders')->join(
            'JOIN',
            'users',
            'orders.user_id = users.id')->join(
            'JOIN',
            'services',
            'orders.service_id = services.id')->orderBy(['orders.id' => SORT_DESC]);

        $getpag = (new Base())->getPagination($query);
        $getpag['status'] = 'all';
        $getpag['class'] = 'all';

        return $getpag;
    }
}