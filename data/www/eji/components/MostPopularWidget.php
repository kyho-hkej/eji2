<?php
namespace app\components;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Article;

class MostPopularWidget extends Widget {

    public $articles;

    public function init()
    {
        parent::init();

        $query_hot = Article::findHotArticles($limit=10, $interval=14);
        $this->articles =  $query_hot->all();
    }

    public function run()
    {
        return $this->render('most_popular', ['articles' => $this->articles]);
    }
}
?>