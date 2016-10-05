<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;

//$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Бонус: ' .$model->name;
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="office-products-single" itemscope itemtype="http://schema.org/Article">

			<h1><?= Html::encode($this->title) ?></h1>

				<?php
					$profile_dir = '@web/uploads/products/';
					if( $model->img == '' ) {
						$profile_img = $profile_dir . 'no_product.png';
					} else {
						$profile_img = $profile_dir . $model->img;
					}
				?>

				<div id="bonus-<?php echo $model->id; ?>" class="product-card">
					<div class="row">

						<div class="col-xs-6 col-sm-3 col-md-3 product-img">
							<?= Html::img($profile_img, ['alt'=>$model->name, 'class'=>'img-responsive product-photo']);?>
						</div>

						<div class="col-xs-6 col-sm-9 col-md-9 bonus-description">
							<?php echo $model->excerpt; ?>
						</div>

						<div class="clearfix visible-xs-block"></div>

						<div class="col-sm-9 col-sm-9 col-md-9 price-block">
							<div class="row">

								<div class="col-xs-12 col-md-6">
									<span class="text-primary gift-value"><?php echo $model->bonus; ?></span>
									<span class="text-primary points-title"> Баллов</span>
								</div>

								<div class="clearfix visible-xs-block visible-sm-block"></div>

								<?php
									if( isset($model->url) && !empty($model->url) ) {
								?>
								<div class="col-xs-12 col-md-6">
									<a class="btn btn-primary center-block" href="<?php echo $model->url; ?>" title="Просмотреть бонус в магазине производителя">
										В магазине<span class="visible-lg-inline"> производителя</span>
									</a>
								</div>
								<?php
									}
								?>

							</div>
						</div>

						<div class="clearfix"></div>

						<div class="col-xs-12">
							<h2 class="text-warning"><?php echo $model->name; ?></h2>
							<div class="bonus-description">
								<?php echo $model->description; ?>
							</div>
						</div>


					</div><!-- /.row -->
				</div><!-- /.product-card -->

		</article><!-- /.office-products-single -->