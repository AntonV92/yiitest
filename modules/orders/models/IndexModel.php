<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;
use app\modules\orders\models\BaseModel;

/**
 * Class IndexModel
 * @package app\modules\orders\models
 */
class IndexModel extends Model
{

    /**
     * @return array
     */
    public function index()
    {
        $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->orderBy(['orders.id' => SORT_DESC]);

        $getpag = (new BaseModel())->getPagination($query);
        $getpag['status'] = 5;
        $getpag['class'] = 'all';

        return $getpag;
    }
}