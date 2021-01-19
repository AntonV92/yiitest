<?php
use yii\helpers\Html;
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
	<?php $this->head() ?>
</head>
<body>
	<p>srfgrgrgr</p>
	<?php $this->beginBody() ?>
	<?= $content ?>
	<?php $this->endBody() ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php $this->endPage() ?>