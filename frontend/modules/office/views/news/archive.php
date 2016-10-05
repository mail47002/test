<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;

//$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Новости СМП';
$this->params['breadcrumbs'][] = $this->title;

?>
			<div class="office-news-archive" >
				<h1><?= Html::encode($this->title) ?></h1>

			<?php
				foreach( $dataProvider->getModels() as $key => $news ) {
			?>
				<article id="news-<?php echo $news->id; ?>" class="piece-of-news" itemscope itemtype="http://schema.org/Article">
					<div class="row">
						<?php
							$profile_dir = '@web/uploads/post/';
							if( $news->img != '' ) {
								$profile_img = $profile_dir . $news->img;
						?>
						<div class="ccl-sm-4 col-md-3 news-img">
							<?= Html::img($profile_img, ['alt'=>$news->title, 'class'=>'img-responsive']);?>
						</div>
						<?php
							}
						?>

						<div class="col-sm-8 col-md-9 news-title">
							<h2><?php echo $news->title; ?></h2>
						</div><!-- /.piece-of-news -->

						<div class="col-sm-8 col-md-9 news-excerpt">
							<?php echo $news->excerpt; ?>
						</div><!-- /.piece-of-news -->

						<div class="col-sm-8 col-md-9 news-footer">
							<div class="row">
								<div class="col-xs-6 text-left text-muted">
									<span class="glyphicon glyphicon-calendar"></span> 
										<?php echo \Yii::$app->formatter->asDatetime($news->created_at, Yii::$app->params['dateFormat']); ?>
										<meta itemprop="datePublished" content="<?php echo \Yii::$app->formatter->asDatetime($news->created_at, Yii::$app->params['dateFormat']); ?>">
								</div>
								<div class="col-xs-6 text-right">
									<a class="btn btn-xs btn-success" href="<?php echo Url::to(['/office/news/single/', 'id' => $news->id]); ?>" title="Просмотреть новость <?php echo $news->title; ?>">
										Подробнее
									</a>
								</div>
							</div><!-- /.row -->
						</div><!-- /.news-footer -->

					</div><!-- /.row -->
				</article><!-- /.piece-of-news -->
			<?php
				}
			?>
			</div><!-- /.office-news-archive -->