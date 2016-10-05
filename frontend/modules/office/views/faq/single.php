<?php

use yii\helpers\Html;
use yii\helpers\Url;

//$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="office-faq-view" itemscope itemtype="http://schema.org/Article">

			<h1><?= Html::encode($this->title) ?></h1>

			<div class="row">

				<div id="faq-<?php echo $model->id; ?>" class="col-xs-12 piece-of-faq">
					<?php echo $model->content; ?>
				</div><!-- /.piece-of-faq -->

				<?php
					$profile_dir = '@web/uploads/post/';
					if( $model->img != '' ) {
						$profile_img = $profile_dir . $model->img;
				?>
				<div class="col-xs-12 faq-img pull-left">
					<?= Html::img($profile_img, ['alt'=>$model->title, 'class'=>'img-responsive']);?>
				</div>
				<?php
					}
				?>

				<div class="col-xs-12 faq-footer">

				</div>

			</div><!-- /.row -->

		</article><!-- /.office-faq-view -->