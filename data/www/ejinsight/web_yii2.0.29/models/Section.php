<?php

namespace app\models;

use yii;
use yii\db\ActiveRecord;

class Section extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Author the static model class
	 */

	/**
	 * @return array validation rules for model attributes.
	 */

	/*public function getSection(){
		return $this->hasMany(Article::className(), ['id' => 'authorId']);
	}*/

	public static function findById($sectionId){

		$cacheKey='section_'.$sectionId;
		$cache = Yii::$app->cache;
		$section=$cache->get($cacheKey);

		if($section==false){
			$section=Section::findOne($sectionId);
			$cache->set($cacheKey, $section, 3600);
			
			// save once more set
			$cacheKey='section_'.$sectionId;
			$cache->set($cacheKey, $section, 3600);
		}
		//pr($section);
		return $section;
	}

	public static function findByNav($nav){

		$cacheKey='section_'.$nav;
		$cache = Yii::$app->cache;
		$section=$cache->get($cacheKey);

		if($section==false){
			$section = Section::find()->where(['nav'=>$nav, 'status'=> '1'])->all();
			$cache->set($cacheKey, $section, 3600);
			
			// save once more set
			$cacheKey='section_'.$nav;
			$cache->set($cacheKey, $section, 3600);
		}

		if ($section) {
			$section = $section[0];
			return $section;
		} else {
			return NULL;
		}
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function tableName()
    {
        return 'section';
    }

    	/**
	 * @return array relational rules.
	 */



}