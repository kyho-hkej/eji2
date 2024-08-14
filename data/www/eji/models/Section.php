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


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function tableName()
    {
        return 'section';
    }


}