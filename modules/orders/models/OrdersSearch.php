<?php

namespace app\modules\orders\models;

use app\modules\orders\models\Base;
use yii\db\Query;
use yii\data\Pagination;
use yii\base\Model;
use yii\base\DynamicModel;


/**
 * Class OrdersSearch
 * @package app\modules\orders\models
 */
class OrdersSearch extends Model
{
    public $data;
    public $name;
    public $type;
    public $search;
    public $mode;

    /**
     * @return array
     */
    public function search()
    {
        if (empty($_GET)) {
            return self::index();
        } else {
            self::setParam($_GET);

            $data = $this->data;
            $name = $this->name;
            $mode = $this->mode;
            $type = $this->type;
            $search = $this->search;
            $arrsearch['search-type'] = $type;
            $arrsearch['search'] = $search;

            if ($data == Base::ALL_STATUS) {
                $status = $data;
            } else {
                $status = (new Base())->getStatus($data);
            }

            $condition = [];
            if ($status != Base::ALL_STATUS) {
                $condition['orders.status'] = $status;
            }
            if ($name != Base::NONETYPE) {
                $condition['services.name'] = $name;
            }
            if ($mode != Base::ALL_MODE) {
                $condition['orders.mode'] = $mode;
            }


            if ($type != Base::NONETYPE && $type != Base::SEARCH_USERNAME) {
                if ($type == Base::SEARCH_LINK) {
                    $condition['orders.link'] = $search;
                }
                if ($type == Base::SEARCH_ID) {
                    $condition['orders.id'] = $search;
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
                        'orders.mode'])->from('orders')->join(
                    'JOIN',
                    'users',
                    'orders.user_id = users.id')->join(
                    'JOIN',
                    'services',
                    'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC]);

                $getpag = (new Base())->getPagination($query);


            }

            if ($type == Base::SEARCH_USERNAME) {
                $arr = explode(' ', $search);
                if (count($arr) < 2) {
                    $condition2 = $condition;
                    $condition2['users.last_name'] = $search;
                    $condition['users.first_name'] = $search;
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
                        'users', 'orders.user_id = users.id')->join(
                        'JOIN',
                        'services',
                        'orders.service_id = services.id')->where($condition)->orWhere($condition2)->orderBy(
                        ['orders.id' => SORT_DESC]);
                } else {

                    $condition2 = $condition;
                    $condition2['users.first_name'] = $arr[1];
                    $condition2['users.last_name'] = $arr[0];
                    $condition['users.first_name'] = $arr[0];
                    $condition['users.last_name'] = $arr[1];

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
                        'orders.service_id = services.id')->where($condition)->orWhere($condition2)->orderBy(
                        ['orders.id' => SORT_DESC]);
                }

                $getpag = (new Base())->getPagination($query);

            }

            if ($type == Base::NONETYPE) {
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
                        'orders.mode'])->from('orders')->join(
                    'JOIN',
                    'users',
                    'orders.user_id = users.id')->join(
                    'JOIN',
                    'services',
                    'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC]);

                $getpag = (new Base())->getPagination($query);

            }

            $getpag['search'] = $arrsearch;
            $getpag['status'] = $data;
            $getpag['name'] = $name;
            $getpag['mode'] = $mode;

            return $getpag;

        }

    }


    /**
     * @param $get
     */
    private function setParam($get)
    {
        if (! isset($get['data'])) {
            $this->data = Base::ALL_STATUS;
        } else {
            $this->data = $get['data'];
        }
        if (! isset($get['name'])) {
            $this->name = Base::NONETYPE;
        } else {
            $this->name = $get['name'];
        }
        if (! isset($get['search-type'])) {
            $this->type = Base::NONETYPE;
            $this->search = Base::NONETYPE;
        } else {
            $this->type = $get['search-type'];
            $this->search = trim($get['search']);
        }
        if (! isset($get['mode'])) {
            $this->mode = Base::ALL_MODE;
        } else {
            $this->mode = $get['mode'];
        }
    }

    /**
     * @return array
     */
    private function index()
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
        $getpag['status'] = 'All';
        $getpag['mode'] = Base::ALL_MODE;
        $getpag['name'] = Base::NONETYPE;
        $getpag['type'] = Base::NONETYPE;
        $getpag['search']['search-type'] = Base::NONETYPE;
        $getpag['search']['search'] = Base::NONETYPE;


        return $getpag;
    }

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['search'], 'string', 'max' => 120],
            [['mode'], 'integer', 'max' => 7],
            [['name'], 'string', 'max' => 25],
        ];
    }
}