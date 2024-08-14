<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use uii\web\UrlManager;
use yii\data\Pagination;
use yii\helpers\EjHelper;
use yii\helpers\Url;
use app\models\Article;

class MonthlyController extends Controller
{
	public $meta_description='';
	public $meta_keywords='';
	public $title='';

	public function actionArticle($id) 
	{
		//$id = isset($_REQUEST['id'])? $_REQUEST['id']:'';
		$article= Article::findById($id);

		if(isset($article)){
    		//$article[0]=$article;
    		Article::updateViewCnt($id);
		} else {
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}


		//sticky article x 1 on top
		$sticky=Article::findBySection(Yii::$app->params['section2id']['sticky-monthly-select'], $range=180);
		$sectionId = Yii::$app->params['section2id']['monthly-select'];
		$limit=6;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total='';
		$range='';

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);

		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 4);

		Yii::$app->view->registerMetaTag([
		        'name' => 'keywords',
		        'content' => '信報財經月刊 '.$article->subjectline.' - 信報財經月刊 hkej.com ',
		]);

		Yii::$app->view->registerMetaTag([
		        'name' => 'description',
		        'content' => '信報財經月刊 '.$article->subjectline.' - 信報財經月刊 hkej.com ',
		]);


		$this->view->params['trackEvent'] = array(
				'category'=> '信報財經月刊',
				'action'=> 'Article Full',
				'label'=> 'EJM:Article|DT:'.$article->publishDateLite.'|TID:'.$article->id.'|AN:|CN:'.$article->storyProgName.'|TTL:'.$article->subjectline,
		);

		return $this->render('article', [
            'article' => $article,
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
		
	}
	public function actionListing(){
		return $this->render('listing');
	}

	public function actionIndex(){

		$banner=Article::findBySection(Yii::$app->params['section2id']['index_top_image'], $range=180);

		//sticky article x 1 on top
		$sticky=Article::findBySection(Yii::$app->params['section2id']['sticky-monthly-select'], $range=180);

		//other articles
		$sectionId = Yii::$app->params['section2id']['monthly-select'];
		$limit=6;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total='';
		$range='';

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);

		$pagination = new Pagination([
			'defaultPageSize' => $limit,
			'totalCount' => $total,
		]);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 4);

        Yii::$app->view->registerMetaTag([
		        'name' => 'keywords',
		        'content' => '信報, 月刊, 信報財經月刊, 網上檔案庫, 封面專題, 人物志, 大中華政經, 國際金融, 投資企管, EMBA 論壇, 文化品味, 投資智慧, 林行止專欄, 曹仁超, 林行止, 香港政情, 中國評論, 台灣政經, 三地視野, 金融債匯, 國際局勢, 歐美論衡, 亞洲焦點, 股市行情, 房產透視, 產業管治, 財經論述, 人文藝術, 康健珍餚, 休閒人間, 品紅, 閱讀思潮, Hong Kong Economic Journal, HKEJ, monthly magazine, archives, 信報網站 hkej.com',
		]); 

		Yii::$app->view->registerMetaTag([
		        'name' => 'description',
		        'content' => '信報網站(www.hkej.com)《信報財經月刊》，於1977年3月創刊，由林山木伉儷創辦，在七十年代的香港可謂開風氣之先，是一份富使命感的政經雜誌。多年來一直執財經刊物的牛耳，見證本港幾許政治、經濟、社會及文化界的風雲色變。 《信報財經月刊》一直緊貼全球及中國經濟急速發展的脈搏，為讀者呈上深入淺出又具啟發性的精采文章。《信報財經月刊》網上檔案庫整輯了昔日全文，讀者可訂購指定年份的檔案庫（一年12期）。檔案庫將《信報財經月刊》內容疏理成七大類，方便讀者網上重溫各名家專欄及深度分析文章，即時掌握專業知識。此外讀者更可以熱門作者、專欄名稱或關鍵字搜尋昔日內容，篩選重點資訊，享受網上的便捷。',
		]); 


		$this->view->params['trackEvent'] = array(
				'category'=> '信報財經月刊',
				'action'=> 'EJ Monthly Landing',
				'label'=> 'CID:TOC',
		);

		return $this->render('index', [
			'banner' => $banner,
			'sticky' => $sticky,
            'articles' => $articles,
        ]);	

	}

	public function actionSelect(){

		//sticky article x 1 on top
		$sticky=Article::findBySection(Yii::$app->params['section2id']['sticky-monthly-select'], $range=180);

		//other articles
		$sectionId = Yii::$app->params['section2id']['monthly-select'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total='';
		$range='';

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		//echo $total;

		$pagination = new Pagination([
			'defaultPageSize' => $limit,
			'totalCount' => $total,
		]);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 20);

        Yii::$app->view->registerMetaTag([
		        'name' => 'keywords',
		        'content' => '信報, 月刊, 信報財經月刊, 網上檔案庫, 封面專題, 人物志, 大中華政經, 國際金融, 投資企管, EMBA 論壇, 文化品味, 投資智慧, 林行止專欄, 曹仁超, 林行止, 香港政情, 中國評論, 台灣政經, 三地視野, 金融債匯, 國際局勢, 歐美論衡, 亞洲焦點, 股市行情, 房產透視, 產業管治, 財經論述, 人文藝術, 康健珍餚, 休閒人間, 品紅, 閱讀思潮, Hong Kong Economic Journal, HKEJ, monthly magazine, archives, 信報網站 hkej.com',
		]); 

		Yii::$app->view->registerMetaTag([
		        'name' => 'description',
		        'content' => '信報網站(www.hkej.com)《信報財經月刊》，於1977年3月創刊，由林山木伉儷創辦，在七十年代的香港可謂開風氣之先，是一份富使命感的政經雜誌。多年來一直執財經刊物的牛耳，見證本港幾許政治、經濟、社會及文化界的風雲色變。 《信報財經月刊》一直緊貼全球及中國經濟急速發展的脈搏，為讀者呈上深入淺出又具啟發性的精采文章。《信報財經月刊》網上檔案庫整輯了昔日全文，讀者可訂購指定年份的檔案庫（一年12期）。檔案庫將《信報財經月刊》內容疏理成七大類，方便讀者網上重溫各名家專欄及深度分析文章，即時掌握專業知識。此外讀者更可以熱門作者、專欄名稱或關鍵字搜尋昔日內容，篩選重點資訊，享受網上的便捷。',
		]); 


		$this->view->params['trackEvent'] = array(
				'category'=> '信報財經月刊',
				'action'=> 'EJ Monthly Listing',
				'label'=> 'PSN:推介文章|PG:'.$page,
		);


		return $this->render('select', [
			'sticky' => $sticky,
            'articles' => $articles,
            'pagination' => $pagination,
        ]);	

	}

	public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

		
		$this->title=' 信報財經月刊 hkej.com ';
		$this->layout = 'ejmLayout';
		return parent::beforeAction($action);

	}
}



?>