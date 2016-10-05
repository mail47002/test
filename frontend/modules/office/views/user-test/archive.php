<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$tabs = [ 'smartphones', 'tablets', 'other' ];

//$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'За что можно получить бонусы';
$this->params['breadcrumbs'][] = $this->title;

?>

		<article class="office-products-index" itemscope itemtype="http://schema.org/Article">

			<h1><?= Html::encode($this->title) ?></h1>

			<div class="product-tabs">

				<!-- Nav tabs -->
				<ul class="nav nav-tabs nav-justified" role="tablist">
					<li role="presentation" class="active">
						<a href="#smartphones" aria-controls="smartphones" role="tab" data-toggle="tab">Смартфоны</a>
					</li>
					<li role="presentation">
						<a href="#tablets" aria-controls="tablets" role="tab" data-toggle="tab">Планшеты</a>
					</li>
					<li role="presentation">
						<a href="#other" aria-controls="other" role="tab" data-toggle="tab">Другое</a>
					</li>
				</ul><!-- /.nav-tabs -->

				<!-- Tab panes -->
				<div class="tab-content">


					<?php
					$flag = true;
					foreach( $tabs as $tab ) {
					?>

					<div role="tabpanel" class="tab-pane<?php echo $flag?' active':''; ?>" id="<?php echo $tab; ?>">

							<?php
							foreach( $model as $key => $product ) {

								if($tab == 'smartphones' && $product->cat != 2) {
									continue;
								}
								if($tab == 'tablets' && $product->cat != 3) {
									continue;
								}
								if($tab == 'other' && ($product->cat == 2 || $product->cat == 3)) {
									continue;
								}

								$profile_dir = '@web/uploads/products/';
								if( $product->img == '' ) {
									$profile_img = $profile_dir . 'no_product.png';
								} else {
									$profile_img = $profile_dir . $product->img;
								}
						?>

						<div id="bonus-<?php echo $product->id; ?>" class="product-item">
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
											<a class="btn btn-xs btn-primary center-block" href="<?php echo Url::to(['/office/products/single', 'id' => $product->id]); ?>">
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
										<div class="col-xs-6 col-sm-12 points-value">
											<span class="text-success"><?php echo $product->bonus; ?></span>
										</div>
										<div class="col-xs-6 col-sm-12 points-title">
											<span class="text-success">Баллов</span>
										</div>
									</div>
								</div>

							</div>
						</div><!-- /.product-item -->

							<?php
							}
							?>

					</div><!-- /.tab-pane -->

					<?php
						$flag = false;
					}
					?>

				</div><!-- /.tab-content -->

			</div><!-- /.product-tabs -->

		</article><!-- /.office-products-index -->