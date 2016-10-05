<?php
namespace frontend\models;

use common\models\Sales;
use common\models\Products;
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
class SaleRegisterForm extends Model
{
	//  Sale
    public $user_id;
    public $model;
    public $emei1;
    public $emei2;
	public $serial;
    public $date;
    public $price;
	public $img;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['model', 'required'],

            ['emei1', 'filter', 'filter' => 'trim'],
            ['emei1', 'required'],
            ['emei1', 'string', 'min' => 15, 'max' => 15],

            ['emei2', 'filter', 'filter' => 'trim'],
            ['emei2', 'required'],
            ['emei2', 'string', 'min' => 15, 'max' => 15],

            ['serial', 'required'],
            ['serial', 'string', 'min' =>7 , 'max' => 7],

            [['emei1', 'emei2', 'serial'], 'match', 'pattern' => '/^\s*\d+\s*$/', 'message'=>'Только цифры'],
            [['emei1', 'emei2'], 'unique', 'targetClass' => '\common\models\Sales', 'message' => 'EMEI уже зарегистрирован.'],

            ['date', 'required'],
			['date', 'default', 'value' => null],

			['img', 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

        ];
    }

    /**
     * Register sale.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if ($this->validate()) {

			// User
			$sale = new Sales();
			$sale->model = $this->model;
			$sale->emei1 = $this->emei1;
			$sale->emei2 = $this->emei2;
			$sale->serial = $this->serial;
			$sale->date = $this->date;

			$product = Products::findById($this->model);
			$sale->price = $product->bonus;

			$file = UploadedFile::getInstance($this, 'img');
			if( is_object($file) ) {
				$dir = Yii::getAlias('uploads/sales/');
				$uploaded = $file->saveAs( $dir . $file->baseName . '.' . $file->extension);
				$sale->img = $file->baseName . '.' . $file->extension;
			}

			$sale->user_id = $this->user_id;
            if (!$sale->save()) {
				Yii::$app->session->setFlash('error', 'Произошла ошибка, не сохранены данные продажи.');
				return null;
            }
			Yii::$app->session->setFlash('success', 'Информация о продаже добавлена.');
            return true;
        }
    }

    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
            'model' => 'Модель устройства',
            'emei1' => 'EMEI',
			'emei2' => 'EMEI',
			'serial' => 'Серийный номер',
			'date' => 'Дата продажи',
            'img' => 'Чек/Сервисная кинижка',
		];
	}

}