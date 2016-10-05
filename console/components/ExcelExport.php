<?php
namespace console\components;

use Yii;
use yii\base\Model;
use common\models\ProfileDetails;
use common\models\User;
use console\components\ExcelGrid;

/**
 * Login form
 */
class ExcelExport extends Model
{

	public function run($searchModel, $dataProvider){
		
		ExcelGrid::widget([
			'filterModel'	=>	$searchModel,
			'dataProvider'	=>	$dataProvider,
			//'extension'	=>	'xlsx',
			//'filename'	=>	'testexcel',
			'properties'	=>	[
				//'creator'	=>	'',
				//'title'	=>	'',
				//'subject'	=>	'',
				//'category'	=>	'',
				//'keywords'	=>	'',
				//'manager'	=>	'',
			],
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				//'id',
				//'img',
				[
					'attribute' => 'user_num',
					'format' => 'raw',
					'value' => function($data) { return 'smp-' . $data->id; },
				],
				[
					'attribute' => 'username',
					'format' => 'raw',
					'value' => function($data) {
						$user = User::findOne($data->id);
						return $user->username;
					},
				],
				'sdo_password',
				'firstname',
				'middlename',
				'lastname',
				[
					'attribute' => 'birthday',
					'format' => ['date', 'dd.MM.Y'],

				],
				[
					'attribute' => 'gender',
					'format' => 'raw',
					'value' => function($data) { return ProfileDetails::getItemName($data->gender); },
				],
				[
					'attribute' => 'district',
					'format' => 'raw',
					'value' => function($data) { return ProfileDetails::getItemName($data->district); },
				],
				'city:text',
				'phone:text',
				[
					'attribute' => 'education',
					'format' => 'raw',
					'value' => function($data) { return ProfileDetails::getItemName($data->education); },
				],
				'work_expiriance',
				'company_expiriance',
				[
					'attribute' => 'subdivision',
					'format' => 'raw',
					'value' => function($data) { return ProfileDetails::getItemName($data->subdivision); },
				],
				[
					'attribute' => 'subdivision_id',
					'format' => 'raw',
					'value' => function($data) { return 'smp-sub-' . $data->subdivision; },
				],
				[
					'attribute' => 'position',
					'format' => 'raw',
					'value' => function($data) { return ProfileDetails::getItemName($data->position); },
				],
				[
					'attribute' => 'position_id',
					'format' => 'raw',
					'value' => function($data) { return 'smp-pos-' . $data->position; },
				],
				'organization',
				[
					'attribute' => 'category',
					'format' => 'raw',
					'value' => function($data) { return ProfileDetails::getItemName($data->category); },
				],
				[
					'attribute' => 'category_id',
					'format' => 'raw',
					'value' => function($data) { return 'smp-cat-' . $data->category; },
				],
			],
		]);
	}

}