<?php

namespace common\models;

use common\models\UserMails;
use common\models\Profile;
use common\models\RatingSections;
use yii\behaviors\TimestampBehavior;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\base\Model;
use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $date_from
 * @property integer $date_to
 * @property string $data
 */
class Rating extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rating}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'date_from', 'date_to'], 'integer'],
            [['data', 'apportionment'], 'string', 'max' => 1000],
        ];
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'date_from',
					ActiveRecord::EVENT_BEFORE_UPDATE => 'date_to',
				],
				'value' => function() { return date('U'); },
			],
        ];
    }


    /**
     * Finds rating by id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findById($id)
    {
        return self::findOne(['id' => $id]);
    }


    /**
     * Finds rating by id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findCurrent()
    {
        return self::findOne(['status' => 1]);
    }


    /**
     * Finds rating by id
     *
     * @param integer $id
     * @return static|null
     */
    public function closeRating()
    {
		$profile = new Profile;
		$rating = $profile->getTopPlaces();
		$this->data = json_encode($rating);

		$apportionment = RatingSections::getApportionment();
		$this->apportionment = json_encode($apportionment);

		if($this->save()) {
			$message = '<br><br>';

			foreach($rating as $place => $score) {

				$gifts = new Gifts();
				if($gifts->registerNew($score['user'], $score['scores'], $place, $apportionment )) {
					// Send email to user
					$mail = new UserMails;
					$user = User::findUserById($score['user']);
					$mail->giftNewEmail($user);
					$message .= $place . ' - ' . $user->username . ' [' . $score['scores'] . ']' . '<br>';
				}
			}
		}

		// Close rating
		$this->status = 10;
		$this->save();
		Yii::$app->session->setFlash('success', 'РЕЙТИНГ ОБНОВЛЕН!' . $message);
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Состояние',
            'date_from' => 'Дата начала',
            'date_to' => 'Дата конца',
            'data' => 'Рейтинг',
			'apportionment' => 'Раскладка рейтинга',
			'place_1' => 'Место 1',
			'place_2' => 'Место 2',
			'place_3' => 'Место 3',
			'place_4' => 'Место 4',
			'place_5' => 'Место 5',
			'place_6' => 'Место 6',
			'place_7' => 'Место 7',
			'place_8' => 'Место 8',
			'place_9' => 'Место 9',
			'place_10' => 'Место 10',
			'place_11' => 'Место 11',
			'place_12' => 'Место 12',
			'place_13' => 'Место 13',
			'place_14' => 'Место 14',
			'place_15' => 'Место 15',
			'place_16' => 'Место 16',
			'place_17' => 'Место 17',
			'place_18' => 'Место 18',
			'place_19' => 'Место 19',
			'place_20' => 'Место 20',
			'place_21' => 'Место 21',
			'place_22' => 'Место 22',
			'place_23' => 'Место 23',
			'place_24' => 'Место 24',
			'place_25' => 'Место 25',
			'place_26' => 'Место 26',
			'place_27' => 'Место 27',
			'place_28' => 'Место 28',
			'place_29' => 'Место 29',
			'place_30' => 'Место 30',
        ];
    }
}
