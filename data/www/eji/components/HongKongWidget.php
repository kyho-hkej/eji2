<?php

namespace app\components;
use Yii;
use yii\data\Pagination;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\EjiHelper;
use app\models\Article;

class HongKongWidget extends Widget {

    public $articles;

    public function init()
    {
        parent::init();

		$limit=5;
		$page=1;
		$total=5;
		$range=180;

        //HONGKONG
		$sid = Yii::$app->params['section2id']['hongkong'];
		$query = Article::findAllBySection($sid, $limit, $page, $total, $range);
		$widget = $query->all();

		$this->articles=$widget;

    }

    public function run()
    {
        return $this->render('hong_kong_widget', ['articles' => $this->articles]);
    }
}





?>