<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;


//$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Призовой фонд СМП';
$this->params['breadcrumbs'][] = $this->title;

?>

		<article class="office-prizes-index" itemscope itemtype="http://schema.org/Article">

			<h1><?= Html::encode($this->title) ?></h1>

				<?php
				foreach( $categoriesList as $cat_id => $category ) {
				?>

					<div class="alert alert-warning text-center"><h2><?= $category ?></h2></div>

						<?php
						foreach( $model as $key => $product ) {

							if($product->cat != $cat_id) {
								continue;
							}

							$profile_dir = '@web/uploads/prizes/';
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

								<div class="col-xs-6 col-sm-8 col-md-9">
									<h2 class="text-warning"><?php echo $product->name; ?></h2>
									<div class="bonus-description">
										<?php echo $product->excerpt; ?>
									</div>
									<div class="row btn-margin">
										<div class="col-xs-6">
											<a class="btn btn-xs btn-primary center-block" href="<?php echo Url::to(['/office/prizes/single', 'id' => $product->id]); ?>">
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

							</div>
						</div><!-- /.product-item -->

						<?php
							unset($model[$key]);
						}
						?>

				<?php
				}
				?>

		</article><!-- /.office-prizes-index -->