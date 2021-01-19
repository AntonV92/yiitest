<?php 

namespace app\modules\orders;

use yii\db\Query;
use yii\data\Pagination;

/**
 * 
 */
class Model
{	
	

	public function index()
	{
		$query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->orderBy(['orders.id' => SORT_DESC ]);

		$getpag = self::getPagination($query);
		$getpag['status'] = 5;
		$getpag['class'] = 'all';
		
		return $getpag;
	}

	public function status($data)
	{
		$query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['orders.status' => $data])->orderBy(['orders.id' => SORT_DESC ]);

		$getpag = self::getPagination($query);
		$getpag['class'] = self::getClass($data);
		$getpag['status'] = $data;

		return $getpag;
	}

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


		$query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC ]);

		$getpag = self::getPagination($query);
		$getpag['status'] = $data;
		$getpag['name'] = $name;
		$getpag['mode'] = $mode;
		$getpag['class'] = self::getClass($data);

		return $getpag;
	}

	public function service($data, $name, $mode)
	{
		$status = $data;

		$condition = [];
		$condition['services.name'] = $name;

		if ($mode != 7) {
			$condition['orders.mode'] = $mode;
		}
		if($status < 5) {
			$condition['orders.status'] = $status;

			$query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC ]);

			$getpag = self::getPagination($query);

		} else {
			$query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where($condition)->orderBy(['orders.id' => SORT_DESC ]);

			$getpag = self::getPagination($query);
		}

		$getpag['status'] = $data;
		$getpag['name'] = $name;
		$getpag['mode'] = $mode;
		$getpag['class'] = self::getClass($data);

		return $getpag;


	}


	public function search($data)
	{
		$search = [];

        if ($data['search-type'] == 1) {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['orders.id' => $_GET['search']])->orderBy(['orders.id' => SORT_DESC ]);
        
            $getpag = self::getPagination($query);
        }

        if ($data['search-type'] == 2) {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['orders.link' => $_GET['search']])->orderBy(['orders.id' => SORT_DESC ]);
        
            $getpag = self::getPagination($query);
        }

        if ($data['search-type'] == 3) {
            $query = (new Query())->select(['link', 'first_name', 'orders.id', 'quantity', 'services.name', 'created_at', 'orders.status', 'orders.mode'])->from('orders')->join('JOIN', 'users', 'orders.user_id = users.id')->join('JOIN', 'services', 'orders.service_id = services.id')->where(['users.first_name' => $_GET['search']])->orderBy(['orders.id' => SORT_DESC ]);
        
            $getpag = self::getPagination($query);
        }

        $search['search-type'] = $data['search-type'];
        $search['search'] = $data['search'];
        $getpag['search'] = $search;
        $getpag['class'] = 'all';
        $getpag['status'] = 5;

        return $getpag;
	}




	private function getPagination($query)
	{
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 100 ]);
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

	private function getService()
	{
		return (new Query())->select(['services.name','services.id'])->from('services')->all();
	}

	private function getArray()
	{
		$arr = [];
		foreach (self::getService() as $key => $value) {
			$arr[$value['name']] = (new Query())->select('COUNT(*) AS val')->from('orders')->join('JOIN', 'services', 'orders.service_id = services.id')->where("services.id={$value['id']}")->all()[0]['val'];
		}

		arsort($arr);
		return $arr;

	}

	private function getClass($arg)
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

	private function getTable($getpag)
	{
		$table = '';

		foreach ($getpag['models'] as $model) {
        switch ($model['status']) {
            case 0:
                $status = 'Pending';
                break;
            case 1:
                $status = 'In Progress';
                break;
            case 2:
                $status = 'Completed';
                break;
            case 3:
                $status = 'Canceled';
                break;
            case 4:
                $status = 'Error';
                break;
    	}
    		$model['mode'] == 0 ? $mode = 'Manual' : $mode = 'Auto';
    		$table = $table . "<tr>" . 
    		"<td> {$model['id']} </td>
    		<td> {$model['first_name']} </td>
    		<td class=\"link\"> {$model['link']} </td>
    		<td> {$model['quantity']} </td>
    		<td class=\"service\">
    		<span class=\"label-id\"> {$getpag['arr'][$model['name']]} </span> {$model['name']}
    		</td>
    		<td> {$status} </td>
    		<td> {$mode} </td>
    		<td><span class=\"nowrap\">" . date('d-m-Y', $model['created_at']) . "</span><span class=\"nowrap\">" . date('H:i:s', $model['created_at']) . "</span></td>" . "</tr>";
		}

		return $table;
	}

}