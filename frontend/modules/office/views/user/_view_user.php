<?php
/*
 * User model view
 */
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
 
// Role model
$role = $user->getRole($user->role);
$role = '<span class="text-'.$role->color.'" data-toggle="tooltip" data-placement="top" title="'.$role->name.'"><span class="glyphicon glyphicon-'.$role->ico.'" aria-hidden="true"></span></span> ' . $role->name;

// User status
if($user->status == 10) {
	$user->status = 'Активен';
} elseif($user->status == 0) {
	$user->status = 'Заблокирован';
}
$attributes = [
	'id',
	'username',
	'email:email',
	'status',
	[
		'attribute' => 'created_at',
		'format' =>  ['date', 'dd.MM.Y'],
	],
	[
		'attribute' => 'updated_at',
		'format' =>  ['date', 'dd.MM.Y'],
	],
	[
		'attribute'	=>	'role',
		'format'	=>	'raw',
		'value'		=>	$role,
	],
];
if( !$admin_mode ) {
	$attributes[] = [
		'attribute'	=>	'password',
		'format'	=>	'html',
		'value'		=>	Html::a(
				'Изменить пароль',
				Url::to(['/office/user/password/', 'id' => $user->id])
		),
	];
}


?>
					<div class="table-responsive">
						<?= DetailView::widget([
							'model' => $user,
							'options' => [
								'class' => 'table table-striped element-view',
							],
							'attributes' => $attributes,
						]) ?>
					</div>