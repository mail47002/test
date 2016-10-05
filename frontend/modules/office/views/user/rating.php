<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Prizes;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рейтинг продавцов';
$this->params['breadcrumbs'][] = $this->title;

function getClass($scores=false, $apportionment=false, $story=false) {
	static $counter;
	static $recovered = false;

	if($apportionment && !$recovered) {
		$counter = 0;
		$section_counter = 1;
		$count = 1;
		foreach($apportionment as $id => $section) {
			$recovered[$id]['name'] = $section['name'];
			$recovered[$id]['slug'] = $section['slug'];
			$recovered[$id]['class'] = 'section_' . $section_counter;
			$recovered[$id]['number'] = $section_counter;
			$recovered[$id]['points'] = $section['points'];
			for( $i=0; $i < (int)$section['points']; $i++ ) {
				$recovered[$id]['place'][] = $count;
				$count++;
			}
			$section_counter++;
		}
	}
	if($scores) {
		$counter++;
		foreach($recovered as $section) {
			if( in_array($counter, $section['place']) ) {
				return $section['class'];
			}
		}
	}
	if($story) {
		foreach($recovered as $section) {
			echo '<p>'.$section['number'].' <span class="'.$section['class'].'">'.$section['name'].'</span> всего: '.$section['points'].'</p>';
		}
	}
}
getClass(false, $apportionment);
?>
<div class="user-rating">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<div class="row">
		<div class="col-sm-6 col-sm-offset-6 col-md-4 col-md-offset-8 col-lg-3 col-lg-offset-9 text-right rating-legend">
			<div class="well well-sm">
			<p>Легенда рейтинга</p>
			<?php
				getClass(false, false, true);
			?>
			</div>
		</div>
	</div>

    <?= GridView::widget([
		'options' => [
            'class' => 'grid-view table-responsive'
        ],
		'showOnEmpty' => false,
		'emptyText' => '<div class="summary">В данном разделе нет никаких записей.</div>',
		'summary' => false,
		'tableOptions' => [
            'class' => 'table table-striped'
        ],
		'rowOptions' => function ($data){
			$class = getClass($data->profile->scores);
			if($class){
				return ['class' => $class];
			}else{
				return [];
			}
		},
        'dataProvider' => $dataProvider,

        'columns'	=>	[
			['class' => 'yii\grid\SerialColumn', 'header'	=>	'Место',],

			[
				'attribute'	=>	'username',
				'header'	=>	'Продавец',
				'format'	=>	'raw',
				'enableSorting'	=>	false,
				'value'		=>	function($data){
					return $data->username;
				},
			],
			[
				'attribute'	=>	'scores',
				'format'	=>	'raw',
				'value'		=>	function($data){
					return	$data->profile->scores;
				},
			],

        ],
    ]);

?>

</div>
