<?php 
use yii\widgets\LinkPager;
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
      <li class="active"><a href="#">All orders</a></li>
      <li><a href="#">Pending</a></li>
      <li><a href="#">In progress</a></li>
      <li><a href="#">Completed</a></li>
      <li><a href="#">Canceled</a></li>
      <li><a href="#">Error</a></li>
      <li class="pull-right custom-search">
        <form class="form-inline" action="/admin/orders" method="get">
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
                <li class="active"><a href="">All (894931)</a></li>
                <li><a href=""><span class="label-id">214</span>  Real Views</a></li>
                <li><a href=""><span class="label-id">215</span> Page Likes</a></li>
                <li><a href=""><span class="label-id">10</span> Page Likes</a></li>
                <li><a href=""><span class="label-id">217</span> Page Likes</a></li>
                <li><a href=""><span class="label-id">221</span> Followers</a></li>
                <li><a href=""><span class="label-id">224</span> Groups Join</a></li>
                <li><a href=""><span class="label-id">230</span> Website Likes</a></li>
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
                <li class="active"><a href="">All</a></li>
                <li><a href="">Manual</a></li>
                <li><a href="">Auto</a></li>
              </ul>
            </div>
          </th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        foreach ($models as $model) {
          echo "<tr>" . 
          "<td> {$model['id']} </td>
          <td> {$model['first_name']} </td>
          <td class=\"link\"> {$model['link']} </td>
          <td> {$model['quantity']} </td>
          <td class=\"service\">
          <span class=\"label-id\">213</span> {$model['name']}
          </td>
          <td>Pending</td>
          <td>Manual</td>
          <td><span class=\"nowrap\">2016-01-27</span><span class=\"nowrap\">15:13:52</span></td>" .
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
?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
