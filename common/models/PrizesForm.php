<?php
namespace common\models;


use common\models\Prizes;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Product modify form
 */
class PrizesForm extends Model
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
	public $gift;


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

            [['gift'], 'integer', 'max' => 9999999],

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
				$product = new Prizes();
			} else {
				$product = Prizes::findById($this->id);
			}

			$product->name = $this->name;
			$product->description = $this->description;
			$product->excerpt = $this->excerpt;
			$product->cat = $this->cat;
			$product->manufacturer = $this->manufacturer;
			$product->url = $this->url;
			$product->draft = $this->draft == '1'?1:0;
			$product->gift = $this->gift;

			$file = UploadedFile::getInstance($this, 'img');
			if( is_object($file) ) {
				$dir = Yii::getAlias('uploads/prizes/');
				$file_name = 'prize_' . rand(99999, 999999);
				$uploaded = $file->saveAs( $dir . $file_name . '.' . $file->extension);
				$product->img = $file_name . '.' . $file->extension;
			}

			if($new) {
				if( !$product->save(false) ) {
					Yii::$app->session->setFlash('error', 'Произошла ошибка, подарок не добавлен.');
					return null;
				}
				Yii::$app->session->setFlash('success', 'Новый подарок добавлен.');
			} else {
				if( !$product->save(false) ) {
					Yii::$app->session->setFlash('error', 'Произошла ошибка, подарок не сохранен.');
					return null;
				}
				Yii::$app->session->setFlash('success', 'Информация о подарке обновлена.');
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
		$product = Prizes::findById($id);

		$this->name = $product->name;
		$this->description = $product->description;
		$this->excerpt = $product->excerpt;
		$this->cat = $product->cat;
		$this->manufacturer = $product->manufacturer;
		$this->url = $product->url;
		$this->thumbnail = Yii::getAlias('uploads/prizes/') . $product->img;
		$this->draft = $product->draft;
		$this->gift = $product->gift;
	}

    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
			'name' => 'Наименование',
			'description' => 'Описание подарка',
			'excerpt' => 'Краткое описание (до 500 символов)',
			'cat' => 'Категория',
			'manufacturer' => 'Производитель',
			'url' => 'Ссылка на товар в магазине',
			'img' => 'Изображение подарка',
			'draft' => 'Черновик',
			'gift' => 'Эквивалент',
		];
	}
}
