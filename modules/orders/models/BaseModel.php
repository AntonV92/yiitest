<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;

/**
 * 
 */
class BaseModel extends Model
{
	public function getPagination($query)
    {
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 100]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $count = $countQuery->count();
        return [
            'models' => $models,
            'pages' => $pages,
            'count' => $count,
            'services' => self::getService(),
            'arr' => self::getArray(),
        ];
    }

    public function getService()
    {
        return (new Query())->select(['services.name', 'services.id'])->from('services')->all();
    }

    public function getArray()
    {
        $arr = [];
        foreach (self::getService() as $key => $value) {
            $arr[$value['name']] = (new Query())->select('COUNT(*) AS val')->from('orders')->join('JOIN', 'services', 'orders.service_id = services.id')->where("services.id={$value['id']}")->all()[0]['val'];
        }

        arsort($arr);
        return $arr;

    }

    public function getClass($arg)
    {
        switch ($arg[0]) {
            case 0:
                $class = 'pending';
                break;
            case 1:
                $class = 'inprogress';
                break;
            case 2:
                $class = 'completed';
                break;
            case 3:
                $class = 'canceled';
                break;
            case 4:
                $class = 'error';
                break;
            case 5:
                $class = 'all';
                break;
        }

        return $class;
    }

}