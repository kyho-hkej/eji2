<?php
namespace app\components;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\DailyNews;

class DNewsMostPopularWidget extends Widget {

    public $articles;

    public function init()
    {
        parent::init();

        //$this->articles = Article::findHotArticles($limit=10, $interval=0.5);
        $this->articles = DailyNews::findDNewsHotArticles($limit=15);
    }

    public function run()
    {
        return $this->render('dnews_most_popular', ['articles' => $this->articles]);
    }
}
?>