<?php

namespace app\models;

use yii;
use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Author the static model class
	 */

	public function pic()
	{
		if ($this->profilePic=='') {
			return '/images/eji_author_backup.jpg'; 
		} else {
			return Yii::$app->params['staticUrl'].$this->dirPath . $this->profilePic;
		}
	}

	/**
	 * @return array validation rules for model attributes.
	 */

	public function getArticles(){
		return $this->hasMany(Article::className(), ['id' => 'authorId']);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function tableName()
    {
        return 'author';
    }
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('status', 'numerical', 'integerOnly'=>true),
				array('authorName, intro', 'length', 'max'=>255),
			array('organization, jobTitle, profilePic', 'length', 'max'=>45),
			array('dirPath', 'length', 'max'=>100),
			array('lastUpdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, authorName, organization, jobTitle, intro, profilePic, status, lastUpdate, dirPath', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'articles' => array(self::HAS_MANY, 'Article', 'authorId', 
		'order'=>'articles.publishDate  DESC', 
		'condition'=>"articles.STATUS =1 AND articles.publishDate < now( ) AND IF(articles.`expiryDate` != '0000-00-00 00:00:00', IF( articles.`expiryDate` > now( ) , 1, 0 ) , 1 ) =1 ",
		//'limit'=>"1000",					
		),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'authorName' => 'Author Name',
			'organization' => 'Organization',
			'jobTitle' => 'Job Title',
			'intro' => 'Intro',
			'profilePic' => 'Profile Pic',
			'status' => 'Status',
			'lastUpdate' => 'Last Update',
			'dirPath' => 'Dir Path',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('authorName',$this->authorName,true);
		$criteria->compare('organization',$this->organization,true);
		$criteria->compare('jobTitle',$this->jobTitle,true);
		$criteria->compare('intro',$this->intro,true);
		$criteria->compare('profilePic',$this->profilePic,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('lastUpdate',$this->lastUpdate,true);
		$criteria->compare('dirPath',$this->dirPath,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}