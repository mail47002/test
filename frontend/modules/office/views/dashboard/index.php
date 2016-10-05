<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

$args = [];
if( $role->id == 10 ) {
	$args['count_gifts'] = $count_gifts;
	$args['count_bonuses'] = $count_bonuses;
	$args['total_gifts'] = $total_gifts;
	$args['total_bonuses'] = $total_bonuses;
}
if( $role->id == 6 ) {
	$args['userid'] = $userid;
	$args['username'] = $username;
}

?>

		<article class="office-profile-dashboard" itemscope itemtype="http://schema.org/Article">

				<h1><?= Html::encode($this->title) ?></h1>

				<?php
				if( $role->id == 10 ) {
					if ($giftsDataProvider->getCount() > 0) {
						echo $this->render('__new_gifts_seller', [
							'giftsDataProvider' => $giftsDataProvider,
						]);
					?>

					<p class="text-primary"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> <span>Вам необходимо выбрать один из предложенных вариантов подарка.</span></p>
					<p class="text-muted"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> <span>После с Вами свяжется администратор и сообщет как забрать подарок, который Вы выберете.</span></p>
					<div class="clearfix margin-bottom"></div>

					<?php
					}
					if ($selectedGiftsDataProvider->getCount() > 0) {
						echo $this->render('__new_sgifts_seller', [
							'giftsDataProvider' => $selectedGiftsDataProvider,
						]);
					?>

					<p class="text-primary"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> <span>Вам назначен подарок.</span></p>
					<p class="text-muted"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> <span>С Вами свяжется администратор и сообщет как забрать подарок.</span></p>
					<div class="clearfix margin-bottom"></div>

					<?php
					}
				}
				?>

				<?= $this->render('_' . $role->slug, $args) ?>

				<div class="clearfix"></div>

				<?php
				if( $role->id >= 36 ) {
					echo $this->render('__new_users', [
						'usersDataProvider' => $usersDataProvider,
					]);
					echo $this->render('__new_sales', [
						'salesDataProvider' => $salesDataProvider,
					]);
					echo $this->render('__new_gifts', [
						'giftsDataProvider' => $giftsDataProvider,
					]);
					echo $this->render('__new_sgifts', [
						'giftsDataProvider' => $selectedGiftsDataProvider,
					]);
				}
				?>

				<?php
				if( $role->id > 16 ) {
					echo $this->render('__statistic', [
						'users_sellers' => $users_sellers,
						'users_study' => $users_study,
						'total_sales' => $total_sales,
						'total_gifts' => $total_gifts,
					]);
				?>

				<div class="clearfix"></div>
				<?php
				}
				?>

				<?= $this->render('__news', [
					'news' => $news,
				]) ?>


		</article><!-- /.office-profile-dashboard -->
