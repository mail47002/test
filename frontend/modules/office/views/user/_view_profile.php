<?php
/*
 * Profile model view
 */
use yii\widgets\DetailView;
if( in_array($role,[6]) ) {
	$identificators = $profile->generateAssociatedIdentificators();
}
$profile->getAssociatedData();
?>
					<h3>Личные данные</h3>
					<div class="table-responsive">
						<?= DetailView::widget([
							'model' => $profile,
							'options' => [
								'class' => 'table table-striped element-view',
							],
							'attributes' => [
								//'id',
								//'img',
								//'user_num',
								'firstname',
								'middlename',
								'lastname',
								[
									'attribute' => 'birthday',
									'format' => ['date', 'dd.MM.Y'],

								],
								'gender',
							],
						]) ?>
					</div>
					<h3>Контактная информация</h3>
					<div class="table-responsive">
						<?= DetailView::widget([
							'model' => $profile,
							'options' => [
								'class' => 'table table-striped element-view',
							],
							'attributes' => [
								'district',
								'city',
								'phone',
							],
						]) ?>
					</div>
					<h3>Профессиональная информация</h3>
					<div class="table-responsive">
						<?= DetailView::widget([
							'model' => $profile,
							'options' => [
								'class' => 'table table-striped element-view',
							],
							'attributes' => [
								'education',
								'work_expiriance',
								'company_expiriance',
								'subdivision',
								'position',
								'category',
								'organization',
								'organization_address',
							],
						]) ?>
					</div>
					<?php
						if( in_array($role,[6]) ) {
					?>
					<h3>Данные для системы обучения</h3>
					<div class="table-responsive">
							<?= DetailView::widget([
								'model' => $profile,
								'options' => [
									'class' => 'table table-striped element-view',
								],
								'attributes' => [
									//'id',
									//'img',
									//'user_num',
									[
										'attribute' => 'user_num',
										'value' => $identificators['user_num'],
									],
									[
										'attribute' => 'subdivision_id',
										'value' => $identificators['subdivision_id'],
									],
									[
										'attribute' => 'position_id',
										'value' => $identificators['position_id'],
									],
									[
										'attribute' => 'category_id',
										'value' => $identificators['category_id'],
									],
									'sdo_points',
									'sdo_password',
								],
							]) ?>
					<?php
						} elseif( in_array($role,[10,12]))  {
					?>
					<h3>Оценочная информация</h3>
					<div class="table-responsive">
							<?= DetailView::widget([
								'model' => $profile,
								'options' => [
									'class' => 'table table-striped element-view',
								],
								'attributes' => [
									//'id',
									//'img',
									//'user_num',
									'sdo_points',
									'scores',
								],
							]) ?>
					<?php
						}
					?>
					</div>