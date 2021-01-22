<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\modules\orders\widgets\MainWidget;
use yii\captcha\Captcha;
use app\modules\orders\models\Base;

$data = $this->context->vars;

if (!isset($data['name'])):
	$data['name'] = 'none';
endif;
if (!isset($data['mode'])):
	$data['mode'] = Base::ALL_MODE;
endif;
if (!isset($data['search'])):
	$type = 'none';
	$search = 'none';
else:
	$type = $data['search']['search-type'];
	$search = $data['search']['search'];
endif;
/* @var $this yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/custom.css" rel="stylesheet">
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
	<?php $this->beginBody() ?>
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
      <li class=<?php if ($data['status'] == 'all'){ echo "active"; } ;?>><a href="/">All orders</a></li>
      <li class=<?php if ($data['status'] == 'pending'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 'pending']); ?>">Pending</a></li>
      <li class=<?php if($data['status'] == 'inprogress'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 'inprogress']); ?>">In progress</a></li>
      <li class=<?php if($data['status'] == 'completed'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 'completed']); ?>">Completed</a></li>
      <li class=<?php if($data['status'] == 'canceled'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 'canceled']); ?>">Canceled</a></li>
      <li class=<?php if($data['status'] == 'error'){ echo "active"; } ;?>><a href="<?php echo Url::to(['status', 'data' => 'error']); ?>">Error</a></li>
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
            <li class="active"><a href="<?php echo Url::to(['service', 'data' => $data['status'] , 'name' => Base::NONETYPE , 'mode' => $data['mode'], 'type' => $type, 'search' => $search ]) ?>">All <?php echo array_sum($this->context->vars['arr']); ?> </a></li>
            <?php
            foreach ($this->context->vars['arr'] as $key => $v) {

                echo "<li><a href=" . Url::to(['service', 'data' => $data['status'] , 'name' => $key, 'mode' => $data['mode'], 'type' => $type, 'search' => $search ]) . "><span class=\"label-id\"> $v </span> $key </a></li>";
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
        <li><a href="<?php echo Url::to(['mode', 'data' => $data['status'] , 'name' => $data['name'], 'mode' => Base::ALL_MODE, 'type' => $type, 'search' => $search ]); ?>">All</a></li>
        <li><a href="<?php echo Url::to(['mode', 'data' => $data['status'] , 'name' => $data['name'] , 'mode' => Base::MANUAL_MODE, 'type' => $type, 'search' => $search ]); ?>">Manual</a></li>
        <li><a href="<?php echo Url::to(['mode', 'data' => $data['status'] , 'name' => $data['name'] , 'mode' => Base::AUTO_MODE, 'type' => $type, 'search' => $search ]); ?>">Auto</a></li>
    </ul>
</div>
</th>
<th>Created</th>
</tr>
</thead>
	<?= $content ?>
</table>
<div class="row">


</div>
</div>
<?php
echo LinkPager::widget([
  'pagination' => $data['pages'],
]);
?>
</div>

	<?php $this->endBody() ?>
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
</body>
</html>
<?php $this->endPage() ?>