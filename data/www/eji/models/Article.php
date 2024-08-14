<?php
/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $id
 * @property integer $pageNum
 * @property integer $authorId
 * @property string $subhead
 * @property string $subjectline
 * @property integer $orgStoryID
 * @property string $publishDate
 * @property integer $recommend
 * @property integer $sequence
 * @property integer $publishStatus
 * @property string $statusOnline
 * @property integer $status
 * @property string $content
 * @property string $catId
 * @property string $sectionId
 * @property string $firstPhoto
 * The followings are the available model relations:
 * @property Author $author
 * @property Article2category[] $article2categories
 * @property Article2section[] $article2sections
 * @property Photo[] $photos
 */

namespace app\models;

use yii;
use yii\db\ActiveRecord;
use yii\caching\Cache;
use yii\caching\FileCache;

class Article extends ActiveRecord
{
	public $dirPath=null;
	public $filename;

	public static function getDb()
    {
        // use the "aurora proxy read only " application component
        return \Yii::$app->db;  
    }


    public static function find()
    {
        return parent::find()->where(['status' => 1]);
    }

	public function afterFind(){
		$this->dirPath='images/'. substr($this->publishDate, 0, 4)."/" . substr($this->publishDate, 5, 2)."/" . substr($this->publishDate, 8, 2)."/";		
		return parent::afterFind();
	}


  	public function imgUrl($size=''){
	  	if($size==''){
			return Yii::$app->params['staticUrl'].$this->dirPath . $this->firstPhoto;
	  	}else{
	  		return Yii::$app->params['staticUrl'].$this->dirPath . str_replace('.', '_'.$size.'.', $this->firstPhoto);
	  	}
	}

	/**
	 * @return an article
	 */
	public function findBySection($sectionId, $range=''){
		if(!$sectionId)
			return false;
		
		$cacheKey='Article_findBySection_'.$sectionId;
		$cache = Yii::$app->cache;
		$article=$cache->get($cacheKey);

		if($article==false){
			$sql="SELECT ar.* ";
			$sql .=" FROM `v_active_article` ar ";
			$sql .=" JOIN article2section a2s ON ar.id = a2s.articleId ";
			$sql .=" WHERE 1 AND a2s.sectionId IN ( $sectionId) ";
			if($range)
				$sql .=" AND (`publishDate` BETWEEN DATE_SUB(now() , INTERVAL $range DAY) AND now( )) ";
			$sql .=" GROUP BY ar.id ORDER BY publishDate DESC limit 1";
			$article=Article::findBySql($sql);
			$cache->set($cacheKey, $article, 60);
		}
		return $article;
	}


	/** update on 20191202 **/
	public function findAllBySection($sectionId, $limit=10, $page=1, &$total, $range=''){
		if(!$sectionId)
			return false;

		/*		
		$key = 'demo';
		$cache = Yii::$app->cache;
		$data = $cache->get($key);
		if ($data === false) {
			//echo 'abc';
	    	$cache->set($key, $data);
	    	echo "<br/>$key: ".$cache->get($key)."";
		}
		*/
		
		$cacheKey='Article_findAllBySection_'.md5($sectionId.$limit.$page.$range);
		$cacheKeyTotal='Article_findAllBySection_total_'.md5($sectionId.$limit.$page.$range);
		//echo 'aaa'.$cacheKey;
		$cache = Yii::$app->cache;
		$articles=$cache->get($cacheKey);
		
		$sectionId=str_replace(" ","", $sectionId); 
		$new_sectionId=str_replace(",","|", $sectionId); //4400, 4401, 4402, => 4400|4401|4402
		
		if($articles!==false){
			$total=$cache->get($cacheKeyTotal);
		}else{
			// also in File Cache
			$fileCache = Yii::$app->cache;
			$articles= $fileCache->get($cacheKey);
			if($articles!==false){
				$total= $fileCache->get($cacheKeyTotal);
			}else{
				$sql =" FROM `v_active_article` ar ";
				$sql .=" WHERE Concat(\",\", ar.sectionid, \",\") REGEXP \",($new_sectionId),\" ";
				//$sql .=" JOIN article2section a2s ON ar.id = a2s.articleId ";
				//$sql .=" WHERE  a2s.sectionId IN ( $sectionId) ";
				if($range) {
					if ($range < 1) {
						$p= ceil($range * 24).' HOUR';
					}else{
						$p= "$range DAY";
					}
					$sql .=" AND (`publishDate` BETWEEN DATE_SUB(now() , INTERVAL $p) AND now( )) ";
				}
				//$sql .=" GROUP BY ar.id ORDER BY NULL";
				//$sql .=" limit 1".($page -1) * $limit.", $limit";
				$sql .=" limit 1";
				
				$sqlCount='SELECT count(*) as cnt ' . $sql;
				//echo $sqlCount.'<br>';
				//$total =app()->db->createCommand($sqlCount);
				$cmd = Yii::$app->db->createCommand($sqlCount);
				$total = $cmd->queryScalar();
				//echo 'total='.$total.'<br>';
				$sql =" FROM `v_active_article` ar ";
				$sql .=" WHERE Concat(\",\", ar.sectionid, \",\") REGEXP \",($new_sectionId),\" ";

				if($range) {
					if ($range < 1) {
						$p= ceil($range * 24).' HOUR';
					}else{
						$p= "$range DAY";
					}
					$sql .=" AND (`publishDate` BETWEEN DATE_SUB(now() , INTERVAL $p) AND now( )) ";
				}
				$sql .=" GROUP BY ar.id ";
				$sql .=" ORDER BY ar.publishDate desc, ar.id desc ";

				$sql .=" limit ".($page -1) * $limit.", $limit";
			  
				//echo $sql.'<br>';

				$sqlData='SELECT ar.* ' . $sql;			
				//er($sqlData);
				//echo $sqlData.'<br>';
				$articles=Article::findBySql($sqlData);
				//$articles=Yii::$app->db->createCommand($sqlData);
				if($total > 0){
					//Yii::$app->cache->set($cacheKey, $articles, 60);
					//Yii::$app->cache->set($cacheKeyTotal, $total, 3600);
					$cache->set($cacheKey, $articles, 60);
					$cache->set($cacheKeyTotal, $total, 3600);
					// one more set in File Cache
					$fileCache->set($cacheKey, $articles, 60);
					$fileCache->set($cacheKeyTotal, $total, 3600);
				}
			}
		}
		return $articles;
	}	


	/*
	 * find an article By Id
	 * find the preArticle & nextArticle by its first section
	 * @param $id the article ID
	 * @param $sectionId the article's section ID, in CSV format
	 * @param $nextBy the way to get pre & next article: 0=by firstSection, 1=by time
	 */
	public static function findById($id){
		$cacheKey='Article_'.$id;
		//$article=app()->cache->get($cacheKey);
		$cache = Yii::$app->cache;
		$article=$cache->get($cacheKey);
		if($article==false){
			$sql="SELECT ar . * FROM `v_active_article` ar WHERE ar.id='$id' ";
			//$article=Article::model()->findBySql($sql);
			$article=Article::findBySql($sql);
			if($article){
			//app()->cache->set($cacheKey, $article, 600);
			$cache->set($cacheKey, $article, 600);
				error_log("set cache eji article id=$id cacheKey=$cacheKey subject=");
			} else {
				error_log('eji article id='.$id.' findById from db is also null, sql='.$sql);
			}

		}
		return $article;
	}


	public function findHotArticles($limit, $interval){
		if(!is_numeric($interval))
			return;
		
		$cacheKey='Article_findHotArticles_'.md5($limit).md5($interval);
		$cache = Yii::$app->cache;
		$articles=$cache->get($cacheKey);
		if($articles==false){
			$sql="SELECT ar . *
				FROM `v_active_article` ar
				JOIN article2section a2s ON ar.id = a2s.articleId";
				if ($interval < 1) {
					$p= ($interval * 24).' HOUR';
				}else{
					$p= "$interval DAY";
				}
				$sql .=" AND ar.publishDate BETWEEN DATE_SUB( now( ) , INTERVAL $p ) AND now( )
				GROUP BY ar.id
				order by viewCnt desc 
				limit $limit ";

			//er($sql);
			//$articles=Article::model()->findAllBySql($sql);
			$articles=Article::findBySql($sql);
			if($articles){
				$cache->set($cacheKey, $articles, 600);
			}
		}
		return $articles;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function tableName()
    {
        return 'article';
    }


	/**
	 * @return array relational rules.
	 */


	public function getAuthor(){
			return $this->hasOne(Author::classname(), ['authorId' => 'id']);
	}

	public function getPhoto(){
			return $this->hasMany(Photo::classname(), ['articleId' => 'id', 'status' => '1']);
	}

	public function updateViewCnt($id){
  	/*$ip=($_SERVER['HTTP_X_FORWARDED_FOR'])? $_SERVER['HTTP_X_FORWARDED_FOR']: $_SERVER['REMOTE_ADDR'];
  	if (preg_match('/^147.8.178.112$/', $ip, $match)) {
  		return;
  	}*/
		$sql="update article set viewCnt=viewCnt+1 where id=".$id;
		Yii::$app->dbaurora->createCommand($sql)->execute();
	}

	/*public function getSection(){
			return $this->hasMany(Section::classname(), ['id' => 'firstSection']);
	}*/

	/*
	* If you want to use a different database connection other than the db component, you should override the getDb() method:

	public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->db2;  
    }
    */
}




?>