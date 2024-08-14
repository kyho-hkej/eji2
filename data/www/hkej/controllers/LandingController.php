<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use uii\web\UrlManager;
//use yii\data\Pagination;
use yii\helpers\EjHelper;
use yii\helpers\Url;
use app\models\Article;
use app\models\LJArticle;
use app\models\Photo;
use app\models\DailyNews;
use \serhatozles\simplehtmldom\SimpleHTMLDom;

//$consoleController = new \yii\commands\IndicesController;
//$consoleController->runAction('run');

class LandingController extends Controller
{

    public $meta_description='';
    public $meta_keywords='';
    public $title='';
    public $og='';

    //editor choice widget for desktop article page
    public function actionArticleeditorchoice()
	{

		$articles_bysection_1A = Article::findBySection2(Yii::$app->params['section2id']["sticky-ec1A"], $range=31);

        $articles_bycate_1A = Article::findBySection2(Yii::$app->params['section2id']["sticky-ec1B"], $range=31);
        //Editor Choice1B
        $limit=2; 
        $page=1; 
        $total=2;
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec1A2'], $limit, $page, $total, $range=31);     
        $articles_bysection_1B=EjHelper::takeOutDuplicated($tmp, $articles_bysection_1A, 1);
        
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec1B2'], $limit, $page, $total, $range=31);  
        $articles_bycate_1B=Ejhelper::takeOutDuplicated($tmp, $articles_bycate_1A, 1);
                                
        $articles_bysection=array_merge($articles_bysection_1A, $articles_bysection_1B);
        $articles_bycate=array_merge($articles_bycate_1A, $articles_bycate_1B);               
        

        //Editor Choice2
        $limit=5; 
        $page=1; 
        $total=5;
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec2A'], $limit, $page, $total, $range=31);  
        $articles_bysection2=Ejhelper::takeOutDuplicated($tmp, $articles_bysection, 3);       

        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec2B'], $limit, $page, $total, $range=31);   
        $articles_bycate2=Ejhelper::takeOutDuplicated($tmp, $articles_bycate, 3);     


        //Editor Choice3
        $limit=8; 
        $page=1; 
        $total=8;
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec3A'], $limit, $page, $total, $range=31);
        $tmp2=Ejhelper::takeOutDuplicated($tmp, $articles_bysection, 6);
        $articles_bysection3  = Ejhelper::takeOutDuplicated($tmp2, $articles_bysection2, 3);      
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec3B'], $limit, $page, $total, $range=31);
        $tmp2=Ejhelper::takeOutDuplicated($tmp, $articles_bycate, 6);
        $articles_bycate3  = Ejhelper::takeOutDuplicated($tmp2, $articles_bycate2, 3);

		return $this->renderAjax('article_editor_choice', [
                'articles_bysection_1A'=>$articles_bysection_1A,
                'articles_bycate_1A'=>$articles_bycate_1A,
                'articles_bysection_1B'=>$articles_bysection_1B,
                'articles_bycate_1B'=>$articles_bycate_1B,
                'articles_bysection2'=>$articles_bysection2,
                'articles_bycate2'=>$articles_bycate2,
                'articles_bysection3'=>$articles_bysection3,
                'articles_bycate3'=>$articles_bycate3
                ]);

		//echo \app\components\LandingEditorChoiceWidget::widget();
		//$this->widget('LandingEditorChoiceWidget');
	}

	public function actionArticleprint($id)
	{

		$article=Article::findById($id);
		
		if ($article) {
       
		    	if ($article->catId=='1004') { //online news
		    		$sectionIds = Yii::$app->params['section2id']['instant-all'];
					$article=Article::findArticleById($id, $sectionIds);
					$fullarticle = true;
				} else if ($article->catId=='1001') { //wm
					$sectionIds = $article->firstSection;
					$article=Article::findArticleById($id, $sectionIds);
					$fullarticle = true;
				} else if ($article->catId=='1005') { //property
					//$sectionIds = Yii::$app->params['section2id']['instant-property'];
					$sectionIds = $article->firstSection;
					$article=Article::findArticleById($id, $sectionIds);
					$fullarticle = true;
				} else if ($article->catId=='1013') { //hkex
					$sectionIds = Yii::$app->params['section2id']['hkex-all'];
					$article=Article::findArticleById($id, $sectionIds);
					$fullarticle = true;
				} else if ($article->catId=='1009') { //dailynews
					$article=Article::findDnewsArticleById($id);
					$ary=Yii::$app->params['dailynews_ga_mapping'];
					foreach($ary as $k=>$v){
						if ($article->getSection()->m_cat_Id == $k) {
							//echo $k.$v[0].$v[1];
							$cat_en=$v[0];
							$cat_cn=$v[1];
						}
					}
					if(Ejhelper::checkSubscription(Yii::$app->params['premiumPackageCode']) || $article->freeUntil > date('Y-m-d H:i') || ((Article::isFbShare($article->sectionId) == true) && (Article::checkFbreferer() == true)) || ((Article::isOpenday()!== false))) {
						$fullarticle = true;
					} else {
						$fullarticle = false;
					}

				} else {
					$sectionIds = $article->firstSection;
					//$article=Article::findById($id, $sectionIds);
					$article=Article::findArticleById($id, $sectionIds);
					$fullarticle = true;
				}

				$article->initPhotos();

				$photos = Photo::find()->where(['articleId'=>$article->id, 'attachmentType' => 'PHOTO', 'status'=> '1'])->orderBy(['photoOrder'=>SORT_ASC])->all();
				/*return $this->render('web_article_print', 
				[
					'article'=>$article, 
					'fullArticle'=>$fullarticle,
				]);	
				*/

		} else {
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}

		return $this->renderAjax('web_article_print', [
               			'article' => $article, 
               			'photos' => $photos,
               			'fullArticle' => $fullarticle,
        ]);

	}

    //to display top articles from online news 
    public function actionMostpopular(){
        if ($this->checkIP() == true) {
        $sectionIds = Yii::$app->params['section2id']['instant-hot'];
        $online_hot = Article::findHotArticles($sectionIds, $limit=10, $interval=1);

        return $this->renderAjax('most_popular', [
                        'online_hot' => $online_hot, 
        ]);
        } else {
            echo $_SERVER['REMOTE_ADDR'];
        }
    }

    //to display top articles from daily news 
    public function actionMostpopular2(){
        if ($this->checkIP() == true) {
        $daily_hot= DailyNews::findDNewsHotArticles($limit=10);
        return $this->renderAjax('most_popular_2', [
  
                        'daily_hot' => $daily_hot,

        ]);
        } else {
            echo $_SERVER['REMOTE_ADDR'];
        }
    }

    //to display top articles from health
    public function actionMostpopular3(){
        if ($this->checkIP() == true) {
        $ejh_sectionIds='25066,4512,20016,4513,20017,25067,4514,20018,25068,4515,20019,25069,4516,20020,25070,4517,20021,25071,26611,26612,26613,26614,26619,26621,26622,26623,26624,26625,26661,26663,26665,26676';

        $health_hot = Article::findHotArticles($ejh_sectionIds, $limit=10, $interval=7);

        return $this->renderAjax('most_popular_3', [
  
                        'health_hot' => $health_hot,

        ]);
        } else {
            echo $_SERVER['REMOTE_ADDR'];
        }
    }

    //to display top articles from lj
    public function actionMostpopular4(){
        if ($this->checkIP() == true) {
        $lj_sectionIds='3045, 3046, 3047, 3048, 3049, 3050, 3051, 3052, 3071, 3072, 3073, 3074, 3075, 3076, 3077, 3078, 3079, 3125';

        $lj_hot = LJArticle::findHotArticles($lj_sectionIds, $limit=10, $interval=7);

        //print_r($lj_hot);
        return $this->renderAjax('most_popular_4', [
  
                        'lj_hot' => $lj_hot,

        ]);
        } else {
            echo $_SERVER['REMOTE_ADDR'];
        }
    }

    //to display top articles from daily news A B C 疊
    public function actionMostpopular_a(){
        if ($this->checkIP() == true) {
        $pageNum = 'A';
        $daily_hot= DailyNews::findDNewsHotArticles2($limit=10, $pageNum);
        return $this->renderAjax('most_popular_2', [
  
                        'daily_hot' => $daily_hot,
                        'pageNum' => $pageNum,

        ]);
        } else {
            echo $_SERVER['REMOTE_ADDR'];
        }
    }

    public function actionMostpopular_b(){
        if ($this->checkIP() == true) {
        $pageNum = 'B';
        $daily_hot= DailyNews::findDNewsHotArticles2($limit=10, $pageNum);
        return $this->renderAjax('most_popular_2', [
  
                        'daily_hot' => $daily_hot,
                        'pageNum' => $pageNum,

        ]);
        } else {
            echo $_SERVER['REMOTE_ADDR'];
        }
    }

    public function actionMostpopular_c(){
        if ($this->checkIP() == true) {
        $pageNum = 'C';
        $daily_hot= DailyNews::findDNewsHotArticles2($limit=10, $pageNum);
        return $this->renderAjax('most_popular_2', [
  
                        'daily_hot' => $daily_hot,
                        'pageNum' => $pageNum,

        ]);
        } else {
            echo $_SERVER['REMOTE_ADDR'];
        }
    }
    public function actionEmbededitorchoice()
    {
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

    public function actionEmbedwebfeatures(){
        $s1=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header"], $range=365);
        $s2=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header2"], $range=365);
        $s3=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header3"], $range=365);
        $s4=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header4"], $range=365);
        $s5=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header5"], $range=365);

        $sticky = array_merge($s1, $s2, $s3, $s4, $s5);

        //print_r($photos);
        //print_r($sticky);
        if ($sticky) {
                return $this->renderAjax('embed_web_features', [
                'sticky' => $sticky,
            ]);
        } else {
            echo '<!-- features widget no articles -->';
        }
    }

    public function actionEmbedwebhkejwriter(){
        //echo DailyNews::getLatestPubDate();
        $publishDate=DailyNews::getLatestPubDate();

        $writerCnt = 1;
        $tmp = array();
        $articles = array();
        for ($writerCnt = 1; $writerCnt <= 6; $writerCnt++){
            $articles=Article::findBySectionPubdate(Yii::$app->params['section2id']["sticky-hkejwriter{$writerCnt}"], $limit=1, $publishDate=$publishDate);
            //print_r($query);

            if (is_array($articles)){
                $tmp[$writerCnt-1] = $articles[0];
            } else{
                $tmp[$writerCnt-1] = $articles;
            }
        }
        $articles_writer = $tmp;
        
        if ($articles_writer) {
        	//print_r($articles_writer);
                return $this->renderAjax('embed_web_hkejwriter', [
                'articles' => $articles_writer,
            ]);
        } else {
            echo '<!-- 信報手筆 last publish date is '. $publishDate.' pls select sticky articles -->';
        }

        
    }

    public function actionEmbedwebinstantnews(){

			$limit = 9;

		//	$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;

			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';

			$focus_json = Yii::getAlias('@app').'/assets/instantnewsWeb/focusarticles.json';

			// Get the contents of the JSON file 
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$strJsonFileContents_focus = file_get_contents($focus_json);

			// Convert to array 
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$focus = json_decode($strJsonFileContents_focus, true);
			
			//take out duplicate from 焦點新聞

			$t = count($seven_days['articles']);
			$articles=EjHelper::takeOutDuplicated2($seven_days['articles'], $focus['articles'], $t); 
			$articles = array_slice($articles, 1, $limit);  

			return $this->renderAjax('embed_web_instantnews', ['focusarticles'=>$focus, 'keynewsarticles'=>$articles]);

    }

    public function actionEmbedwebmultimedia(){
        $sectionId = Yii::$app->params['section2id']['multimedia-landing-sticky'];
        $limit = 6;
        $page = 1;
        $total = 4;
        $range =31;
        $articles = array();

        $articles=Article::findAllBySection($sectionId, $limit, $page, $total, $range);        

        if ($articles) {
                return $this->renderAjax('embed_web_multimedia', [
                'articles' => $articles,
            ]);
        } else {
            echo '<!--video widget no articles -->';
        }
    }   

   public function actionEmbedwebproperty(){
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
                return $this->renderAjax('embed_web_property', [
                'stickyarticle' => $sticky[0],
                'articles' => $articles,
            ]);
        } else {
            echo '<!--property widget no articles -->';
        }

        
    } 

	public function actionEmbedwebrightsidecol()
	{
	
		$magazine=Article::findBySection(Yii::$app->params['section2id']["landing-magazine"], $range=31);
		//Article::model()->findBySection(app()->params['section2id']['landing-magazine']);

        if ($magazine) {
                return $this->renderAjax('embed_web_right_side_col', [
                
                'magazine' => $magazine,
            ]);
        } else {
            echo '<!--right widget no articles -->';
        }
		//echo $this->renderPartial("embed_right_side_col_2016", array('magazine'=>$magazine));
	}

    public function actionEmbedwebstock360()
    {

        //notice
        $sectionId = Yii::$app->params['section2id']['instant-notice'];
        $limit = 10;
        $page = 1;
        $total = 1;
        $range =7;

        $articles=Article::findAllBySection($sectionId, $limit, $page, $total, $range);
        if ($articles) {
            foreach ($articles as $a) {         
                $notice .=$a->content;
            }
        } else {
            $notice = '';
        } 

        $indices_json = Yii::getAlias('@app').'/assets/landingWeb/indices.json';
        $strJsonFileContents_indices = file_get_contents($indices_json);
        $indices_arr = json_decode($strJsonFileContents_indices, true);
        $indices = $indices_arr['indices'];

        if ($indices) {
                return $this->renderAjax('embed_web_stock360', [       
                'indices' => $indices,
                'notice' => $notice,
            ]);
        } else {
            echo '<!--stock360 no indices info -->';
        }

    }

	public function actionEmbedwebweather(){
		return $this->renderAjax('embed_web_weather');
	}

	public function actionEmbedwebwm(){

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

		$lj=LJArticle::findAllBySectionLj(Yii::$app->params['section2id']['recommend-lj'], $limit, $page, $total, $range);

        //$array_tab2 = new CMap();

        $array_tab = [
             'general' => $general,
             'etf' => $etf,
             'fund' => $fund,
             'fx' => $fx,
             'mpf' => $mpf,
             'warrants' => $warrants,
             'smart' => $smart,
             'lj' => $lj
        ];


        
        
        if ($array_tab) {
                return $this->renderAjax('embed_web_wm', ['array_tab' => $array_tab]); 
        } else {
            echo '<!--wm widget no articles -->';
        }
		
		
       
    }
    
	public function actionIndex(){

        $detect = Yii::$app->mobileDetect;

        if (!$detect->isMobile() || ($detect->isTablet())) {
            $this->view->params['trackEvent']=array(
                    'category'=> 'HKEJ Landing PHP',
                    'action'=> 'LandingPage',
                    'label'=> 'CID:TOC',
            );

            return $this->render('index');

        } else { //redirect mobile article page if it's not desktop / tablet
               // echo 'mobile';
                $mobileURL = Yii::$app->params['mobilewebUrl'].$_SERVER["REQUEST_URI"];
                $mobileURL = preg_replace("%landing%", 'landingmob', $mobileURL);
                $this->redirect($mobileURL);
                //echo $mobileURL;

	   }
    }

    public function actionMobarticle2($id)
    {

        //echo $id;
        //exit;
    	$detect = Yii::$app->mobileDetect;

    	//step 1 lookup article  
    	//step 2 search article's prev,next,related articles
		$article=Article::findById($id);

		if ($article) {

			$cookie = isset($_COOKIE['HKEJ004'])? $_COOKIE['HKEJ004']: ''; 
			$q = str_replace("#", "", $article->tag);

				Article::updateViewCnt($id);
       
		    	if ($article->catId=='1004') { //online news
		    		$sectionIds = Yii::$app->params['section2id']['instant-all'];
					$article=Article::findArticleById($id, $sectionIds);
				} else if ($article->catId=='1001') { //wm
					$sectionIds = $article->firstSection;
					$article=Article::findArticleById($id, $sectionIds);
				} else if ($article->catId=='1005') { //property
					//$sectionIds = Yii::$app->params['section2id']['instant-property'];
					$sectionIds = $article->firstSection;
					$article=Article::findArticleById($id, $sectionIds);
				} else if ($article->catId=='1013') { //hkex
					$sectionIds = Yii::$app->params['section2id']['hkex-all'];
					$article=Article::findArticleById($id, $sectionIds);
				} else if ($article->catId=='1009') { //dailynews
					$article=Article::findDnewsArticleById($id);
					$ary=Yii::$app->params['dailynews_ga_mapping'];
					foreach($ary as $k=>$v){
						if ($article->getSection()->m_cat_Id == $k) {
							//echo $k.$v[0].$v[1];
							$cat_en=$v[0];
							$cat_cn=$v[1];
						}
					}
				} else {
					$sectionIds = $article->firstSection;
					//$article=Article::findById($id, $sectionIds);
					$article=Article::findArticleById($id, $sectionIds);
				}

				//redirect mobile article page if it's desktop / tablet
				if (!$detect->isMobile() || ($detect->isTablet())) {

					if ($article->catId=='1009'){				
						$this->redirect($this->genDnewsArticleUrl($article));				
					} else if ($article->catId=='1004'){
						$this->redirect($this->genArticleUrl($article));	
					} else if ($article->catId=='1001') { //wm
						$this->redirect($this->genWmArticleUrl($article));	
					} else if ($article->catId=='1005') { //property
						$this->redirect($this->genPropertyArticleUrl($article));	
					} else if ($article->catId=='1027') { //手筆
						$this->redirect($this->genHKEJWriterArticleUrl($article));
					} else {
						$this->redirect($this->genPromoArticleUrl($article));
					}
				}
				//end redirect 
		} else {
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}

		//print_r($article->content);
		/*
			 * GA event tracking		
		*/
//

		//if ($this->previewAllow($cookie,  $q)===true) {

		if (($this->previewAllow($cookie,  $q)===true) || EjHelper::isBDCode()) {

		$article->initPhotos();
		// preArticle & nextArticle
		/*$article->preArticle=$article->findPreInSection($sectionIds, $range=7);
		$article->nextArticle=$article->findNextInSection($sectionIds, $range=7);*/

		$photos = Photo::find()->where(['articleId'=>$article->id, 'attachmentType' => 'PHOTO', 'status'=> '1'])->orderBy(['photoOrder'=>SORT_ASC])->all();

		$videos = Photo::find()->where(['articleId'=>$article->id, 'attachmentType' => 'VIDEO', 'status'=> '1'])->orderBy(['photoOrder'=>SORT_ASC])->all();

		if ($article->subhead){
				$TTL_full=$article->subjectline.' '.$article->subhead;
		} else {
				$TTL_full=$article->subjectline;
		}

        if (($article->author) && ($article->storyProgName)){   
            $TTL_full_2 = ' - '.$article->author->authorName. ' - '. $article->storyProgName;
        } else if(($article->author) && !($article->storyProgName)) {
            $TTL_full_2 = ' - '.$article->author->authorName;
        } else if(!($article->author) && ($article->storyProgName)) {
            $TTL_full_2 = ' - '.$article->storyProgName;
        } else {
            $TTL_full_2 = '';
        }       

  
        if (($article->catId =='1004') || ($article->catId =='1013')){
            $TTL_cat = '即時新聞 - '. $article->getSection()->sectionLabel;
        } else if ($article->catId == '1009') {
            $TTL_cat = '今日信報 - '.$cat_cn;
        } else {
            $TTL_cat = '';
        }


		$this->view->title = $TTL_cat . ' - '. $TTL_full . $TTL_full_2 . ' - 信報網站 hkej.com ';

		Yii::$app->view->registerMetaTag([
		        'name' => 'keywords',
		        'content' => $TTL_full . ' - 信報網站 hkej.com ',
		]);

		Yii::$app->view->registerMetaTag([
		        'name' => 'description',
		        'content' =>  EjHelper::recap($article->content, $len=200),
		]);

		Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->title], 'og_title');
		Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'article'], 'og_type');
		Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->params['mobilewebUrl'].EjHelper::getMobArticleUrl($article)], 'og_url');

		if ($article->firstPhoto == '') {
			$imgUrl = '/images/backup_img/generic_social.png'; 
		} else {
			$imgUrl = $article->imgUrl();
		}

		Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $imgUrl], 'og_image');
		Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => '620'], 'og:image:width');
		Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => '320'], 'og:image:height');
		Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => '信報網站 hkej.com'], 'og:site_name');
		Yii::$app->view->registerMetaTag(['property' => 'fb:admins', 'content' => 'writerprogram'], 'fb:admins');
		Yii::$app->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '160465764053571'], 'fb:app_id');
		Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => EjHelper::recap($article->content, $len=200)], 'og_description');
		
		/*
		* for GA event tracking
		*/

		if ($article->catId == '1004') {
			$category = 'Online news';
		} else if ($article->catId == '1009') {
			$category = 'Daily news PHP';
		} else if ($article->catId == '1005') {
			$category = 'Property';
		} else if ($article->catId == '1001') {
			$category = 'Wealth Mng';
		} else if ($article->catId == '1021') {
			$category = 'Promoted Article';
		} else if ($article->catId == '1027') {
			$category = '信報手筆';
		} else {
			$category = 'HKEJ Article';
		}

        if ($article->author) {
                    $authorName = $article->author->authorName;
        } else {
                    $authorName = '';
        }

		$label='DT:'.$article->publishDateLite.'|TID:'.$article->id.'|PID:|PSN:'.$article->getSection()->sectionLabel.'|AN:|CN:'.$article->storyProgName.'|TTL:'.$TTL_full;			
		$d=date('Y-m-d', strtotime($article->publishDate));
		
		$this->view->params['trackEvent']=array(
				'category'=> $category,
				'action'=> 'Mobile Shared Article',
				'label'=> $label,
		);

        $this->view->params['woopraEvent']=array(
                        'category'=> $category,
                        'action'=> 'Mobile Shared Article',
                        'ej_publish_date'=> $article->publishDateLite,
                        'ej_article_id'=> $article->id,
                        'ej_dnews_section'=> '',
                        'ej_paper_pg_section'=> '',
                        'ej_paper_art_section'=> $article->getSection()->sectionLabel,
                        'ej_author'=> $authorName,
                        'ej_column'=> $article->storyProgName,
                        'ej_title'=> $TTL_full,
                        'ej_member_type' => EjHelper::checkmemberType()
                        );

		/*foreach($this->view->params['trackEvent'] as $event){
				//print_r($event);
				$trackEvent="'".$event['category']."', '".$event['action']."', '".$event['label']."'";
		}*/
        
        /*dfp keyword targeting */
        $this->view->params['dfp_keyword']=array(
                            'keyword' => $article->tag,
                            'stockcode' => $article->stockCode,
        );

		if ($article->catId == '1009') {

                $trial_cnt = Article::setTrialcnt();

				/*
				 * for GA event tracking
				*/
				$i2=substr($article->getSection()->m_cat_Id, 1);
				
				$ary=Yii::$app->params['dailynews_ga_mapping'];
				foreach($ary as $k=>$v){
					if ($article->getSection()->m_cat_Id == $k) {
						//echo $k.$v[0].$v[1];
						$cat_cn_new=$v[1];
					}
				}

				if ($article->author) {
					$authorName = $article->author->authorName;
				} else {
					$authorName = '';
				}

				$label='DT:'.$article->publishDateLite.'|TID:'.$article->id.'|CID:'.$i2.'-'.$cat_cn_new.'|PID:'.$article->getSection()->columnType.'|PSN:'.$cat_cn.'|AN:'.$authorName.'|CN:'.$article->storyProgName.'|TTL:'.$TTL_full;	

				if(Ejhelper::checkSubscription(Yii::$app->params['premiumPackageCode']) || $article->freeUntil > date('Y-m-d H:i') || ((Article::isFbShare($article->sectionId) == true) && (Article::checkFbreferer() == true)) || ((Article::isOpenday()!== false)) || ((Article::checkFbuseragent() == false) && ($trial_cnt<1) ) ) {

					if ($article->freeUntil > date('Y-m-d H:i')) {
						$action = 'TimeLimited';
					} else {
						$action = 'Mobile Shared Article - Full';
					}

					$this->view->params['trackEvent']=array(
					'category'=> $category,
					'action'=> $action,
					'label'=> $label,
					);

                    $this->view->params['woopraEvent']=array(
                    'category'=> $category,
                    'action'=> $action,
                    'ej_publish_date'=> $article->publishDateLite,
                    'ej_article_id'=> $article->id,
                    'ej_dnews_section'=> $i2.'-'.$cat_cn_new,
                    'ej_paper_pg_section'=> $article->getSection()->columnType,
                    'ej_paper_art_section'=> $cat_cn,
                    'ej_author'=> $authorName,
                    'ej_column'=> $article->storyProgName,
                    'ej_title'=> $TTL_full,
                    'ej_member_type' => EjHelper::checkmemberType()
                    );

					$fullarticle = true;
					return $this->render('article',
										[
											'nextArticle'=>$article->nextArticle,
											'preArticle'=>$article->preArticle,
											'article' => $article,
											'photos' => $photos,
											'videos' => $videos,
											'trackEvent'=> $label,
											'cat_en' => $cat_en,
											'cat_cn' => $cat_cn,

									]);

				} else {

						$this->view->params['trackEvent']=array(
						'category'=> $category,
						'action'=> 'Mobile Shared Article - Abstract',
						'label'=> $label,
						);

                        $this->view->params['woopraEvent']=array(
                            'category'=> $category,
                            'action'=> 'Mobile Shared Article - Abstract',
                            'ej_publish_date'=> $article->publishDateLite,
                            'ej_article_id'=> $article->id,
                            'ej_dnews_section'=> $i2.'-'.$cat_cn_new,
                            'ej_paper_pg_section'=> $article->getSection()->columnType,
                            'ej_paper_art_section'=> $cat_cn,
                            'ej_author'=> $authorName,
                            'ej_column'=> $article->storyProgName,
                            'ej_title'=> $TTL_full,
                            'ej_member_type' => EjHelper::checkmemberType()
                        );
						$fullarticle = false;
						return $this->render('article_abs',
										[
											'nextArticle'=>$article->nextArticle,
											'preArticle'=>$article->preArticle,
											'article' => $article,
											'photos' => $photos,
											'videos' => $videos,
											'trackEvent'=> $label,
											'cat_en' => $cat_en,
											'cat_cn' => $cat_cn,

									]);
				}
		} else if ($article->catId =='1007') {
			$url='/multimediamob/view/id/'.$article->id;
			//echo $url;
			$this->redirect($url);
		} else {
			
				$fullarticle = true;
				return $this->render('article',
									[
										'nextArticle'=>$article->nextArticle,
										'preArticle'=>$article->preArticle,
										'article' => $article,
										'photos' => $photos,
										'videos' => $videos,
										'trackEvent'=> $label,

								]);


		}

	} else {
		echo 'no access';
	}
    }

    public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        $this->view->title = '信報網站 - 即時新聞 金融脈搏 獨立股票投資分析 政治經濟 名筆評論 - hkej.com - 信報網站 hkej.com';

        if (Yii::$app->controller->action->id == 'index') {
        	$this->layout = 'webLayout';
        } else {
			$this->layout = 'mobArticleLayout';
		}
		return parent::beforeAction($action);

	}


	//for mobile article page ad insert after 1st paragraph 
	public function actionCodeconvert(){
		$id = $_GET["id"];
		//$article=DailyNews::findById($id);
		$article=Article::findById($id);	
		//start manipulate article content
		//\serhatozles\simplehtmldom\SimpleHTMLDom::file_get_html('http://google.com');

		// Create DOM from string
		$html = \serhatozles\simplehtmldom\SimpleHTMLDom::str_get_html($article->content);
		if ((strlen($html)>0 )) {

			foreach($html->find('div p') as $div){
				//find 1st <a>
				$a = $div->find('a',0);
				$img_org = $a->href;
				$title = $a->title;
                $title = str_replace('（','(', $title);
                $title = str_replace('）',')', $title);
				//find 1st <img>
                //echo $title;
				$img = $div->find('img',0);
				$img_src = $img->src;
				if($a && $img)
					$div->outertext = $this->getCodeTemplate($img_org, $img_src, $title);
                echo $a->title;
			}
			
			//save result
			$result = $html->save();	
			$article->content = $result;
		}
		return $article->content;
	}

	public function genArticleUrl($article)
	{

		// in case the section doesn't have "nav"
		$nav=$article->getSection(1004)->nav;
		if(empty($nav))
			$url=Yii::$app->params['www2Url'] . 'instantnews/article/id/'.$article->id.'/'.urlencode(str_replace('%', ' ', $article->subjectline));
		else
			$url=Yii::$app->params['www2Url'] . 'instantnews/'.$nav.'/article/'.$article->id.'/'.urlencode(str_replace('%', ' ', $article->subjectline));
		//echo url;
		return $url;
	}


	public function genDnewsArticleUrl($article)
	{
		$i=$article->getSection()->m_cat_Id;
		$s=Yii::$app->params['dailynews_cate_name'][$i];								
		$url=Yii::$app->params['www1Url'] . 'dailynews/'.$s.'/article/'. $article->id.'/'. urlencode(str_replace('%', ' ', $article->subjectline));
		return $url;
		//return Yii::$app->params['www1Url'].'dailynews/article/id/'.$article->id.'/'.urlencode( $article->subjectline);
	}

    public function getFirstId($inStr){
        //var_dump($inStr);
        //die;
        $output = 0;
            if (!empty($inStr)){
                preg_match_all('!\d+!', $inStr, $matches);
               
                var_dump($matches); 

                if (sizeof($matches[0])>0){
                    $output=$matches[0][0];
                }
            }
        return $output;
    }
	public function genHKEJWriterArticleUrl($article)
	{
		return Yii::$app->params['www1Url'] . 'hkejwriter/article/id/'.$article->id.'/'.urlencode( $article->subjectline);
	}

	public function genMMArticleUrl($article)
	{
		return Yii::$app->params['www2Url'] . 'multimedia/view/id/'.$article->id.'/'.urlencode( $article->subjectline);
	}

	public function genPropertyArticleUrl($article)
	{
		return Yii::$app->params['www2Url'] . 'property/article/id/'.$article->id.'/'.urlencode( $article->subjectline);
	}

	public function genPromoArticleUrl($article)
	{
		return Yii::$app->params['www2Url'] . 'editorchoice/article/id/'.$article->id.'/'.urlencode( $article->subjectline);
	}	

	public function genWmArticleUrl($article)
	{
		return Yii::$app->params['www2Url'] . 'wm/article/id/'.$article->id.'/'.urlencode( $article->subjectline);
	}


	private function getCodeTemplate($img_org, $img_src, $desc){
		$template =    '<div class="article_pic">
                       <!-- Lightbox IMAGE START -->
                       <div class="article">';
		$template .=  '<div class="m_lightbox article-img-container" itemscope itemtype="hkej_m_lightbox">'."\n";
		$template .= '<figure itemprop="hkej_m_lightbox" itemscope itemtype="hkej_m_lightbox">'."\n";
		$template .= '<a href="'.$img_org.'" itemprop="contentUrl" data-size=""  >'."\n";
		$template .= '<img src="'.$img_org.'"  class="fullsizeimg" style="display:none">'."\n";
		$template .= '<img src="'.$img_src.'" class="article-pic bottom-img"  itemprop="thumbnail" alt="'.$desc.'"/>'."\n";
		$template .= '</a>'."\n";
		$template .= '<figcaption itemprop="caption description">'.$desc.'</figcaption></figure>'."\n";
		$template .= '</div></div></div>'."\n";
		return $template;
	}

	function previewAllow($cookie, $tag){

		//專題預覽 for internal preview only
		
		if ($tag == '專題預覽') {
			if (isset($cookie) && ($cookie == 'M13')) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}	
	}

    function checkIp() {
        if ( (preg_match('/192.168./', $_SERVER['REMOTE_ADDR'])) || (preg_match('/118.140.209.61/', $_SERVER['REMOTE_ADDR'])) || (preg_match('/118.140.209.34/', $_SERVER['REMOTE_ADDR'])) || (preg_match('/218.255.249.34/', $_SERVER['REMOTE_ADDR'])) )
        {
            return true;
        }else{
            return false;
        }
    }
	/*private function getCodeTemplate2($img_org, $img_src, $desc){
		$template =  '<div class="article_pic">'."\n";
		$template .= '<img src="'.$img_org.'"  alt="'.$desc.'" title="'.$desc.'">'."\n";

		$template .= '</div>'."\n";
		return $template;

	}*/

}
