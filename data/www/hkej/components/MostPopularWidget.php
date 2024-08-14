<?php
namespace app\components;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Article;

class MostPopularWidget extends Widget {


    public $articles;

    public function init()
    {
        $sectionIds = Yii::$app->params['section2id']['instant-hot'];
        parent::init();

        $this->articles = Article::findHotArticles($sectionIds, $limit=10, $interval=0.5);

    }
    
    public function run()
    {
        /*echo $sectionIds;
        return $sectionIds;*/
        return $this->render('most_popular', ['articles' => $this->articles]);
    }
}
?>