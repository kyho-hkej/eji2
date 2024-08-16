<?php
namespace app\components;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Article;


class MostPopularWidget extends Widget {


    public $articles_hot;

    public function init()
    {
        $sectionIds = Yii::$app->params['section2id']['popular-all'];
        parent::init();

        //most popular in 3 * 24 hours
        $this->articles_hot = Article::findHotArticles($sectionIds, $limit=4, $interval=3);

        //print_r($this->articles_hot);

        $stickyArticle=Article::findBySection(Yii::$app->params['section2id']['popular-sticky'], $range='');

        if($stickyArticle){
            $a=array_shift($stickyArticle);
            for ($i=0;$i<count($this->articles_hot);$i++){
                $cur=$this->articles_hot[$i];
                if ($cur->id == $a->id) { // delete the duplicated article
                    unset($this->articles_hot[$i]);
                    break;
                }
            }
            array_unshift($this->articles_hot, $a);
        }

    }
    
    public function run()
    {
        /*echo $sectionIds;
        return $sectionIds;*/
        //print_r($this->articles_hot);
        return $this->render('most_popular', ['articles' => $this->articles_hot]);
    }
}
?>