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
class ProductsForm extends Model
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
	public $draft;
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

            [['draft'], 'string'],

			['img', 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
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
			$product->draft = $this->draft == '1'?1:0;
			$product->bonus = $this->bonus;

			$file = UploadedFile::getInstance($this, 'img');
			if( is_object($file) ) {
				$dir = Yii::getAlias('uploads/products/');
				$file_name = 'product_' . rand(9999, 999999);
				$uploaded = $file->saveAs( $dir . $file_name . '.' . $file->extension);
				$product->img = $file_name . '.' . $file->extension;
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

			$this->id = $product->getId();
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
		$this->draft = $product->draft;
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
			'draft' => 'Черновик',
			'bonus' => 'Бонусных баллов за продажу',
		];
	}
}
