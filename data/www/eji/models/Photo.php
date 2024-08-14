<?php

namespace app\models;

use yii;
use yii\db\ActiveRecord;

class Photo extends ActiveRecord
{
  	public function imgUrl($size=''){
  	if($size==''){
		return Yii::$app->params['staticUrl'].$this->dirPath . $this->filename;
  	}else{
  		return Yii::$app->params['staticUrl'].$this->dirPath . str_replace('.', '_'.$size.'.', $this->filename);
  	}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Photo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'photo';
	}


	/**
	 * @return array relational rules.
	 */

	public function getArticle() {
			return $this->hasOne(Article::className(), ['id' => 'articleId']);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'article' => array(self::BELONGS_TO, 'Article', 'articleId'),
		);
	}


}
