<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;



class Taxonomy extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%taxonomy}}';
    }

    /**
     * Finds category by id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }


    /**
     * Finds taxonomy by slug
     *
     * @param string $slug
     * @return static|null
     */
    public static function findBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }

    /**
     * @inheritdoc
     */
    public static function findByProhibition($prohibition, $parentSlug)
    {
		$parent = static::findBySlug($parentSlug);
		return static::find()
				->where(['=', 'prohibition', $prohibition])
				->andWhere(['=', 'implement', $parent->id])
				->one();
    }

    /**
     * @inheritdoc
     */
    public static function getProhibitionById($id)
    {
        $tax = static::findOne(['id' => $id]);
		if(!$tax) {
			return false;
		}
		return $tax->prohibition;
    }

	
    /**
     * @inheritdoc
     */
    public static function getChildrensBySlug($slug)
    {
		$parent = self::findOne(['slug' => $slug]);
		
        return self::find()
				->where(['=', 'implement', $parent->id])
				->orderBy('id')
				->all();
    }

	
    /**
     * @inheritdoc
     */
    public static function getChildrensBySlugArray($slug, $all = false)
    {

        $sql = self::getChildrensBySlug($slug);
		$taxonomy = [];	

		foreach( $sql as $value ) {
			if( !$all ) {
				$taxonomy[$value->id] = $value->name;
			} else {
				$taxonomy[$value->id] = [
					'name' => $value->name,
					'slug' => $value->slug,
					'implement' => $value->implement,
					'prohibition' => $value->prohibition,
				];
			}
		}
		return $taxonomy;
    }

	
    /**
     * @inheritdoc
     */
    public static function getChildrensId($slug)
    {
		$sql = self::getChildrensBySlug($slug);
		$taxonomy = [];	

		foreach( $sql as $value ) {
			$taxonomy[] = $value->id;
		}
		return $taxonomy;
    }

}