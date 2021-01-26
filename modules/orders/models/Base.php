<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;

/**
 * Class Base
 * @package app\modules\orders\models
 */
class Base extends Model
{
    const PENDING_STATUS = 0;
    const INPROGRESS_STATUS = 1;
    const COMPLETED_STATUS = 2;
    const CANCELED_STATUS = 3;
    const ERROR_STATUS = 4;
    const ALL_STATUS = 5;

    const MANUAL_MODE = 0;
    const AUTO_MODE = 1;
    const ALL_MODE = 7;

    const SEARCH_ID = 1;
    const SEARCH_LINK = 2;
    const SEARCH_USERNAME = 3;

    const NONETYPE = 'none';

    /**
     * @param $query
     * @return array
     */
    public function getPagination($query)
    {
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 100]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $count = $countQuery->count();

        $newm = [];

        foreach ($models as $val) {
            switch ($val['status']) {
                case 0:
                    $val['status'] = 'Pending';
                    break;
                case 1:
                    $val['status'] = 'In Progress';
                    break;
                case 2:
                    $val['status'] = 'Completed';
                    break;
                case 3:
                    $val['status'] = 'Canceled';
                    break;
                case 4:
                    $val['status'] = 'Error';
                    break;
            }

            switch ($val['mode']) {
                case 0:
                    $val['mode'] = 'Manual';
                    break;
                case 1:
                    $val['mode'] = 'Auto';
                    break;
            }

            $newm[] = $val;
        }

        

        return [
            'models' => $newm,
            'pages' => $pages,
            'count' => $count,
            'services' => self::getService(),
            'arr' => self::getArray(),
        ];
    }

    /**
     * @return array
     */
    public function getService()
    {
        return (new Query())->select(['services.name', 'services.id'])->from('services')->all();
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $arr = [];
        foreach (self::getService() as $key => $value) {
            $arr[$value['name']] = (new Query())->select('COUNT(*) AS val')->from('orders')->join('JOIN', 'services', 'orders.service_id = services.id')->where("services.id={$value['id']}")->all()[0]['val'];
        }

        arsort($arr);
        return $arr;

    }


    /**
     * @param $data
     * @return int
     */
    public function getStatus($data)
    {
        switch ($data) {
            case 'pending':
                $status = self::PENDING_STATUS;
                break;
            case 'inprogress':
                $status = self::INPROGRESS_STATUS;
                break;
            case 'completed':
                $status = self::COMPLETED_STATUS;
                break;
            case 'canceled':
                $status = self::CANCELED_STATUS;
                break;
            case 'error':
                $status = self::ERROR_STATUS;
                break;
            case 'all':
                $status = self::ALL_STATUS;
                break;
        }
        return $status;
    }
}