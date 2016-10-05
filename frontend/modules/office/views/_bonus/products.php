<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Список товаров';
$this->params['breadcrumbs'][] = $this->title;


$link['bonus'] = [0 => '/office/bonus/bonuson/',
		10 => '/office/bonus/bonusoff/',
	];
$link['gift'] = [0 => '/office/bonus/gifton/',
		10 => '/office/bonus/giftoff/',
	];
$link['bonus_card'] = '/office/bonus/product-card-bonus/';
$link['gift_card'] = '/office/bonus/product-card-gift/';

$icon['bonus'] = '<span class="glyphicon glyphicon glyphicon-star" aria-hidden="true"></span>';
$icon['gift'] = '<span class="glyphicon glyphicon glyphicon-gift" aria-hidden="true"></span>';
$icon['prod'] = '<span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span>';

$color[0] = 'text-danger';
$color[10] = 'text-success';
$color['prod'] = 'text-warning';

$hint[0] = 'Разблокировать';
$hint[10] = 'Заблокировать';
$hint['bonus_card'] = 'Просмотреть карточку бонуса';
$hint['gift_card'] = 'Просмотреть карточку подарка';


?>

		<article class="office-products-list" itemscope itemtype="http://schema.org/Article">

			<h1><?= Html::encode($this->title) ?></h1>

			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<td class="text-info"><strong>ID</strong></td>
							<td class="text-info"><strong>IMG</strong></td>
							<td class="text-info"><strong>Модель</strong></td>
							<td class="text-info"><strong>Категория</strong></td>
							<td class="text-info"><strong>Производитель</strong></td>
							<td class="text-info"><strong>Видимость</strong></td>
							<td class="text-info"><strong>Баллов</strong></td>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach( $model as $key => $product ) {
					?>
						<tr>
							<td class="text-warning"><?php echo $product->id; ?></td>
							<td class="text-<?php echo $product->img==''?'danger':'success'; ?>">
								<span data-toggle="tooltip" data-placement="top" title="<?php echo $product->img==''?'Изображение отсутствует':'Изображение добавлено'; ?>">
									<span class="glyphicon glyphicon glyphicon-picture" aria-hidden="true"></span>
								</span>
							</td>
							<td class="text-info"><a href="<?php echo Url::to(['/office/bonus/edit/', 'id' => $product->id]); ?>" data-toggle="tooltip" data-placement="top" title="Изменить информацию о товаре"><?php  echo $product->name; ?></a>
							</td>
							<td class="text-warning"><?php echo $categoriesList[$product->cat]; ?></td>
							<td class="text-warning"><?php echo $manufacturersList[$product->manufacturer]; ?></td>
							<td>
								<span class="<?php echo $color[$product->bonus_show]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $hint[$product->bonus_show]; ?>">
									<a class="control-link <?php echo $color[$product->bonus_show]; ?>" href="<?php echo Url::to([$link['bonus'][$product->bonus_show], 'id' => $product->id]); ?>">
									<?php echo $icon['bonus']; ?></a>
								</span>
							</td>
							<td class="text-warning"><?php echo $product->bonus; ?></td>
							<td class="text-info">
								<a class="control-link text-info" href="<?php echo Url::to([$link['bonus_card'], 'id' => $product->id]); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $hint['bonus_card']; ?>"><?php echo $icon['prod']; ?></a>
							</td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</div>

		</article><!-- /.office-products-list -->
