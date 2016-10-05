<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->params['breadcrumbs'][] = $model->title;
?>

		<article class="site-about" itemscope itemtype="http://schema.org/Article">
			<div class="container">

				<h1><?= Html::encode($model->title) ?></h1>

<?= $model->content ?>

			</div><!-- /.container -->
		</article><!-- /.site-about -->
