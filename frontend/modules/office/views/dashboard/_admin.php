<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->registerJsFile('@web/js/user-management.js', ['depends' => 'yii\web\JqueryAsset']);
?>

<?php
	if( isset($users_verification) && !empty($users_verification) ) {
?>
				<h2 class="text-warning">Новые пользователи</h2>
				<div class="new-users-list">
					<div class="table-responsive">
						<table class="table">
							<tbody>
	<?php
		foreach( $users_verification as $id => $user ) {
	?>
								<tr class="warning">
									<td>
										<span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
									</td>
									<td>
										<a href="<?php echo Url::to(['/office/profile/view/', 'id' => $id]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть профиль пользователя"><?php echo $user['username'] ?></a>
									</td>
									<td><?= $user['email'] ?></td>
									<td><?= $user['created_at'] ?></td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/users/index']); ?>" data-toggle="tooltip" data-placement="top" title="Все пользователи" >
											<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
										</a>
									</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/profile/view', 'id' => $id]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть профиль пользователя">
											<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
										</a>
									</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/users/proof', 'id' => $id]); ?>" data-toggle="tooltip" data-placement="top" title="Одобрить пользователя">
											<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
										</a>
									</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/users/turnoff', 'id' => $id]); ?>" data-toggle="tooltip" data-placement="top" title="Заблокировать пользователя">
											<span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span>
										</a>
									</td>
								</tr>
	<?php
		}
	?>
							</tbody>
						</table>
					</div>
				</div><!--/.new-users-list -->
<?php
	}
?>

<?php
	if( isset($sales_verification) && !empty($sales_verification) ) {
?>
				<h2 class="text-success">Новые регистрации продаж</h2>
				<div class="new-sales-list">
					<div class="table-responsive">
						<table class="table">
							<tbody>
	<?php
		foreach( $sales_verification as $id => $sale ) {
	?>
								<tr class="success">
									<td>
										<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> 
									</td>
									<td>
										<a href="<?php echo Url::to(['/office/bonus/product-card-bonus/', 'id' => $sale['model_id']]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку бонуса"><?php echo $sale['model']; ?></a>
									</td>
									<td>
										<a href="<?php echo Url::to(['/office/profile/view/', 'id' => $sale['user_id']]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть профиль пользователя"><?php echo $sale['user_name'] ?></a>
									</td>
									<td><?= $sale['date'] ?></td>
									<td><?= $sale['price'] ?> б.</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/sales/list']); ?>" data-toggle="tooltip" data-placement="top" title="Все продажи" >
											<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
										</a>
									</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/sales/view', 'id' => $id]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть данные о продаже" >
											<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
										</a>
									</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/sales/proof', 'id' => $id]); ?>" data-toggle="tooltip" data-placement="top" title="Одобрить продажу" >
											<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
										</a>
									</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/sales/reject', 'id' => $id]); ?>" data-toggle="tooltip" data-placement="top" title="Заблокировать продажу" >
											<span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span>
										</a>
									</td>
								</tr>
	<?php
		}
	?>
							</tbody>
						</table>
					</div>
				</div><!--/.new-users-list -->
<?php
	}
?>


<?php
	if( isset($gifts_verification) && !empty($gifts_verification) ) {
?>
				<h2 class="text-success">Новые регистрации Подарков</h2>
				<div class="new-gifts-list">
					<div class="table-responsive">
						<table class="table">
							<tbody>
	<?php
		foreach( $gifts_verification as $id => $gift ) {
	?>
								<tr class="success">
									<td>
										<span class="glyphicon glyphicon-gift" aria-hidden="true"></span> 
									</td>
									<td>
										<a href="<?php echo Url::to(['/office/bonus/product-card-gift/', 'id' => $gift['model_id']]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку подарка"><?php echo $gift['model']; ?></a>
									</td>
									<td>
										<a href="<?php echo Url::to(['/office/profile/view/', 'id' => $gift['user_id']]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть профиль пользователя"><?php echo $gift['user_name'] ?></a>
									</td>
									<td><?= $gift['created_at'] ?></td>
									<td><?= $gift['price'] ?> б.</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/gifts/list']); ?>" data-toggle="tooltip" data-placement="top" title="Все подарки" >
											<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
										</a>
									</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/gifts/proof', 'id' => $id]); ?>" data-toggle="tooltip" data-placement="top" title="Одобрить подарок" >
											<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
										</a>
									</td>
									<td>
										<a href="<?php echo Url::toRoute(['/office/gifts/reject', 'id' => $id]); ?>" data-toggle="tooltip" data-placement="top" title="Заблокировать подарок" >
											<span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span>
										</a>
									</td>
								</tr>
	<?php
		}
	?>
							</tbody>
						</table>
					</div>
				</div><!--/.new-users-list -->
<?php
	}
?>