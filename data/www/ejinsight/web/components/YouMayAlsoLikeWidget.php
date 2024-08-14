<?php
namespace app\components;
use Yii;
use yii\base\Widget;
use app\models\Article;

class YouMayAlsoLikeWidget extends Widget {

	
	//public $cur_article;
	public $cur_section;
	public $articles=null;
	public $articleId;	

	

    public function init()
    {

        // this method is called by CController::beginWidget()
        $limit = 7;
        $page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $total = 7;
        $range = '';

        $this->articles=Article::findAllBySection(Yii::$app->params['section2id'][$this->cur_section], $limit, $page, $total, $range);

    }
        
    
    public function run()
    {    	
        // this method is called by CController::endWidget()
			return $this->render('you_may_also_like', array('articles'=>$this->articles, 'articleId'=>$this->articleId));
    }
}
?>
