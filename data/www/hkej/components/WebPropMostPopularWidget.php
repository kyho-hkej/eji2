<?php
namespace app\components;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Article;

class WebPropMostPopularWidget extends Widget {


    public $articles;

    public function init()
    {
        $sectionIds = Yii::$app->params['section2id']['prop-hot'];
        parent::init();

        $this->articles = Article::findHotArticles($sectionIds, $limit=10, $interval=1);

    }
    
    public function run()
    {
        /*echo $sectionIds;
        return $sectionIds;*/
        return $this->render('web_prop_most_popular', ['articles' => $this->articles]);
    }
}
?>