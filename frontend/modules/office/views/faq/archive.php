<?php

use yii\helpers\Html;
use yii\helpers\Url;

//$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Справка';
$this->params['breadcrumbs'][] = $this->title;
?>
			<div class="office-faq-archive" >
				<h1><?= Html::encode($this->title) ?></h1>
			<?php
				foreach( $dataProvider->getModels() as $faq ) {
			?>
				<article id="faq-<?php echo $faq->id; ?>" class="piece-of-faq well" itemscope itemtype="http://schema.org/Article">
					<div class="row">

						<div class="col-sm-12 faq-title">
							<a href="<?php echo Url::to(['/office/faq/single/', 'id' => $faq->id]); ?>" title="Просмотреть справку <?php echo $faq->title; ?>">
								<h2><?php echo $faq->title; ?></h2>
							</a>
						</div><!-- /.piece-of-faq -->

						<div class="col-sm-9 col-md-10 faq-excerpt">
							<?php echo $faq->excerpt; ?>
						</div><!-- /.piece-of-faq -->

						<div class="col-sm-3 col-md-2 faq-footer">
							<div class="row">
								<div class="col-xs-6 text-right">
									<a class="btn btn-xs btn-success" href="<?php echo Url::to(['/office/faq/single/', 'id' => $faq->id]); ?>" title="Просмотреть справку <?php echo $faq->title; ?>">
										Подробнее
									</a>
								</div>
							</div><!-- /.row -->
						</div><!-- /.faq-footer -->

					</div><!-- /.row -->
				</article><!-- /.piece-of-faq -->
			<?php
				}
			?>
<?php

echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
]);
?>
			</div><!-- /.office-faq-sample -->