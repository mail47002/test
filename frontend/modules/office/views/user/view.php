<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $profile common\models\Profile */

$this->title = 'Профиль пользователя: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// User photo
$profile_dir = '@web/uploads/profiles/';
if( $profile->img == '' ) {
	$profile_img = $profile_dir . 'nophoto.jpg';
} else {
	$profile_img = $profile_dir . $profile->img;
}
?>
		<article class="office-user-view" itemscope itemtype="http://schema.org/Article">

			<h1><?= Html::encode($this->title) ?></h1>

			<div class="row">
				<?php
					if( $admin_mode ) {
				?>
				<div class="col-sm-12 text-right">
					<span class="small text-info">Управление пользователем</span>
				</div>

				<div class="col-sm-12">
					<div class="well well-md">
						<?php
							if( $user->role == 4 ) {
						?>
							<?= Html::a('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span><span class="hidden-xs"> Одобрить</span>', ['proof', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
						<?php
							}
						?>
						<?= Html::a('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><span class="hidden-xs"> К списку</span>', ['index'], ['class' => 'btn btn-primary']) ?>
						<?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><span class="hidden-xs"> Редактировать профиль</span>', ['profile', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
						<?= Html::a('<span class="glyphicon glyphicon-cog" aria-hidden="true"></span><span class="hidden-xs"> Изменить роль</span>', ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
						<?php
							if( $user->status == 10 ) {
						?>
							<?= Html::a('<span class="glyphicon glyphicon-off" aria-hidden="true"></span><span class="hidden-xs"> Заблокировать</span>', ['turnoff', 'id' => $user->id], ['class' => 'btn btn-danger']) ?>
						<?php
							} else {
						?>
							<?= Html::a('<span class="glyphicon glyphicon-off" aria-hidden="true"></span><span class="hidden-xs"> Разблокировать</span>', ['turnon', 'id' => $user->id], ['class' => 'btn btn-success']) ?>
						<?php
							}
						?>
						<?= Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span><span class="hidden-xs"> Удалить</span>', ['delete', 'id' => $user->id], [
							'class' => 'btn btn-danger',
							'data' => [
								'confirm' => 'Вы уверены, что хотите удалить пользователя?',
								'method' => 'post',
							],
						]) ?>
					</div>
				</div>
				<?php
					}
				?>

				<div class="col-sm-6">
					<?= Html::img($profile_img, ['alt'=>$user->username, 'class'=>'img-responsive user-photo']);?>
					<h2>Учетная запись</h2>
					<?= $this->render('_view_user', [
						'user' => $user,
						'admin_mode' => $admin_mode,
					]) ?>
				</div>

				<div class="col-sm-6">
					<?= $this->render('_view_profile', [
						'profile' => $profile,
						'role' => $user->role,
					]) ?>
				</div>

				<?php
					if( $user->role == 10 ) {
				?>
				<?= $this->render('_view_statistic', [
					'count_gifts'	=>	$count_gifts,
					'count_bonuses'	=>	$count_bonuses,
					'total_gifts'	=>	$total_gifts,
					'total_bonuses'	=>	$total_bonuses,
				]) ?>
				<?php
					}
				?>
			</div><!-- /.row -->

		</article><!-- /.office-profile-view -->
