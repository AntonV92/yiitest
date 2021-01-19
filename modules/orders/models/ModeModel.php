<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;
use app\modules\orders\models\BaseModel;

/**
 *
 */
class ModeModel extends Model
{
    /**
     * @param $data
     * @param $name
     * @param $mode
     * @return array
     */
    public function mode($data, $name, $mode)
    {
        $status = $data;

        $condition = [];

        if ($status < 5) {
            $condition['orders.status'] = $status;
        }

        if ($name != 'none') {
            $condition['services.name'] = $name;
        }
        if ($mode != 7) {
            $condition['orders.mode'] = $mode;
        }


        if (!empty($search)) {
            if ($search['search-type'] == 1) {
                $condition['orders.id'] = $search['search'];
            } elseif ($search['search-type'] == 2) {
                $condition['orders.link'] = $search['search'];
            } else {
                $condition['users.first_name'] = $search['search-type'];
            }
        }


        $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC]);

        $getpag = (new BaseModel())->getPagination($query);
        $getpag['status'] = $data;
        $getpag['name'] = $name;
        $getpag['mode'] = $mode;
        $getpag['class'] = (new BaseModel())->getClass($data);

        return $getpag;
    }
}