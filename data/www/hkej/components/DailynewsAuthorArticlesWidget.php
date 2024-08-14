<?php
namespace app\components;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Article;
use yii\caching\Cache;

class DailynewsAuthorArticlesWidget extends Widget {

    public $articles;
    public $authorId;
    public $authorName;
    public $today;

    public function init()
    {
        parent::init();

        //if(!isset($this->authorId) || !$this->authorId)
        $today = Yii::$app->session->get('dnewsToday');
        $cacheKey='Article_DailynewsAuthorArticles_'.md5($today.$this->authorId);
        $cache = Yii::$app->cache;
        $this->articles=$cache->get($cacheKey);

        if($this->articles==false){
            $this->articles = Article::find()
                ->joinWith('author')
                ->where(['author.id'=>$this->authorId])
                ->orderBy(['article.publishDateLite' => SORT_DESC])
                ->limit(10)
                ->all();
            if($this->articles){
                $cache->set($cacheKey, $this->articles, 600);
            }

        }

    }

    public function run(){
        return $this->render('dailynews_author_articles', ['articles' => $this->articles, 'authorName' => $this->authorName]);
    
    }
}
    

?>