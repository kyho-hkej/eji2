<?php
namespace app\components;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Article;

class MostPopularWidgetV2 extends Widget {

    public $articles;

    public function init()
    {
        parent::init();

        $query_hot = Article::findHotArticles($limit=10, $interval=3);
        $this->articles =  $query_hot->all();
    }

    public function run()
    {
        return $this->render('most_popular_v2', ['articles' => $this->articles]);
    }
}
?>