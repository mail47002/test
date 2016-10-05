<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="author" content="veselka.ua">
	<link rel="profile" href="http://gmpg.org/xfn/11">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body itemscope="" itemtype="http://schema.org/WebPage" data-spy="scroll">
<?php $this->beginBody() ?>

<div id="wrap">
	<header id="header" itemscope itemtype="http://schema.org/WPHeader">
		<meta itemprop="headline" content="Система мотивации персонала" />
		<meta itemprop="description" content="Система мотивации персонала" />
	</header><!-- #site-header -->

	<!-- Site content -->
	<section id="content">
        <?= $content ?>

	</section><!-- #content -->

</div><!-- #wrap -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
