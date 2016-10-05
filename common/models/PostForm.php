<?php
namespace common\models;


use common\models\Post;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * Post modify form
 */
class PostForm extends Model
{
	private $new;
    public $id;
    public $draft;
    public $title;
	public $slug;
	public $category;
	public $created_at;
	public $img;
	public $thumbnail;
    public $excerpt;
    public $content;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [

            ['draft', 'string'],

			['title', 'required'],
			['title', 'string', 'max' => 255],

			['slug', 'required'],
			['slug', 'string', 'max' => 255],
			['slug', 'match', 'pattern' => '/^[0-9a-zA-Z\-]+$/', 'message' => 'Только латиница.'],

			['excerpt', 'required'],
			['excerpt', 'string', 'max' => 500, 'message' => 'Не более 500 символов.'],

            ['content', 'string'],

            ['category', 'integer'],

        ];
		if( isset($this->new) && $this->new ) {
			$rules[] = ['slug', 'unique', 'targetClass' => '\common\models\Post', 'message' => 'Должно быть уникальным. В идеале заголовок транслитом.'];
		}
		return $rules;
    }


   /**
     * Register post.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register($new)
    {
		if($new) {
			$this->new = true;
		}

			// User
			if($new) {
				$post = new Post();
			} else {
				$post = Post::findById($this->id);
			}

			$post->draft = $this->draft == '1'?1:0;
			$post->title = $this->title;
			$post->slug = $this->slug;
			$post->category = (int)$this->category;
			$post->excerpt = $this->excerpt;
			$post->content = $this->content;

			$file = UploadedFile::getInstance($this, 'img');
			if( is_object($file) ) {
				$dir = Yii::getAlias('uploads/post/');
				$file_name = 'post_' . $this->slug;
				$uploaded = $file->saveAs( $dir . $file_name . '.' . $file->extension);
				$post->img = $file_name . '.' . $file->extension;
			}

			if($new) {
				if (!$post->save(true)) {
					Yii::$app->session->setFlash('error', 'Произошла ошибка, запись не добавлена.');
					return null;
				}
				Yii::$app->session->setFlash('success', 'Новая запись добавлена.');
			} else {
				if (!$post->save(false)) {
					Yii::$app->session->setFlash('error', 'Произошла ошибка, запись не сохранена.');
					return null;
				}
				Yii::$app->session->setFlash('success', 'Запись обновлена.');
			}

			$this->id = $post->getId();
		return true;
    }



    /**
     * Load Data
     *
     * @return array
     */
	public function loadData($id)
	{
		$post = Post::findById($id);

		$this->title = $post->title;
		$this->draft = $post->draft;
		$this->slug = $post->slug;
		$this->category = $post->category;
		$this->excerpt = $post->excerpt;
		$this->content = $post->content;
		$this->thumbnail = '';
		if( $post->img != '' ) {
			$this->thumbnail = Yii::getAlias('uploads/post/');
		}
		$this->thumbnail .= $post->img;
	}


    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
			'draft' => 'Черновик',
			'slug' => 'Ярлык записи (заголовок литиницей вместо пробелов дефисы)',
			'title' => 'Заголовок записи',
			'category' => 'Категория',
			'img' => 'Изображение',
			'excerpt' => 'Краткое описание (до 500 символов)',
			'content' => 'Текст записи',
		];
	}
}