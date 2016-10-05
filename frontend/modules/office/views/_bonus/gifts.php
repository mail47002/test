<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Что можно получить за бонусные баллы';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="office-bonus-gifts" itemscope itemtype="http://schema.org/Article">

			<h1><?= Html::encode($this->title) ?></h1>

			<div class="row">

				<?php
					foreach( $model as $key => $product ) {
						$profile_dir = '@web/uploads/products/';
						if( $product->img == '' ) {
							$profile_img = $profile_dir . 'no_product.png';
						} else {
							$profile_img = $profile_dir . $product->img;
						}
				?>

				<div id="bonus-<?php echo $product->id; ?>" class="col-sm-12 product-item">
					<div class="row">

						<div class="col-xs-6 col-sm-4 col-md-3 product-img">
							<?= Html::img($profile_img, ['alt'=>$product->name, 'class'=>'img-responsive product-photo']);?>
						</div>

						<div class="col-xs-6 col-sm-6 col-md-7">
							<h2 class="text-warning"><?php echo $product->name; ?></h2>
							<div class="bonus-description">
								<?php echo $product->excerpt; ?>
							</div>
							<div class="row btn-margin">
								<div class="col-xs-6">
									<a class="btn btn-xs btn-primary center-block" href="<?php echo Url::to(['/office/bonus/product-card-gift', 'id' => $product->id]); ?>">
										Подробнее
									</a>
								</div>
								<?php
									if( isset($product->url) && !empty($product->url) ) {
								?>
								<div class="col-xs-6">
									<a class="btn btn-xs btn-primary center-block" href="<?php echo $product->url; ?>" title="Просмотреть бонус в магазине производителя">
										В магазине<span class="visible-lg-inline"> производителя</span>
									</a>
								</div>
								<?php
									}
								?>
							</div>
						</div>

						<div class="clearfix visible-xs-block">
						</div>

						<div class="col-sm-12 col-md-2 price-block">
							<div class="row">
								<div class="col-xs-6 col-sm-12 gift-value">
									<span class="text-warning"><?php echo $product->gift; ?></span>
								</div>
								<div class="hidden-xs col-sm-12 points-title">
									<span class="text-warning">Баллов</span>
								</div>
								<div class="col-xs-6 col-sm-12 btn-order">
									<a class="btn btn-success" href="<?php echo Url::to(['/office/gifts/order/', 'id' => $product->id]); ?>">Заказать</a>
								</div>
							</div>
						</div>

					</div>
				</div>

				<?php
					}
				?>

			</div>

		</article><!-- /.office-bonus-gifts -->