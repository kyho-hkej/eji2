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


class WmmobController extends Controller
{

    public $meta_description='';
    public $meta_keywords='';
    public $title='';


    public function actionArticlelist()
    {

        $sectionId = Yii::$app->params['section2id']['wm-all'];
        $limit=50;
        $page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $total=3000;
        $range='';

        $articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
        
        $sticky = array(); // no sticky just pass an empty array

        $this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:財富管理文章|PG:'.$page,
        );
        

        if ($articles) {
            return $this->render('list', [
            'label' => '全部',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
    }

	public function actionCurrency() 
	{
		$sectionId = Yii::$app->params['section2id']['currency'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:人民幣 / 外匯先機|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '人民幣 / 外匯先機',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}
	public function actionEtf() 
	{
		$sectionId = Yii::$app->params['section2id']['etf'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:ETF透視|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => 'ETF透視',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}
	public function actionFund() 
	{
		$sectionId = Yii::$app->params['section2id']['fund'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:基金縱橫|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '基金縱橫',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}
	public function actionGeneral() 
	{
		$sectionId = Yii::$app->params['section2id']['general'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:宏觀方略|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '宏觀方略',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}

	public function actionMpf() 
	{
		$sectionId = Yii::$app->params['section2id']['mpf'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:智醒退休|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '智醒退休',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}

	public function actionSmart() 
	{
		$sectionId = Yii::$app->params['section2id']['smart'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing Mobile',
                'label'=> 'PSN:精明移民 / 理財|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '精明移民 / 理財',
            'sticky' => $sticky,
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}

	public function actionIndex() 
	{
		$this->redirect('/wmmob/general');
	}
    public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        $detect = Yii::$app->mobileDetect;

        if ($detect->isMobile() && !$detect->isTablet()) {

            $this->view->params['trackEvent'] = array(
                    'category'=> 'WM news',
                    'action'=> 'Listing Mobile',
                    'label'=> 'CID:TOC',
            );


            // define meta tag
            $action_id = preg_replace('/embed/i', '', Yii::$app->controller->action->id);
    		$this->view->title=Yii::$app->params['wm_meta_title'];
    		$this->meta_description=Yii::$app->params['wm_meta_desc'];				
    		$this->meta_keywords=Yii::$app->params['wm_meta_keywords'];
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
                $desktopURL = preg_replace("%//wmmob%", '/wm', $desktopURL);
                $desktopURL = preg_replace("%//wmMob%", '/wm', $desktopURL);
                //echo $desktopURL;
                $this->redirect($desktopURL);
        }


	}
}

