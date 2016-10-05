<?php
namespace common\models;

use common\models\Sales;
use common\models\Products;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\base\Model;
use yii\bootstrap\Alert;
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
class SalesForm extends Model
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

            [['model', 'serial', 'date'], 'required', 'message' => 'Поле "{attribute}" обязательно для заполнения'],

            ['serial', 'match', 'pattern' => '/^\s*\d+\s*$/', 'message'=>'Только цифры'],

            ['serial', 'string', 'min' => 7, 'tooShort'=>'Серийный номер не менее 7 цифр'],
            ['serial', 'string', 'max' => 13, 'tooLong'=>'Серийный номер не более 13 цифр'],

            ['serial', 'filter', 'filter' => 'trim'],
            ['serial', 'unique', 'targetClass' => '\common\models\Sales', 'message' => 'Такой серийный номер уже зарегистрирован.'],


            //[['emei1', 'emei2'], 'string', 'min' => 15, 'max' => 15, 'tooShort'=>'"{attribute}" должен содержать не менее 15 цифр', 'tooLong'=>'"{attribute}" должен содержать не более 15 цифр'],

            //[['emei1', 'emei2', 'serial'], 'match', 'pattern' => '/^\s*\d+\s*$/', 'message'=>'Только цифры'],

            //['emei1', 'filter', 'filter' => 'trim'],
            //['emei1', 'unique', 'targetClass' => '\common\models\Sales', 'message' => 'Такой EMEI1 уже зарегистрирован.'],

            //['emei2', 'filter', 'filter' => 'trim'],
            //['emei2', 'unique', 'targetClass' => '\common\models\Sales', 'message' => 'Такой EMEI2 уже зарегистрирован.'],

			['date', 'default', 'value' => 0],

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
			if( !$this->emei1 || $this->emei1 == '' ) {
				$this->emei1 = 'Не указан';
			}
			if( !$this->emei2 || $this->emei2 == '' ) {
				$this->emei2 = 'Не указан';
			}
			$sale->emei1 = $this->emei1;
			$sale->emei2 = $this->emei2;
			$sale->serial = $this->serial;
			$sale->date = date('U', strtotime($this->date));

			$product = Products::findById($this->model);
			$sale->price = $product->bonus;

			$file = UploadedFile::getInstance($this, 'img');
			if( is_object($file) ) {
				$dir = Yii::getAlias('uploads/sales/');
				$file_name = 'sale_' . $this->serial;
				$uploaded = $file->saveAs( $dir . $file_name . '.' . $file->extension);
				$sale->img = $file_name . '.' . $file->extension;
			}

			$sale->user_id = $this->user_id;
            if (!$sale->save()) {
				Yii::$app->session->setFlash('error', 'Произошла ошибка, не сохранены данные продажи.');
				return null;
            }

			Yii::$app->session->setFlash('success', 'Информация о продаже добавлена.');
            return true;
        }
		Yii::$app->session->setFlash('error', 'Произошла ошибка, проверка полей не пройдена.');
		return null;
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