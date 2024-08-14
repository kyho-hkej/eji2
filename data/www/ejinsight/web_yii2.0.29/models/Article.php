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

    public $section=null;
    public $author=null;
    public $preArticle=null;
    public $nextArticle=null;
    public $inlineImages=array();
    public $recentArticles=array();
    public $relatedArticles=array();
    public $tags=array();
    public $dirPath=null;
    public $images=array(); // only holds the images like jgp & png
    public $videos=array(); // only holds the videos
    public $estate=null; // the estate which the article belongs to
    public $flags;
    public $filename;
    public $seoTags;
    public $cat=null;


	public static function getDb()
    {
        // use the "aurora proxy read only " application component
        return \Yii::$app->db;  
    }

    public function imgUrl($size=''){
        $this->dirPath='images/'. substr($this->publishDate, 0, 4)."/" . substr($this->publishDate, 5, 2)."/" . substr($this->publishDate, 8, 2)."/";
        if($size==''){
            return Yii::$app->params['staticUrl'].$this->dirPath . $this->firstPhoto;
        }else{
            return Yii::$app->params['staticUrl'].$this->dirPath . str_replace('.', '_'.$size.'.', $this->firstPhoto);
        }
    }

    public function findAllBySection($sectionId, $limit=10, $page=1, &$total, $range=''){
        if(!$sectionId)
            return false;

        $cacheKey='Article_findAllBySection_'.$sectionId.'_'.$limit.'_'.$page.'_'.$range;
        //$cacheKeyTotal='Article_findAllBySectionLj_total_N_'.$sectionId.'_'.$limit.'_'.$page.'_'.$range;

        //echo 'aaa'.$cacheKey;
        $cache = Yii::$app->cache;
        $articles=$cache->get($cacheKey);

        $sectionId=str_replace(" ","", $sectionId); 
        $new_sectionId=str_replace(",","|", $sectionId); //4400, 4401, 4402, => 4400|4401|4402
        
        if($articles!==false){
            //$total=$cache->get($cacheKeyTotal);
        }else{

            // also in File Cache
            $fileCache = Yii::$app->cache;
            $articles= $fileCache->get($cacheKey);
            if($articles!==false){
                //$total= $fileCache->get($cacheKeyTotal);
            }else{

                $sql="SELECT SQL_CALC_FOUND_ROWS ar.* ";
                $sql .=" FROM `v_active_article` ar ";
                $sql .=" JOIN article2section a2s ON ar.id = a2s.articleId ";
                $sql .=" WHERE 1 ";
                if($sectionId)
                    $sql .=" AND a2s.sectionId IN ( $sectionId) ";
                if($range)
                    $sql .=" AND (`publishDate` BETWEEN DATE_SUB(now() , INTERVAL $range DAY) AND now( )) ";
                $sql .=" GROUP BY ar.id ORDER BY ar.publishDate desc ";
                $sql .=" limit ".($page -1) * $limit.", $limit";

                //echo $sql.'<br>';

                //Yii::$app->get('dbauroralj');
                $query=Article::findBySql($sql);
                $articles = $query->all();
                //print_r($articles);

                //$articles=Yii::$app->db->createCommand($sqlData);
                //if($total > 0){
                if(count($articles) > 0){
                    //Yii::$app->cache->set($cacheKey, $articles, 60);
                    //Yii::$app->cache->set($cacheKeyTotal, $total, 3600);
                    $cache->set($cacheKey, $articles, 60);
                    
                    // one more set in File Cache
                    $fileCache->set($cacheKey, $articles, 60);
                    
                    error_log("set cache hkej articles sectionId=$sectionId cacheKey=$cacheKey");
                } else {
                    error_log('lj article sectionId='.$sectionId.' findAllBySection from db is also null, sql='.$sql);
                }
            }
        }
        return $articles;
    }   

   public function findById($id, $sectionId=''){
        //echo $sectionId;
        $cacheKey='EJinsightArticle_'.$id;
        //$article=app()->cache->get($cacheKey);
        $cache = Yii::$app->cache;
        $article=$cache->get($cacheKey);
        
        //$article->preArticle=$article->findPreInSection($sectionId, $range=7);
        //$article->nextArticle=$article->findNextInSection($sectionId, $range=7);

        if($article==false){
            //echo 'no cache';
            $sql="SELECT ar . * FROM `v_active_article` ar WHERE ar.id='$id' ";
            //$article=Article::model()->findBySql($sql);
            $query=Article::findBySql($sql);
            $article = $query->all();
            
            //$publishDate = $article->publishDate;
            if($article){
                $article = $article[0];

                //author
               // $article->author = Author::findOne($article->authorId);             
               
                $article->section =$article->getSection();

                return $article;
            } else {
                error_log('ejinight article id='.$id.' findById from db is also null, sql='.$sql);
                //throw new \yii\web\HttpException(404,'The requested page does not exist.');
            }
                
        } else {
            return $article;
        }
            
        
    }

    /**
     * @return an article
     */
    public function findBySection($sectionId, $range=''){
        if(!$sectionId)
            return false;
        
        $cacheKey='Article_findBySection__'.$sectionId;
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
            $query=Article::findBySql($sql);
            $article=$query->all();
            //print_r($article);
            $cache->set($cacheKey, $article, 60);
        }
        return $article;
    }

   public function getSection($catId=''){
        
        if($this->section){         
            return $this->section;
        }
        
        $found=false;
        $allSections=$this->getSections();
        if($catId==''){
            if($this->firstSection){                
                $this->section=$allSections[$this->firstSection];               
            }else{
                $this->section=array_shift($allSections);
            }
        }else{
            foreach($allSections as $k=>$v){
                if($v->catId == $catId && $v->nav){
                    $this->section=$v;              
                    $found=true;
                    break;
                }
            }
            if(!$found)
                $this->section=array_shift($allSections);
        }       
        //print_r($this->section);
        return $this->section;
    }

    /*
     * get all Sections of an article
     */
    public function getSections(){
        $sections=array();
        $ary=explode(',', $this->sectionId);
        foreach($ary as $v){
            $sections[$v]=Section::findById($v);
        }
        //print_r($sections);
        return $sections;
    } 

    public function formatURL($string, $id){
        $s = str_replace("/","-",$string);
        $subjectline = '/ejinsight/article/id/'.$id.'/'.urlencode($s);
        
        return $subjectline;
    }

    public function recap($content, $len=50, $allowable_tags=''){
            $content = str_replace('&nbsp;', ' ', $content); // need to replace first because html_entity_decode cannot decode &nbsp;
            $str=html_entity_decode(strip_tags($content, $allowable_tags));
            if(mb_strlen($str) <= $len)
                return $str;
            
            $str=mb_substr($str, 0, $len, 'utf-8');
            preg_match('/(\s\w+)$/', $str, $matches);
            if(isset($matches[0])){
                $matches[0]=$matches[0];
            } else {
                $matches[0]='';
            }
            return preg_replace('/'.$matches[0].'$/', '', $str);
            
    }

    public function _findAllBySection($sectionId, $limit=10, $page=1, &$total, $range=''){
        if(!$sectionId)
            return false;

        
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


}

?>