<?php

use yii\helpers\Html;
use yii\helpers\Url;

//$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="office-news-view" itemscope itemtype="http://schema.org/Article">

			<h1><?= Html::encode($this->title) ?></h1>

			<div class="row">

				<div class="col-xs-12 news-header text-right text-muted">
					<span class="glyphicon glyphicon-calendar"></span> 
					<?php echo \Yii::$app->formatter->asDatetime($model->created_at, Yii::$app->params['dateFormat']); ?>
					<meta itemprop="datePublished" content="<?php echo \Yii::$app->formatter->asDatetime($model->created_at, Yii::$app->params['dateFormat']); ?>">
				</div>

				<?php
					$profile_dir = '@web/uploads/post/';
					if( $model->img != '' ) {
						$profile_img = $profile_dir . $model->img;
				?>
				<div class="col-sm-12 news-img center-block">
					<?= Html::img($profile_img, ['alt'=>$model->title, 'class'=>'img-responsive']);?>
				</div>
				<?php
					}
				?>

				<div id="news-<?php echo $model->id; ?>" class="col-sm-12 piece-of-news">
					<?php echo $model->content; ?>
				</div><!-- /.piece-of-news -->

				<div class="col-xs-12 news-footer">

				</div>

			</div><!-- /.row -->

		</article><!-- /.office-news-view -->