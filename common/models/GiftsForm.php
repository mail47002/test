<?php
namespace common\models;

use common\models\Gifts;
use common\models\Products;
use common\models\RatingSections;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\base\Model;
use Yii;

/**
 * Sales model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $model
 * @property string $emei1
 * @property string $emei2
 * @property string $serial
 * @property integer $date
 * @property integer $created_at
 * @property string $img
 * @property integer $status
 */
class GiftsForm extends Model
{
	//  Sale
	public $id;
    public $user_id;
	public $model;
    public $price;
    public $place;
	public $condition;
	public $rating;
    public $created_at;
	public $taxonomy;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['model', 'user_id', 'price'], 'integer'],

            ['status', 'required'],
			['status', 'default', 'value' => 1],

        ];
    }

    /**
     * Register sale.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function select()
    {
		// Gift
		$gifts = Gifts::findById($this->id);
		$gifts->model = $this->model;
		$gifts->condition = 5;
		if (!$gifts->save(false)) {
			Yii::$app->session->setFlash('error', 'Произошла ошибка, не сохранены данные подарка.');
			return null;
		}
		Yii::$app->session->setFlash('success', 'Информация о подарке добавлена.');
		return true;
    }


    /**
     * Load Data
     *
     * @return array
     */
	public function loadData($id)
	{
		$gifts = Gifts::findById($id);

		// Восстановление последовательности рейтинга
		if( ($rating = Rating::findOne($gifts->rating)) == null ) {
			Yii::$app->session->setFlash('error', 'Произошла ошибка, идентификатор рейтинга отсутствует.');
			return null;
		}
		$apportionment = json_decode($rating->apportionment, true);

		$count = 1;
		foreach($apportionment as $id => $section) {
			for( $i=0; $i < (int)$section['points']; $i++ ) {
				if($gifts->place == $count) {
					$this->taxonomy = $id;
					break;
				}
				$count++;
			}
		}

		$this->id = $gifts->id;
		$this->user_id = $gifts->user_id;
		$this->model = $gifts->model;
		$this->price = $gifts->price;
		$this->place = $gifts->place;
		$this->created_at = $gifts->created_at;
		$this->condition = $gifts->condition;
		$this->rating = $gifts->rating;
	}


    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Продавец',
            'model' => 'Наименование подарка',
            'price' => 'Баллов',
            'created_at' => 'Создано',
            'condition' => 'Статус',
			'place' => 'Место в рейтинге',
			'rating' => '# рейтинга',
		];
	}

}