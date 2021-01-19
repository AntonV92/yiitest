<?php 
use yii\widgets\LinkPager;
use yii\helpers\Url;

if (!isset($name)) {
    $name = 'none';
}
if (!isset($search)) {
    $search = [];
}
if (!isset($mode)) {
    $mode = 7;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>App</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <style>
    .label-default{
      border: 1px solid #ddd;
      background: none;
      color: #333;
      min-width: 30px;
      display: inline-block;
  }
</style>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>

  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
  </div>
  <div class="collapse navbar-collapse" id="bs-navbar-collapse">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Orders</a></li>
  </ul>
</div>
</div>
</nav>
<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
      <li class=<?php if($class == 'all'){ echo "active"; } ;?>><a href="/">All orders</a></li>
      <li class=<?php if($class == 'pending'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 0]); ?>">Pending</a></li>
      <li class=<?php if($class == 'inprogress'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 1]); ?>">In progress</a></li>
      <li class=<?php if($class == 'completed'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 2]); ?>">Completed</a></li>
      <li class=<?php if($class == 'canceled'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 3]); ?>">Canceled</a></li>
      <li class=<?php if($class == 'error'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 4]); ?>">Error</a></li>
      <li class="pull-right custom-search">
        <form class="form-inline" action="/search" method="get">
          <div class="input-group">
            <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
            <span class="input-group-btn search-select-wrap">

              <select class="form-control search-select" name="search-type">
                <option value="1" selected="">Order ID</option>
                <option value="2">Link</option>
                <option value="3">Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
        </span>
    </div>
</form>
</li>
</ul>
<table class="table order-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>User</th>
      <th>Link</th>
      <th>Quantity</th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Service
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="active"><a href="">All <?php echo array_sum($arr); ?> </a></li>
            <?php
            foreach ($arr as $key => $v) {

                echo "<li><a href=" . Url::to(['service', 'data' => $status, 'name' => $key, 'mode' => $mode ]) . "><span class=\"label-id\"> $v </span> $key </a></li>";
            }
            ?>
        </ul>
    </div>
</th>
<th>Status</th>
<th class="dropdown-th">
    <div class="dropdown">
      <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Mode
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><a href="<?php echo Url::to(['mode', 'data' => $status, 'name' => $name, 'mode' => 7]); ?>">All</a></li>
        <li><a href="<?php echo Url::to(['mode', 'data' => $status, 'name' => $name, 'mode' => 0]); ?>">Manual</a></li>
        <li><a href="<?php echo Url::to(['mode', 'data' => $status, 'name' => $name, 'mode' => 1]); ?>">Auto</a></li>
    </ul>
</div>
</th>
<th>Created</th>
</tr>
</thead>
<tbody>
    <?php 
    foreach ($models as $model) {
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
    echo "<tr>" . 
    "<td> {$model['id']} </td>
    <td> {$model['first_name']} </td>
    <td class=\"link\"> {$model['link']} </td>
    <td> {$model['quantity']} </td>
    <td class=\"service\">
    <span class=\"label-id\"> {$arr[$model['name']]} </span> {$model['name']}
    </td>
    <td> {$status} </td>
    <td> {$mode} </td>
    <td><span class=\"nowrap\">" . date('d-m-Y', $model['created_at']) . "</span><span class=\"nowrap\">" . date('H:i:s', $model['created_at']) . "</span></td>" .
    "</tr>";
}
?>
</tbody>
</table>
<div class="row">


</div>
</div>
<?php 
echo LinkPager::widget([
  'pagination' => $pages,
]);

echo $count;
?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
