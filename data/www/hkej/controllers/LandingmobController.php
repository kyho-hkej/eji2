<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use uii\web\UrlManager;
//use yii\data\Pagination;
use yii\helpers\EjHelper;
use yii\helpers\Url;
use app\models\Photo;
use app\models\Article;
use app\models\DailyNews;


class LandingmobController extends Controller
{
    public $meta_description='';
    public $meta_keywords='';
    public $title='';
    public $og='';

    public function actionEmbededitorchoice(){
        //編輯推介1A(1st)=sticky-ec1A+sticky-ec1B
        //編輯推介1B(2nd)=sticky-ec1A2+sticky-ec1B2
        
        $articles_bysection_1A = Article::findBySection(Yii::$app->params['section2id']["sticky-ec1A"], $range=31);

        $articles_bycate_1A = Article::findBySection(Yii::$app->params['section2id']["sticky-ec1B"], $range=31);
        //Editor Choice1B
        $limit=2; 
        $page=1; 
        $total=2;
        $tmp=Article::findAllBySection(Yii::$app->params['section2id']['sticky-ec1A2'], $limit, $page, $total, $range=31);     
        $articles_bysection_1B=EjHelper::takeOutDuplicated($tmp, $articles_bysection_1A, 1);
        
        $tmp=Article::findAllBySection(Yii::$app->params['section2id']['sticky-ec1B2'], $limit, $page, $total, $range=31);  
        $articles_bycate_1B=Ejhelper::takeOutDuplicated($tmp, $articles_bycate_1A, 1);
                                
        $articles_bysection=array_merge($articles_bysection_1A, $articles_bysection_1B);
        $articles_bycate=array_merge($articles_bycate_1A, $articles_bycate_1B);               
        

        //Editor Choice2
        $limit=5; 
        $page=1; 
        $total=5;
        $tmp=Article::findAllBySection(Yii::$app->params['section2id']['sticky-ec2A'], $limit, $page, $total, $range=31);  
        $articles_bysection2=Ejhelper::takeOutDuplicated($tmp, $articles_bysection, 3);       

        $tmp=Article::findAllBySection(Yii::$app->params['section2id']['sticky-ec2B'], $limit, $page, $total, $range=31);   
        $articles_bycate2=Ejhelper::takeOutDuplicated($tmp, $articles_bycate, 3);     

        //$ec_articles = $articles_bysection+$articles_bycate+$articles_bysection2+$articles_bycate2;
        $ec_articles = array_merge($articles_bysection,$articles_bycate,$articles_bysection2,$articles_bycate2);
        //echo count($ec_articles);

        if ($ec_articles) {
                return $this->renderAjax('embed_editorchoice', [
                'ec_articles' => $ec_articles,
            ]);
        } else {
            echo '<!-- editor choice widget no articles -->';
        }

    }

    public function actionEmbedfeatures(){
        $s1=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header"], $range=365);
        $s2=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header2"], $range=365);
        $s3=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header3"], $range=365);
        $s4=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header4"], $range=365);
        $s5=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header5"], $range=365);

        $sticky = array_merge($s1, $s2, $s3, $s4, $s5);

        //print_r($photos);
        //print_r($sticky);
        if ($sticky) {
                return $this->renderAjax('embed_features', [
                'sticky' => $sticky,
            ]);
        } else {
            echo '<!-- features widget no articles -->';
        }
    }


    public function actionEmbedfeaturesevents(){
        $s1=Article::findBySection('19019', $range=365);
        $s2=Article::findBySection('19020', $range=365);
        $s3=Article::findBySection('19021', $range=365);
        $s4=Article::findBySection('19022', $range=365);
        $s5=Article::findBySection('19023', $range=365);

        $sticky = array_merge($s1, $s2, $s3, $s4, $s5);

        //print_r($photos);
        //print_r($sticky);
        if ($sticky) {
                return $this->renderAjax('embed_features_events', [
                'list' => $sticky,
            ]);
        } else {
            echo '<!-- features events widget no articles -->';
        }
    }

    /*public function _actionEmbedfeaturesevents(){
        $sectionId = Yii::$app->params['section2id']['features-event'];
        $limit=5;
        $page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $total=5;
        //$range=14;
        $range=360;
        $list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
        //$list = $list[0];
        if ($list) {
               return $this->renderAjax('embed_features_events', [
                'list' => $list, ]);
        } else {
            echo '<!-- features events widget no articles -->';
        }
    }*/
    
    public function actionEmbedfeatures_bak(){

        $articles='';
        $cacheKey='features_widget_topics_mobileweb'.date('Y-m-d');
        $cache = Yii::$app->cache;
        $article=$cache->get($cacheKey);

        if($articles == false){
            $data=[];
            $url= Yii::$app->params['datafeed2_features'];
            //$url=($tag)? $this->topicsUrl.'?q='.urlencode($tag): $this->topicsUrl;
            //echo ' fetchTopics $url: '.$url;
            $ch = curl_init();
            $options = array(
                    CURLOPT_POST => 1,
                    CURLOPT_HEADER => 0,
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_POSTFIELDS => $data,
            );
           
            //if (param('logErrorAll')) error_log("[feature2016] -- b4 curl $ch $url @ ".date('Y-m-d h:i:s'), 0);
            curl_setopt_array($ch, ($options));
            if( ! $result = curl_exec($ch))
            {
                echo 'curl error';
                er('curl error occurs: '.curl_error($ch));
            }
            curl_close($ch);
            //if (param('logErrorAll')) error_log("[feature2016] -- after curl $ch @ ".date('Y-m-d h:i:s'), 0);
            
            $articles=json_decode($result, true);
            //$articles=$result;
            //if(count($articles) > 0){
           
            if ($articles) {    
                $cache->set($cacheKey, $article, 300);
            }
        }

        if ($articles) {
                return $this->renderAjax('embed_features', [
                'articles' => $articles,
            ]);
        } else {
            echo '<!-- features widget no articles -->';
        }

    }

    public function actionEmbedfeaturessponsor(){
        return $this->renderAjax('embed_featuressponsor');
    }

    public function actionEmbedhkejwriter(){
        //echo DailyNews::getLatestPubDate();
        $publishDate=DailyNews::getLatestPubDate();

        $writerCnt = 1;
        $tmp = array();
        $articles = array();
        for ($writerCnt = 1; $writerCnt <= 6; $writerCnt++){
            $articles=Article::findBySectionPubdate(Yii::$app->params['section2id']["sticky-hkejwriter{$writerCnt}"], $limit=1, $publishDate=$publishDate);
            //print_r($query);

            /*if (is_array($articles)){
                $tmp[$writerCnt-1] = $articles[0];
            } else{
                $tmp[$writerCnt-1] = $articles;
            }*/

            if (!empty($articles)){
                $tmp[$writerCnt-1] = $articles[0];
            }
        }
        $articles_writer = $tmp;

        //$s[]=$this->findBySection(app()->params['section2id']['sticky-hkejwriter6'], $limit=1, $publishDate=$publishDate);
        
        //$sticky=(array_filter($s));
        //only print result if 2 or more sticky is selected
        if (count($articles_writer)>=2) {
                return $this->renderAjax('embed_hkejwriter', [
                'articles' => $articles_writer,
            ]);
        } else {
            echo '<!-- 信報手筆 last publish date is '. $publishDate.' pls select sticky articles -->';
        }

        
    }

    public function actionEmbedhealth(){

        $writerCnt = 1;
        $tmp = array();
        $articles = array();
        for ($ejhCnt = 1; $ejhCnt <= 5; $ejhCnt++){
            $articles=Article::findBySection(Yii::$app->params['section2id']["ejh_tile{$ejhCnt}"], $range=180);
            //print_r($query);
            //print_r($articles[0]);
            //echo $ejhCnt;

            if (isset($articles) || !empty($article)){
                $tmp[$ejhCnt-1] = $articles[0];
            } else{
                $tmp[$ejhCnt-1] = $articles;
            }
        }
        $articles_ejh = $tmp;

        if ($articles_ejh) {
                return $this->renderAjax('embed_health', [
                'articles' => $articles_ejh,
            ]);
        } else {
            echo '<!-- health widget no articles -->';
        }
        
    }

    /*public function actionEmbedlj(){
        $sectionId = Yii::$app->params['section2id']['recommend-lj'];
        $limit = 5;
        $page = 1;
        $total = 4;
        $range =31;
        $articles = array();

        $query=Article::findAllBySection($sectionId, $limit, $page, $total, $range);
        $articles = $query->all();
        print_r($articles);
        
        return $this->renderAjax('embed_lj');
    }*/

    public function actionEmbedmultimedia(){
        $sectionId = Yii::$app->params['section2id']['multimedia-landing-sticky'];
        $limit = 4;
        $page = 1;
        $total = 4;
        $range =31;
        $articles = array();

        $articles=Article::findAllBySection($sectionId, $limit, $page, $total, $range);        

        if ($articles) {
                return $this->renderAjax('embed_multimedia', [
                'articles' => $articles,
            ]);
        } else {
            echo '<!--video widget no articles -->';
        }
    }

    public function actionEmbedproperty(){
        //sticky 
        $sticky=Article::findBySection(Yii::$app->params['section2id']["news-sticky"], $range=31);

        //non sticky x 5
        $sectionId = Yii::$app->params['section2id']['news-sticky2'];
        $limit = 5;
        $page = 1;
        $total = 5;
        $range =31;
        $articles = array();

        $tmp=Article::findAllBySection($sectionId, $limit, $page, $total, $range);

        //$tmp=EjHelper::takeOutDuplicated($tmp, $articles_focus, 25); //take out duplicate from 焦點新聞
        $articles=EjHelper::takeOutDuplicated($tmp, $sticky, 4); //take out duplicate from sticky
        
        if ($articles) {
                return $this->renderAjax('embed_property', [
                'sticky' => $sticky,
                'articles' => $articles,
            ]);
        } else {
            echo '<!--property widget no articles -->';
        }

        
    }

    public function actionEmbedstock360(){
        return $this->renderAjax('embed_stock360');
    }

    public function actionEmbedtopslider() {

        //notice
        $msg= '';
        $notice=Article::findBySection(Yii::$app->params['section2id']["instant-notice"], $range=7);
        foreach ($notice as $a) {         
            $msg .=$a->content;
        }
        //$msg .= '為提升服務質素，信報網站將於晚上11時至午夜進行定期維護工程';
        
        //Sticky,焦點新聞 5 for slider
        $focusCnt = 1;
        $tmp = array();
        $focus = array();
        for ($focusCnt = 1; $focusCnt <= 5; $focusCnt++){
            $focus=Article::findBySection(Yii::$app->params['section2id']["sticky-focus{$focusCnt}"], $range=31);

            if (is_array($focus)){
                $tmp[$focusCnt-1] = $focus[0];
            } else{
                $tmp[$focusCnt-1] = $focus;
            }
        }
        $articles_focus = $tmp;

        //Sticky,重點新聞 x 5 but editor usually will not pick, $articles_keynews is usually empty
        $keyCnt = 1;
        $tmp = array();
        $key = array();

        for ($keyCnt = 1; $keyCnt <= 5; $keyCnt++){
            //$key = Article::model()->findAllBySection(app()->params['section2id']["sticky-keynews{$keyCnt}"], 1, 1, $t, $range=31);
            $key=Article::findBySection(Yii::$app->params['section2id']["sticky-keynews{$keyCnt}"], $range=31);
            if ($key) {
                if (is_array($key)){
                    $tmp[$keyCnt-1] = $key[0];
                } else{
                    $tmp[$keyCnt-1] = $key;
                }
            }
        }
        $articles_keynews = $tmp;

        // other 即時新聞 by publish time
        // selectable pool ( take out duplication from the selected stickies )
        $tmp=array();
        $sectionId = Yii::$app->params['section2id']['instant-all-landing'];
        $limit = 30;
        $page = 1;
        $total = 10;
        $range =31;


        $tmp=Article::findAllBySection($sectionId, $limit, $page, $total, $range);
        $tmp=EjHelper::takeOutDuplicated($tmp, $articles_focus, 25); //take out duplicate from 焦點新聞
        $articles=EjHelper::takeOutDuplicated($tmp, $articles_keynews, 5); //take out duplicate from 重點新聞
        // auto select instant News as sticky to fill empty container
        $keyCnt = 0;
        $autoSelect = array();
        if ($articles_keynews) { // do only if 重點新聞 is selected
            $tmp3 = $articles_keynews;
            //print_r($tmp3);
            foreach ($tmp3 as $element){
                if (empty($element)){
                    $tmp3[$keyCnt] = array_shift($articles);
                    print_r($tmp3);
                }
                $keyCnt++;
            }
            $articles_keynews = $tmp3;
        } else { // otherwise just retrive latest 5 instant news
            $articles_keynews=$articles;
        }
        
        if (($articles_focus) || ($articles_keynews)) {
            return $this->renderAjax('embed_topslider', [
            'notice' => $msg,
            'focusarticles' => $articles_focus,
            'keyarticles' => $articles_keynews,
        ]);
        } else {
            echo '<!--silder widget no articles -->';
        }



    }

    public function actionEmbedwm(){

        $limit = 4;
        $page = 1;
        $total = 4;
        $range =31;

        $general=Article::findAllBySection(Yii::$app->params['section2id']['recommend-general'], $limit, $page, $total, $range);

        $limit2=3;
        $total2=3;
        $etf=Article::findAllBySection(Yii::$app->params['section2id']['recommend-etf'], $limit2, $page, $total2, $range);

        $fund=Article::findAllBySection(Yii::$app->params['section2id']['recommend-fund'], $limit, $page, $total, $range);

        $fx=Article::findAllBySection(Yii::$app->params['section2id']['recommend-fx'], $limit, $page, $total, $range);

        $mpf=Article::findAllBySection(Yii::$app->params['section2id']['recommend-mpf'], $limit, $page, $total, $range);

        $warrants=Article::findAllBySection(Yii::$app->params['section2id']['recommend-warrants'], $limit, $page, $total, $range);

        $smart=Article::findAllBySection(Yii::$app->params['section2id']['recommend-smart'], $limit, $page, $total, $range);


        //$array_tab2 = new CMap();

        $array_tab = [
             'general' => $general,
             'etf' => $etf,
             'fund' => $fund,
             'fx' => $fx,
             'mpf' => $mpf,
             'warrants' => $warrants,
             'smart' => $smart
        ];

        /*return $this->renderAjax('embed_wm', [
            'general' => $general,
            'etf' => $etf,
            'fund' => $fund,
            'fx' => $fx,
            'mpf' => $mpf,
            'warrants' => $warrants,
            'smart' => $smart,
        ]);*/

        if ($array_tab) {
                return $this->renderAjax('embed_wm', ['array_tab' => $array_tab]); 
        } else {
            echo '<!--wm widget no articles -->';
        }

       
    }


	public function actionIndex(){

        $detect = Yii::$app->mobileDetect;

        if ($detect->isMobile() && !$detect->isTablet()) {

            $fbarticleUrl = Yii::$app->params['mobilewebUrl'];
            $imgUrl = Yii::$app->params['staticUrl'].'backup_img/generic_social.png';
            $fb_appid = '160465764053571';


            Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => Yii::$app->params['hkej_meta_desc'],
            ]);


            Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => Yii::$app->params['hkej_meta_keywords'],
            ]);

            Yii::$app->view->registerMetaTag([
                        'name' => 'keywords',
                        'content' => Yii::$app->params['hkej_meta_eng_keywords'],
            ]);


            Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->view->title,], 'og_title');
            Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'article'], 'og_type');
            Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => $fbarticleUrl], 'og_url');
            Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $imgUrl], 'og_image');
            Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => '620'], 'og:image:width');
            Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => '320'], 'og:image:height');
            Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => '信報網站 hkej.com'], 'og:site_name');
            Yii::$app->view->registerMetaTag(['property' => 'fb:admins', 'content' => 'writerprogram'], 'fb:admins');
            Yii::$app->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '160465764053571'], 'fb:app_id');
            Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => '信報網站(www.hkej.com)提供全天候即時香港股市、金融、經濟新聞資訊和分析，致力與讀者一起剖釋香港、關注兩岸、放眼全球政經格局。'], 'og_description');
            //$this->view->title 

            /*$this->title = '信報網站 - 即時新聞 金融脈搏 獨立股票投資分析 政治經濟 名筆評論 - hkej.com';
            $meta_description = '信報網站(www.hkej.com)提供全天候即時香港股市、金融、經濟新聞資訊和分析，致力與讀者一起剖釋香港、關注兩岸、放眼全球政經格局。';
            $this->og='
                        <meta property="og:title" content="'.$this->title.'"/>
                        <meta property="og:type" content="article"/>
                        <meta property="og:url" content="'.$fbarticleUrl.'"/>
                        <meta property="og:image" content="'.$imgUrl .'"/>
                        <meta property="og:site_name" content="信報網站 hkej.com"/>
                        <meta property="fb:admins" content="writerprogram"/>
                        <meta property="fb:app_id" content="'.$fb_appid.'"/>
                        <meta property="og:description"
                        content="'.$this->meta_description.'..."/>
            ';*/

            $this->view->params['trackEvent'] = array(
                    'category'=> 'HKEJ Mobile Landing PHP',
                    'action'=> 'LandingPage',
                    'label'=> 'CID:TOC',
            );


            return $this->render('index');

        } else{
            $this->redirect(Yii::$app->params['mainSiteUrl']);
        }
	}

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        
        $this->view->title = '信報網站 - 主頁 - 即時新聞 金融脈搏 獨立股票投資分析 政治經濟 名筆評論 - hkej.com - 信報網站 hkej.com';

		$this->layout = 'mobLayout';
		return parent::beforeAction($action);

	}


}

?>
