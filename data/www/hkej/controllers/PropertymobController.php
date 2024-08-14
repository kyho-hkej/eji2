<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use uii\web\UrlManager;
//use yii\data\Pagination;
use yii\helpers\EjHelper;
use yii\helpers\Url;
use app\models\Article;
use app\models\DailyNews;


class PropertymobController extends Controller
{
	public $meta_description='';
	public $meta_keywords='';
	public $title='';

	public function actionBusiness(){

    	$sticky=Article::findBySection(Yii::$app->params['section2id']['business-sticky'], $range=7);

		//other articles
		$sectionId = Yii::$app->params['section2id']['business'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=100;
		$range=180;

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 20);

		$this->view->params['trackEvent'] = array(
                'category'=> 'Instant news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:工商舖市道|PG:'.$page,
        );
        

		if (($articles) || ($sticky)) {
            return $this->render('list', [
            'label' => '工商舖市道',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}   

    public function actionFirsthand(){

    	$sticky=Article::findBySection(Yii::$app->params['section2id']['firsthand-sticky'], $range=7);

		

		//other articles
		$sectionId = Yii::$app->params['section2id']['firsthand'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=100;
		$range=180;

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 20);

		$this->view->params['trackEvent'] = array(
                'category'=> 'Instant news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:新盤情報|PG:'.$page,
        );
        

		if (($articles) || ($sticky)) {
            return $this->render('list', [
            'label' => '新盤情報',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}

	public function actionIndex() 
	{
		$sectionId = Yii::$app->params['section2id']['property-all'];
		$limit=20;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=100;
		$range=14;

		$articles = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'Property news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:地產即時|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '地產即時',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}

	public function actionNews(){
		$this->redirect('/instantnewsmob/property');
	}

	 public function actionOpinion(){

    	$sticky=Article::findBySection(Yii::$app->params['section2id']['opinion-sticky'], $range='14');

		

		//other articles
		$sectionId = Yii::$app->params['section2id']['opinion'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=100;
		$range=180;

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 20);

		$this->view->params['trackEvent'] = array(
                'category'=> 'Instant news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:專家評論|PG:'.$page,
        );
        

		if (($articles) || ($sticky)) {
            return $this->render('list', [
            'label' => '專家評論',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}



	 public function actionResident(){

    	$sticky=Article::findBySection(Yii::$app->params['section2id']['resident-sticky'], $range='14');

		

		//other articles
		$sectionId = Yii::$app->params['section2id']['resident'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=100;
		$range='';

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 20);


		/*$pagination = new Pagination([
			'defaultPageSize' => $limit,
			'totalCount' => $total,
		]);*/

		$this->view->params['trackEvent'] = array(
                'category'=> 'Instant news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:睇樓速遞|PG:'.$page,
        );
        

		if (($articles) || ($sticky)) {
            return $this->render('list', [
            'label' => '睇樓速遞',
            'sticky' => $sticky,
            'articles' => $articles,
           // 'pagination' => $pagination,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}


	 public function actionSecondhand(){

    	$sticky=Article::findBySection(Yii::$app->params['section2id']['secondhand-sticky'], $range=7);

		

		//other articles
		$sectionId = Yii::$app->params['section2id']['secondhand'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=100;
		$range=180;

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 100);

		$this->view->params['trackEvent'] = array(
                'category'=> 'Instant news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:二手市場|PG:'.$page,
        );
        

		if (($articles) || ($sticky)) {
            return $this->render('list', [
            'label' => '二手市場',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}


	public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
		$detect = Yii::$app->mobileDetect;

        if ($detect->isMobile() && !$detect->isTablet()) {


	        $this->view->params['trackEvent'] = array(
	                'category'=> 'Property news',
	                'action'=> 'Listing Mobile',
	                'label'=> 'CID:TOC',
	        );


	        // define meta tag
	        $action_id = preg_replace('/embed/i', '', Yii::$app->controller->action->id);
			$this->view->title=Yii::$app->params['prop_meta_title'];
			$this->meta_description=Yii::$app->params['prop_meta_desc'];				
			$this->meta_keywords=Yii::$app->params['prop_meta_keywords'];
			if(empty($this->title)) //default
				$this->title='信報網站 - 即時新聞 金融脈搏 獨立股票投資分析 政治經濟 名筆評論 - hkej.com - 信報網站 hkej.com';


	        $fbarticleUrl = Yii::$app->params['mobilewebUrl'].'/'.Yii::$app->controller->id.'/'.$action_id;
	        $imgUrl = Yii::$app->params['staticUrl'].'backup_img/generic_social.png';
	        $fb_appid = '160465764053571';

	        Yii::$app->view->registerMetaTag([
	                'name' => 'description',
	                'content' => $this->meta_description,
	        ]);


	        Yii::$app->view->registerMetaTag([
	                'name' => 'keywords',
	                'content' => $this->meta_keywords,
	        ]);


	        Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->view->title], 'og_title');
	        Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'article'], 'og_type');
	        Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => $fbarticleUrl], 'og_url');
	        Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $imgUrl], 'og_image');
	        Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => '620'], 'og:image:width');
	        Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => '320'], 'og:image:height');
	        Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => '信報網站 hkej.com'], 'og:site_name');
	        Yii::$app->view->registerMetaTag(['property' => 'fb:admins', 'content' => 'writerprogram'], 'fb:admins');
	        Yii::$app->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '160465764053571'], 'fb:app_id');
	        Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $this->meta_description], 'og_description');

			$this->layout = 'mobLayout';
			return parent::beforeAction($action);

		} else {
                //$forwardURL = urlencode(app()->createAbsoluteUrl().$_SERVER["REQUEST_URI"]);
                $desktopURL = Yii::$app->params['www2Url'].$_SERVER["REQUEST_URI"];
                $desktopURL = preg_replace("%//propertymob%", '/property', $desktopURL);
                $desktopURL = preg_replace("%//propertyMob%", '/property', $desktopURL);
                //echo $desktopURL;
                $this->redirect($desktopURL);
        }

	}
}
