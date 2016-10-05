<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Rating */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Рейтинг #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ratings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Condition
$status[1] = '<span class="text-success" data-toggle="tooltip" data-placement="top" title="Рейтинг продолжается"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span></span>';
$status[10] = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Завершен"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span></span>';

?>
	<article class="rating-view">

		<h1><?= Html::encode($this->title) ?></h1>

		<div class="row">

			<div class="col-sm-12">

<?php
	$attributes = [
			'id',
			[
				'attribute'	=>	'status',
				'format'	=>	'raw',
				'value'		=>	$status[$model->status],
			],
			[
				'attribute'	=> 'date_from',
				'format'	=>  ['date', 'dd.MM.Y'],
			],
			[
				'attribute'	=> 'date_to',
				'format'	=> 'raw',
				'value'		=> $model->status==1?'Продолжается':Yii::$app->formatter->asDatetime($model->date_to, Yii::$app->params['dateFormat']),
			],
		];
?>

<?php
if($data) {
	foreach($data as $place => $user) {
		$attributes[] = [
				'attribute'	=>	'place_'.$place,
				'format'	=>	'raw',
				'value'		=>	Html::a($user['username'] . ' [' . $user['scores'] . ']', Url::to(['user/view', 'id' => $user['user']])),
		];
	}
}

if($apportionment && is_array($apportionment)) {
	$counter = 0;
	$result_set = '';
	foreach($apportionment as $id => $section) {
		$result_set .= 'c '.$counter.' по '.((int)$section['points']+$counter).' - '.$section['name'].'<br>';
		$counter += $section['points'];
	}
	$attributes[] = [
			'attribute'	=>	'apportionment',
			'format'	=>	'raw',
			'value'		=>	$result_set,
	];

}
?>


<?php

?>

				<?= DetailView::widget([
						'model' => $model,
						'options' => [
							'class' => 'table table-striped element-view',
						],
						'attributes' => $attributes,
					]
				) ?>

			</div>

		</div><!-- /.row -->
	</article><!-- /.rating-view -->
