<?php
namespace common\models;


use common\models\Products;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Product modify form
 */
class ProductForm extends Model
{
    public $id;
    public $name;
	public $description;
	public $excerpt;
	public $cat;
	public $manufacturer;
    public $url;
    public $img;
    public $thumbnail;
	public $bonus_show;
	public $bonus;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			['name', 'required'],

			['description', 'string'],

			['excerpt', 'required'],
			['excerpt', 'string', 'max' => 255],

			['cat', 'required'],

			['manufacturer', 'required'],

			['url', 'string', 'max' => 255],

            [['bonus'], 'integer', 'max' => 9999999],

            [['bonus_show'], 'string'],
        ];
    }


   /**
     * Register product.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register($new)
    {
        if ($this->validate()) {

			// User
			if($new) {
				$product = new Products();
			} else {
				$product = Products::findById($this->id);
			}

			$product->name = $this->name;
			$product->description = $this->description;
			$product->excerpt = $this->excerpt;
			$product->cat = $this->cat;
			$product->manufacturer = $this->manufacturer;
			$product->url = $this->url;
			$product->bonus_show = $this->bonus_show == '1'?10:0;
			$product->bonus = $this->bonus;

			$file = UploadedFile::getInstance($this, 'img');
			if( is_object($file) ) {
				$dir = Yii::getAlias('uploads/products/');
				$uploaded = $file->saveAs( $dir . $file->baseName . '.' . $file->extension);
				$product->img = $file->baseName . '.' . $file->extension;
			}

			if($new) {
				if (!$product->save()) {
					Yii::$app->session->setFlash('error', 'Произошла ошибка, товар не добавлен.');
					return null;
				}
				Yii::$app->session->setFlash('success', 'Новый товар добавлен.');
			} else {
				if (!$product->save(false)) {
					Yii::$app->session->setFlash('error', 'Произошла ошибка, товар не сохранен.');
					return null;
				}
				Yii::$app->session->setFlash('success', 'Информация о товаре обновлена.');
			}

            return true;
        }
    }



    /**
     * Load Data
     *
     * @return array
     */
	public function loadData($id)
	{
		$product = Products::findById($id);

		$this->name = $product->name;
		$this->description = $product->description;
		$this->excerpt = $product->excerpt;
		$this->cat = $product->cat;
		$this->manufacturer = $product->manufacturer;
		$this->url = $product->url;
		$this->thumbnail = Yii::getAlias('uploads/products/') . $product->img;
		$this->bonus_show = $product->bonus_show == 10?1:0;
		$this->bonus = $product->bonus;
	}

    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
			'name' => 'Название модели',
			'description' => 'Описание товара',
			'excerpt' => 'Краткое описание (до 500 символов)',
			'cat' => 'Категория',
			'manufacturer' => 'Производитель',
			'url' => 'Ссылка на товар в магазине',
			'img' => 'Изображение товара',
			'bonus_show' => 'Показывать в бонусах',
			'gift_show' => 'Показывать в подарках',
			'bonus' => 'Бонусных баллов за продажу',
			'gift' => 'Необходимо баллов для получения',
		];
	}
}
