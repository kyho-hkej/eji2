<?php
namespace app\components;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Article;

class WebWmMostPopularWidget extends Widget {


    public $articles;

    public function init()
    {
        $sectionIds = Yii::$app->params['section2id']['wm-all'];
        parent::init();

        $this->articles = Article::findHotArticles($sectionIds, $limit=10, $interval=31);

    }
    
    public function run()
    {
        /*echo $sectionIds;
        return $sectionIds;*/
        return $this->render('web_wm_most_popular', ['articles' => $this->articles]);
    }
}
?>