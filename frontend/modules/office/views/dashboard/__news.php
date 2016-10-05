<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Что нового в СМП';
?>


				<div id="dashboard-news" class="col-xs-12" itemscope itemtype="http://schema.org/ItemList">

				<h2><?= Html::encode($this->title) ?></h2>

					<div class="row">
						<div class="col-sm-3 col-md-2 promo-ico">
							<span class="glyphicon glyphicon glyphicon-bullhorn" aria-hidden="true"></span>
							<span class="common-title">Новости</span>
							<a href="<?php echo Url::to(['/office/news/archive']); ?>">Все новости</a>
						</div>

						<div class="col-sm-9 col-md-10">
							<div class="row">
							<?php
								foreach( $news as $piece ) {
							?>

								<div class="col-sm-6 news-piece">
									<a class="item-title" href="<?php echo Url::to(['/office/news/single/', 'id' => $piece->id]); ?>" title="Просмотреть новость <?php echo $piece->title; ?>">
										<?php echo $piece->title; ?>
									</a>
									<div class="clearfix"></div>
									<span class="post-info">
										<span class="glyphicon glyphicon-calendar"></span> 
										<?php echo \Yii::$app->formatter->asDatetime($piece->created_at, Yii::$app->params['dateFormat']); ?>
										<meta itemprop="datePublished" content="<?php echo \Yii::$app->formatter->asDatetime($piece->created_at, Yii::$app->params['dateFormat']); ?>">
									</span>
								</div>

							<?php
								}
							?>
							</div><!-- /.row -->
						</div>
					</div><!-- /.row -->
				</div><!-- /#actions -->