<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use uii\web\UrlManager;
//use yii\data\Pagination;
use yii\helpers\EjHelper;
use yii\helpers\Url;
use app\models\Article;
use app\models\Photo;
use app\models\InstantNews;
use app\models\Section;
use yii\data\Pagination;


class InstantnewsController extends Controller
{

	public $meta_description='';
    public $meta_keywords='';
    public $title='';

		public function actionAnnouncement()
		{
			Yii::$app->session->set('primarySection', 'announcement');
			$limit=25;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);

			$articles = $seven_days['articles'];

			//sticky
			$sectionId = Yii::$app->params['section2id']['sticky-announcement'];

			$sticky = EjHelper::section_filter_getsticky($sectionId, $articles);

			$filterBy ='4400'; 

			$article_bysection_1 = EjHelper::section_filter($filterBy, $articles);

			$filterBy = '4405';

			$article_bysection_2 = EjHelper::section_filter($filterBy, $articles);

			$article_bysection = array_merge($article_bysection_1, $article_bysection_2);
			$article_bysection = array_values($article_bysection);

			$filterBy = $sticky['id'];
			$article_bysection_all = array_filter($article_bysection, function ($var) use ($filterBy) {
						    return ($var['id'] != $filterBy);
			});

			//sort by publishDate desc
			usort($article_bysection_all, array($this, "date_compare"));

			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:重要通告'.'|PG:'.$page
		    );

			return $this->render('list', [
				'sticky'=>$sticky,
				'articles'=>$article_bysection,
				 'pagination' => $pagination,
				 'page'=>$page,
			]);


		}

		public function actionArticle($id){

			//trim id 
			$id = EjHelper::getFirstId($id); 

			$detect = Yii::$app->mobileDetect;
			
			$article = Article::findById($id);
			if ($article){
				Article::updateViewCnt($id);
				
				//allow only online news , hkex & property
				if(($article->catId != '1004') && ($article->catId != '1013') && ($article->catId!='1005')) {
					throw new \yii\web\HttpException(404,'The requested page does not exist.');
				}
				
				if (($article->catId=='1004') || ($article->catId=='1005'))  { //online news & property
		    		$sectionIds = Yii::$app->params['section2id']['instant-all'];
					$article=Article::findArticleById($id, $sectionIds);
					if (($article->catId=='1005')) {
						Yii::$app->session->set('primarySection', 'property');
					} else {
						Yii::$app->session->set('primarySection', $article->getSection()->nav);
					}
				} else if ($article->catId=='1013') { //hkex
					$sectionIds = Yii::$app->params['section2id']['hkex-all'];
					$article=Article::findArticleById($id, $sectionIds);
					Yii::$app->session->set('primarySection', $article->getSection()->nav);
				}

				if ($detect->isMobile() && !$detect->isTablet()) {

					$id = EjHelper::getFirstId($_SERVER["REQUEST_URI"]);
			   		$mobileURL = Yii::$app->params['mobilewebUrl'].$_SERVER["REQUEST_URI"];
			   		
			   		$mobileURL = preg_replace("%.com//%", '.com/', $mobileURL);
			   		$s=Yii::$app->session->get('primarySection');
			   		///instantnews/stock/article/11111/abc
			   		$mobileURL = preg_replace("%instantnews/$s/article/%", 'landing/mobarticle2/id/', $mobileURL);
			   		///instantnews/article?id=1111
			   		$mobileURL = str_replace("instantnews/article?id=","landing/mobarticle2?id=", $mobileURL);

			   		//echo $mobileURL;
			   		//die();
			   		/*$tmpURL=EjHelper::getFirstId($mobileURL)."?".str_replace("?", "&", $mobileURL);
			   		
					$mobileURL = str_replace("instantnews/article?id=","landing/mobarticle2/id/", $tmpURL*/					
					//echo $mobileURL;

			   		$this->redirect($mobileURL);
			   	} else {	
			   		

			   		$article->initPhotos();

			   		$photos = Photo::find()->where(['articleId'=>$article->id, 'attachmentType' => 'PHOTO', 'status'=> '1'])->orderBy(['photoOrder'=>SORT_ASC])->all();

					$videos = Photo::find()->where(['articleId'=>$article->id, 'attachmentType' => 'VIDEO', 'status'=> '1'])->orderBy(['photoOrder'=>SORT_ASC])->all();

					if ($article->subhead){
							$TTL_full=$article->subjectline.' '.$article->subhead;
					} else {
							$TTL_full=$article->subjectline;
					}

					$this->view->title =  $TTL_full . ' - 信報網站 hkej.com ';

					Yii::$app->view->registerMetaTag([
					        'name' => 'keywords',
					        'content' => '即時新聞 '.$article->getSection()->sectionLabel.$TTL_full . ' - 信報 信報網站 Hkej hkej.com',
					]);

					Yii::$app->view->registerMetaTag([
					        'name' => 'description',
					        'content' =>  EjHelper::recap($article->content, $len=200),
					]);

					Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->view->title], 'og_title');
					Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'article'], 'og_type');
					Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->params['www2Urlnoslash'].InstantNews::genArticleUrl($article)], 'og_url');

					if ($article->firstPhoto == '') {
						$imgUrl = Yii::$app->params['staticUrl'].'backup_img/generic_social.png'; 
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
					$label='DT:'.$article->publishDateLite.'|TID:'.$article->id.'|PID:|PSN:'.$article->getSection()->sectionLabel.'|AN:|CN:'.$article->storyProgName.'|TTL:'.$TTL_full;			
					$d=date('Y-m-d', strtotime($article->publishDate));
					
					$this->view->params['trackEvent']=array(
							'category'=> 'Instant news',
							'action'=> 'Article',
							'label'=> $label,
					);

					$fullarticle = true;

					$article->content=EjHelper::addStockLink($article->content);

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
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}
			
		}

		public function actionChina()
		{

			Yii::$app->session->set('primarySection', 'china');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$limit = 25;

			$articles = $seven_days['articles'];

			//sticky
			$sectionId = Yii::$app->params['section2id']['sticky-china'];

			$sticky = EjHelper::section_filter_getsticky($sectionId, $articles);

			//others

			$sectionId = Yii::$app->params['section2id']['instant-china'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//filter sticky from article list
			$filterBy = $sticky['id'];
			$article_bysection_all = array_filter($article_bysection_all, function ($var) use ($filterBy) {
						    return ($var['id'] != $filterBy);
						});

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:時事脈搏'.'|PG:'.$page
		    );

			return $this->render('list', ['sticky'=>$sticky,'articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);
		}


		public function actionCntw()
		{

			Yii::$app->session->set('primarySection', 'cntw');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$limit = 25;

			$articles = $seven_days['articles'];

			//others

			$sectionId = Yii::$app->params['section2id']['instant-cntw'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:兩岸'.'|PG:'.$page
		    );

			return $this->render('list', ['articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);

			

		}

		public function actionCurrent()
		{

			Yii::$app->session->set('primarySection', 'current');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$limit = 25;

			$articles = $seven_days['articles'];

			//sticky
			$sectionId = Yii::$app->params['section2id']['sticky-current'];

			$sticky = EjHelper::section_filter_getsticky($sectionId, $articles);

			//others

			$sectionId = Yii::$app->params['section2id']['instant-current'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//filter sticky from article list
			$filterBy = $sticky['id'];
			$article_bysection_all = array_filter($article_bysection_all, function ($var) use ($filterBy) {
						    return ($var['id'] != $filterBy);
						});

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:時事脈搏'.'|PG:'.$page
		    );

			return $this->render('list', ['sticky'=>$sticky,'articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);
			

		}

		public function actionListingeditorchoice()
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

			return $this->renderAjax('listing_editor_choice', [
	                'articles_bysection_1A'=>$articles_bysection_1A,
	                'articles_bycate_1A'=>$articles_bycate_1A,
	                'articles_bysection_1B'=>$articles_bysection_1B,
	                'articles_bycate_1B'=>$articles_bycate_1B,
	                'articles_bysection2'=>$articles_bysection2,
	                'articles_bycate2'=>$articles_bycate2,
	                'articles_bysection3'=>$articles_bysection3,
	                'articles_bycate3'=>$articles_bycate3,
	                ]);

	              // print_r($articles_bycate_1A);
		}

		public function actionHkex()
		{
			Yii::$app->session->set('primarySection', 'hkex');
			$limit=25;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/hkex_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);

			$articles = $seven_days['articles'];


			if(isset($_REQUEST['sectionCode']) && !empty($_REQUEST['sectionCode'])){
				$sectionId=Yii::$app->params['section2id'][$_REQUEST['sectionCode']];
				$filterBy =$sectionId; 
				$articles = EjHelper::section_filter($filterBy, $articles);
			} else {
				$articles = $articles;
			}

			//sticky
			/*$sectionId = Yii::$app->params['section2id']['sticky-announcement'];

			$sticky = EjHelper::section_filter_getsticky($sectionId, $articles);*/

			/*$filterBy ='14000'; 

			$article_bysection_1 = EjHelper::section_filter($filterBy, $articles);

			$filterBy = '14001';

			$article_bysection_2 = EjHelper::section_filter($filterBy, $articles);

			$article_bysection = array_merge($article_bysection_1, $article_bysection_2);
			$article_bysection_all = array_values($article_bysection);*/

			/*$filterBy = $sticky['id'];
			$article_bysection_all = array_filter($article_bysection, function ($var) use ($filterBy) {
						    return ($var['id'] != $filterBy);
			});*/

			//sort by publishDate desc
			//usort($article_bysection_all, array($this, "date_compare"));

			$start = $limit * ($page - 1);

			$article_bysection = array_slice($articles, $start, $limit);   

			

			$total = count($articles);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:港交所通告'.'|PG:'.$page
		    );

			return $this->render('list', [
				'articles'=>$article_bysection,
				 'pagination' => $pagination,
				 'page'=>$page,
			]);


		}

		public function actionHknews()
		{

			Yii::$app->session->set('primarySection', 'hknews');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$limit = 25;

			$articles = $seven_days['articles'];

			//others

			$sectionId = Yii::$app->params['section2id']['instant-hknews'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:港聞'.'|PG:'.$page
		    );

			return $this->render('list', ['articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);

			

		}

		public function actionHongkong()
		{

			Yii::$app->session->set('primarySection', 'hongkong');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$limit = 25;

			$articles = $seven_days['articles'];

			//sticky
			$sectionId = Yii::$app->params['section2id']['sticky-hongkong'];

			$sticky = EjHelper::section_filter_getsticky($sectionId, $articles);

			//others

			$sectionId = Yii::$app->params['section2id']['instant-hongkong'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//filter sticky from article list
			$filterBy = $sticky['id'];
			$article_bysection_all = array_filter($article_bysection_all, function ($var) use ($filterBy) {
						    return ($var['id'] != $filterBy);
						});

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:香港財經'.'|PG:'.$page
		    );

			return $this->render('list', ['sticky'=>$sticky,'articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);

			

		}


		public function actionIndex()
		{
			Yii::$app->session->set('primarySection', 'index');

			$limit = 25;

			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;

			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';

			$focus_json = Yii::getAlias('@app').'/assets/instantnewsWeb/focusarticles.json';

			// Get the contents of the JSON file 
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$strJsonFileContents_focus = file_get_contents($focus_json);

			// Convert to array 
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$focus = json_decode($strJsonFileContents_focus, true);
	
			if(isset($_REQUEST['date']) && !empty($_REQUEST['date'])){

				//validate date format
				if (EjHelper::validateDate($_REQUEST['date']) === false) {
					throw new \yii\web\HttpException(404,'The requested page does not exist.');
				} else {

					//calculate days interval
					$timestamp = time();		
					$req_date=date_create($_REQUEST['date']);
					$today_date=date_create(date('Y-m-d', $timestamp));		
					$interval = date_diff($req_date, $today_date);		
					$v=$interval->format('%a');
					//display error page when user enters a date 93 days older than today
					if ($v > 93) {
						throw new \yii\web\HttpException(404,'The requested page does not exist.');
					} else if ($v <= 7) {

						$articles = $seven_days['articles'];

						$filterBy = $_REQUEST['date']; 

						$article_bydate = array_filter($articles, function ($var) use ($filterBy) {
						    return ($var['publishDateLite'] == $filterBy);
						});

				   		//echo 'This is index';
				   		//return $this->render('index', ['articles_bydate'=>$articles, 'page'=>$page]);
						
						//echo $_REQUEST['date'].'<br>'; 
						$size = sizeof($article_bydate);
						//echo $size;
						$article_bydate2 = array_values($article_bydate);

						//pagination
						$start = $limit * ($page - 1);

						$article_bydate2 = array_slice($article_bydate2, $start, $limit);   

						$total = count($article_bydate);

						$pagination = new Pagination([
							'defaultPageSize' => $limit,
							'totalCount' => $total,
						]);


						$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:全部'.'|PG:'.$page
		        		);

						return $this->render('index', ['focusarticles'=>$focus, 'articles'=>$article_bydate2, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);


					} else { //older than 7 days

						$date = $_REQUEST['date'];

						$yyyy = date('Y', strtotime($date));
						$mm = date('m', strtotime($date));
						$dd = date('d', strtotime($date));
					
						$file = Yii::getAlias('@app').'/assets/instantnewsWeb/'.$yyyy.'/'.$mm.'/'.$dd.'/instantnews_'.$yyyy.$mm.$dd.'.json';


						if (file_exists($file) ==1) {
							// Get the contents of the JSON file 
							$strJsonFileContents = file_get_contents($file);

							// Convert to array 
							$article_by_day = json_decode($strJsonFileContents, true);

							$articles = $article_by_day['articles'];

							//pagination
							$start = $limit * ($page - 1);

							$article_bydate2 = array_slice($articles, $start, $limit);   

							$total = count($articles);

							$pagination = new Pagination([
								'defaultPageSize' => $limit,
								'totalCount' => $total,
							]);


							$this->view->params['trackEvent'] = array(
				                'category'=> 'Instant news ',
				                'action'=> 'Listing',
				                'label'=> 'PSN:全部'.'|PG:'.$page
				        		);
					
							
							//return $this->render('index', ['focusarticles'=>'', 'articles'=>$articles, 'page'=>$page]);
							//print_r($articles);

							return $this->render('index', ['focusarticles'=>$focus, 'articles'=>$article_bydate2, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);

						} else {

							$json = array();

							$sectionId = Yii::$app->params['section2id']['instant-all'];

							$range=isset($_REQUEST['range'])? $_REQUEST['range']: 7;

							$sectionId=str_replace(" ","", $sectionId); 


					        $sql =" FROM `v_active_article_year` ar ";
							$sql .=" JOIN article2section a2s ON ar.id = a2s.articleId ";
							$sql .=" WHERE 1 AND a2s.sectionId IN ( $sectionId) ";
							$sql .=" AND `publishDateLite` = '$date' ";
							$sql .=" GROUP BY ar.id  ";

							$sql .=" ORDER BY ar.publishDate desc ";
							
							$sqlData='SELECT ar.id,
								ar.pageNum,
								ar.authorId,
								ar.subhead,
								ar.subjectline,
								ar.orgStoryID,
								ar.publishDate,
								ar.recommend,
								ar.sequence,
								ar.publishStatus,
								ar.statusOnline,
								ar.status,
								LEFT(strip_tags(ar.content), 150) AS content,
								ar.catId,
								ar.sectionId,
								ar.viewCnt,
								ar.storyProgName,
								ar.expiryDate,
								ar.storySlug,
								ar.stockCode,
								ar.socialMedia,
								ar.abstract,
								ar.smAbstract,
								ar.smTitle,
								ar.importance,
								ar.elementText,
								ar.tag,
								ar.URL,
								ar.isNewWindow,
								ar.relatedArticleID,
								ar.firstPhoto,
								ar.firstVideo,
								ar.previewCode,
								ar.updated,
								ar.firstSection,
								ar.createTime,
								ar.submitTime,
								ar.lastUpdateTime,
								ar.publishDateLite,
								ar.m_sort,
								ar.dnews_id,
								ar.cas_title_id,
								ar.freeUntil' . $sql;			

							//er($sqlData);
							//echo $sqlData.'<br>';
							
							$query=Article::findBySql($sqlData);
							$articles = $query->all();

							$json['articles'] = $articles;
							$json['timestamp'] = date('Y-m-d H:i:s');
							$json['copyright_tc'] = '信報財經新聞有限公司版權所有，不得轉載。';
							$json['copyright_en'] = 'Hong Kong Economic Journal Co. Ltd. © All Rights Reserved.';


							if (isset($json['error']))
							{
								error_log('Error generating online news 7 days feed ' . $json['error']);

							}
							else if (isset($json['articles']) && count($json['articles']))
							{
								
								$ret = \yii\helpers\Json::encode($json);	

								$dir = dirname($file);
							
								mkdir($dir, 0777, true);
								error_log('Writing to ' . $file .': '. (file_put_contents($file, $ret)? 'SUCCESS': 'FAILURE'));
								chmod($file, 0777);

								$articles = $json['articles'];

								//pagination
								$start = $limit * ($page - 1);

								$article_bydate2 = array_slice($articles, $start, $limit);   

								$total = count($articles);

								$pagination = new Pagination([
									'defaultPageSize' => $limit,
									'totalCount' => $total,
								]);

								$this->view->params['trackEvent'] = array(
				                'category'=> 'Instant news ',
				                'action'=> 'Listing',
				                'label'=> 'PSN:全部'.'|PG:'.$page
				        		);
					
								return $this->render('index', ['focusarticles'=>$focus, 'articles'=>$article_bydate2, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);							
								//return $this->render('index', ['focusarticles'=>'', 'articles'=>$articles, 'page'=>$page]);
								}

						}
						
					}
				} //end validate date

			} else {

				$t = count($seven_days['articles']);
				$articles=EjHelper::takeOutDuplicated2($seven_days['articles'], $focus['articles'], $t); //take out duplicate from 焦點新聞
		
				//$p2 = EjHelper::takeOutDuplicated2( EjHelper::takeOutDuplicated2($seven_days['articles'], $articles, 35), $focus['articles'], 30); 

				//$p2 = EjHelper::takeOutDuplicated2($p2_1, $focus['articles'], 30); 

				//pagination
				$start = $limit * ($page - 1);

				$articles2 = array_slice($articles, $start, $limit);   

				$total = count($articles);

				$pagination = new Pagination([
					'defaultPageSize' => $limit,
					'totalCount' => $total,
				]);

				$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:全部'.'|PG:'.$page
		        );
		   		//echo 'This is index';
		   		return $this->render('index', ['focusarticles'=>$focus, 'articles'=>$articles2, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);
	   		}
	   	}

		public function actionInternational()
		{

			Yii::$app->session->set('primarySection', 'international');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$limit = 25;

			$articles = $seven_days['articles'];

			//sticky
			$sectionId = Yii::$app->params['section2id']['sticky-international'];

			$sticky = EjHelper::section_filter_getsticky($sectionId, $articles);

			//others

			$sectionId = Yii::$app->params['section2id']['instant-international'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//filter sticky from article list
			$filterBy = $sticky['id'];
			$article_bysection_all = array_filter($article_bysection_all, function ($var) use ($filterBy) {
						    return ($var['id'] != $filterBy);
						});

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:時事脈搏'.'|PG:'.$page
		    );

			return $this->render('list', ['sticky'=>$sticky,'articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);

			

		}

		public function actionIntlnews()
		{

			Yii::$app->session->set('primarySection', 'intlnews');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$limit = 25;

			$articles = $seven_days['articles'];

			//others

			$sectionId = Yii::$app->params['section2id']['instant-intlnews'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:國際'.'|PG:'.$page
		    );

			return $this->render('list', ['articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);

			

		}

		public function actionMarket()
		{

			Yii::$app->session->set('primarySection', 'market');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$limit = 25;

			$articles = $seven_days['articles'];

			//sticky
			$sectionId = Yii::$app->params['section2id']['sticky-market'];

			$sticky = EjHelper::section_filter_getsticky($sectionId, $articles);

			//others

			$sectionId = Yii::$app->params['section2id']['instant-market'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//filter sticky from article list
			$filterBy = $sticky['id'];
			$article_bysection_all = array_filter($article_bysection_all, function ($var) use ($filterBy) {
						    return ($var['id'] != $filterBy);
						});

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:時事脈搏'.'|PG:'.$page
		    );

			return $this->render('list', ['sticky'=>$sticky,'articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);

			

		}

		public function actionProperty()
		{

			Yii::$app->session->set('primarySection', 'property');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$limit = 25;

			$articles = $seven_days['articles'];

			//sticky
			$sectionId = Yii::$app->params['section2id']['sticky-instant-property'];

			$sticky = EjHelper::section_filter_getsticky($sectionId, $articles);

			//others

			$sectionId = Yii::$app->params['section2id']['instant-property'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//filter sticky from article list
			$filterBy = $sticky['id'];
			$article_bysection_all = array_filter($article_bysection_all, function ($var) use ($filterBy) {
						    return ($var['id'] != $filterBy);
						});

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:地產新聞'.'|PG:'.$page
		    );

			return $this->render('list', ['sticky'=>$sticky,'articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);

			

		}


		public function actionStock()
		{

			Yii::$app->session->set('primarySection', 'stock');
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$seven_days_json = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';
			$strJsonFileContents_7days = file_get_contents($seven_days_json);
			$seven_days = json_decode($strJsonFileContents_7days, true);
			$articles = $seven_days['articles'];
			$limit = 25;

			//sticky
			$sectionId = Yii::$app->params['section2id']['sticky-stock'];

			$sticky = EjHelper::section_filter_getsticky($sectionId, $articles);

			//others

			$sectionId = Yii::$app->params['section2id']['instant-stock'];
			
			$article_bysection = EjHelper::section_filter($sectionId, $articles);

			$article_bysection_all = array_values($article_bysection);

			//filter sticky from article list
			$filterBy = $sticky['id'];
			$article_bysection_all = array_filter($article_bysection_all, function ($var) use ($filterBy) {
						    return ($var['id'] != $filterBy);
						});

			//pagination
			$start = $limit * ($page - 1);

			$article_bysection = array_slice($article_bysection_all, $start, $limit);   

			$total = count($article_bysection_all);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Instant news ',
		                'action'=> 'Listing',
		                'label'=> 'PSN:港股直擊'.'|PG:'.$page
		    );

			return $this->render('list', ['sticky'=>$sticky,'articles'=>$article_bysection, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);


		}

		public function actionToparticlesjson() {
			$cacheKey='instantnewsMostPopular';
			$cache = Yii::$app->cache;
			$articles=$cache->get($cacheKey);

			
			if($articles==false){
 				$sectionIds = Yii::$app->params['section2id']['instant-hot'];
        		$articles = Article::findHotArticles($sectionIds, $limit=10, $interval=0.5);

				if(count($articles) > 0){
					// 120 seconds
					$cache->set($cacheKey, $articles, 120);
				}
			}
				

				$ary=array();
				foreach ($articles as $a) {
					  if ($a->catId !='1005'){
					      $section = Section::findById($a->firstSection);
					      $sectionLabel = $section->sectionLabel;
					  } else {
					      $sectionLabel = '地產新聞';
					  }

					$tmp['article_id']=$a->id;
					$tmp['subjectline']=$a->subjectline;
					$tmp['subhead']=$a->subhead;
					$tmp['catid']=$a->catId;
					$tmp['publish_date']=EjHelper::relative_date(strtotime($a->publishDate));			
					$tmp['sectionLabel']=$sectionLabel;
					if ($a->firstPhoto != '') {
						$tmp['thumb']=$a->imgUrl($size=620);
					} else {
						$tmp['thumb']='';
					}
					$ary[]=$tmp;
						
				}
				header('Content-type: application/json; charset=UTF-8');
				echo json_encode($ary);		
				exit;			
		}	

		public function actionGetarticlesbyrange()
		{
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			$json = array();

			//$file = Yii::$app->params['cache_path'] .'instantnewsWeb/instantnews_7days.json';

			$file = Yii::getAlias('@app').'/assets/instantnewsWeb/instantnews_7days.json';

			$sectionId = Yii::$app->params['section2id']['instant-all'];

			$range=isset($_REQUEST['range'])? $_REQUEST['range']: 7;

			$sectionId=str_replace(" ","", $sectionId); 
			$new_sectionId=str_replace(",","|", $sectionId); //4400, 4401, 4402, => 4400|4401|4402

	        $sql =" FROM `v_active_article` ar ";
			$sql .=" WHERE Concat(\",\", ar.sectionid, \",\") REGEXP \",($new_sectionId),\" ";
			
				if($range) {
					if ($range < 1) {
						$p= ceil($range * 24).' HOUR';
					}else{
						$p= "$range DAY";
					}
					$sql .=" AND (`publishDate` BETWEEN DATE_SUB(now() , INTERVAL $p) AND now( )) ";
					$sql .=" ORDER by ar.publishDate DESC";
				}


			$sqlData='SELECT ar.id,
				ar.pageNum,
				ar.authorId,
				ar.subhead,
				ar.subjectline,
				ar.orgStoryID,
				ar.publishDate,
				ar.recommend,
				ar.sequence,
				ar.publishStatus,
				ar.statusOnline,
				ar.status,
				LEFT(strip_tags(ar.content), 150) AS content,
				ar.catId,
				ar.sectionId,
				ar.viewCnt,
				ar.storyProgName,
				ar.expiryDate,
				ar.storySlug,
				ar.stockCode,
				ar.socialMedia,
				ar.abstract,
				ar.smAbstract,
				ar.smTitle,
				ar.importance,
				ar.elementText,
				ar.tag,
				ar.URL,
				ar.isNewWindow,
				ar.relatedArticleID,
				ar.firstPhoto,
				ar.firstVideo,
				ar.previewCode,
				ar.updated,
				ar.firstSection,
				ar.createTime,
				ar.submitTime,
				ar.lastUpdateTime,
				ar.publishDateLite,
				ar.m_sort,
				ar.dnews_id,
				ar.cas_title_id,
				ar.freeUntil' . $sql;			

			//er($sqlData);
			//echo $sqlData.'<br>';
			
			$query=Article::findBySql($sqlData);
			$articles = $query->all();

			$json['articles'] = $articles;
			$json['timestamp'] = date('Y-m-d H:i:s');
			$json['copyright_tc'] = '信報財經新聞有限公司版權所有，不得轉載。';
			$json['copyright_en'] = 'Hong Kong Economic Journal Co. Ltd. © All Rights Reserved.';

			//$ret = \yii\helpers\Json::encode($json);
			
			
			if (isset($json['error']))
			{
					error_log('Error generating online news 7 days feed ' . $json['error']);

			}
			else if (isset($json['articles']) && count($json['articles']))
			{
					//$dir = dirname($file);
					//echo $dir;
				
					//mkdir($dir, 0777, true);
					//error_log('Writing to ' . $file .': '. (file_put_contents($file, $ret)? 'SUCCESS': 'FAILURE'));
					//chmod($file, 0777);
					return $json;
			}

			//return $ret;
			//echo Yii::getAlias('@app');
			//return $json;

	   	}

	   	public function actionGetfocusarticles()
	   	{

	   		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			$json = array();

	   		//Sticky,焦點新聞
	        $focusCnt = 1;
	        $tmp = array();
	        $focus = array();
	        for ($focusCnt = 1; $focusCnt <= 5; $focusCnt++){

				$sectionId = Yii::$app->params['section2id']["sticky-focus{$focusCnt}"];
				$range=isset($_REQUEST['range'])? $_REQUEST['range']: 7;
				$sectionId=str_replace(" ","", $sectionId); 
				$new_sectionId=str_replace(",","|", $sectionId); //4400, 4401, 4402, => 4400|4401|4402

		        $sql =" FROM `v_active_article` ar ";
				$sql .=" WHERE Concat(\",\", ar.sectionid, \",\") REGEXP \",($new_sectionId),\" ";
				
					if($range) {
						if ($range < 1) {
							$p= ceil($range * 24).' HOUR';
						}else{
							$p= "$range DAY";
						}
						$sql .=" AND (`publishDate` BETWEEN DATE_SUB(now() , INTERVAL $p) AND now( )) ";
						$sql .=" ORDER by ar.publishDate DESC";
					}


				//$sqlData='SELECT ar.* ' . $sql;			

			$sqlData='SELECT ar.id,
				ar.pageNum,
				ar.authorId,
				ar.subhead,
				ar.subjectline,
				ar.orgStoryID,
				ar.publishDate,
				ar.recommend,
				ar.sequence,
				ar.publishStatus,
				ar.statusOnline,
				ar.status,
				LEFT(strip_tags(ar.content), 150) AS content,
				ar.catId,
				ar.sectionId,
				ar.viewCnt,
				ar.storyProgName,
				ar.expiryDate,
				ar.storySlug,
				ar.stockCode,
				ar.socialMedia,
				ar.abstract,
				ar.smAbstract,
				ar.smTitle,
				ar.importance,
				ar.elementText,
				ar.tag,
				ar.URL,
				ar.isNewWindow,
				ar.relatedArticleID,
				ar.firstPhoto,
				ar.firstVideo,
				ar.previewCode,
				ar.updated,
				ar.firstSection,
				ar.createTime,
				ar.submitTime,
				ar.lastUpdateTime,
				ar.publishDateLite,
				ar.m_sort,
				ar.dnews_id,
				ar.cas_title_id,
				ar.freeUntil' . $sql;	
				//er($sqlData);
				//echo $sqlData.'<br>';
				
				$query=Article::findBySql($sqlData);
				$articles_focus = $query->all();

	            //$focus=Article::findBySection(Yii::$app->params['section2id']["sticky-focus{$focusCnt}"], $range=7);
	            

	            if (is_array($articles_focus)){
	                $tmp[$focusCnt-1] = $articles_focus[0];
	            } else{
	                $tmp[$focusCnt-1] = $articles_focus;
	            }
	        }
	        $articles_focus = $tmp;
			$json['articles'] = $articles_focus;
			$json['timestamp'] = date('Y-m-d H:i:s');
			$json['copyright_tc'] = '信報財經新聞有限公司版權所有，不得轉載。';
			$json['copyright_en'] = 'Hong Kong Economic Journal Co. Ltd. © All Rights Reserved.';


			if (isset($json['error']))
			{
					error_log('Error generating online news 7 days feed ' . $json['error']);

			}
			else if (isset($json['articles']) && count($json['articles']))
			{
					return $json;
			}

	   	}

		public function actionGethkexarticlesbyrange()
		{
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			$json = array();

			//$file = Yii::$app->params['cache_path'] .'instantnewsWeb/instantnews_7days.json';

			$file = Yii::getAlias('@app').'/assets/instantnewsWeb/hkex_7days.json';

			$sectionId = Yii::$app->params['section2id']['hkex-all'];

			$range=isset($_REQUEST['range'])? $_REQUEST['range']: 7;

			$sectionId=str_replace(" ","", $sectionId); 
			$new_sectionId=str_replace(",","|", $sectionId); //4400, 4401, 4402, => 4400|4401|4402

	        $sql =" FROM `v_active_article` ar ";
			$sql .=" WHERE Concat(\",\", ar.sectionid, \",\") REGEXP \",($new_sectionId),\" ";
			
				if($range) {
					if ($range < 1) {
						$p= ceil($range * 24).' HOUR';
					}else{
						$p= "$range DAY";
					}
					$sql .=" AND (`publishDate` BETWEEN DATE_SUB(now() , INTERVAL $p) AND now( )) ";
					$sql .=" ORDER by ar.publishDate DESC";
				}


			$sqlData='SELECT ar.id,
				ar.pageNum,
				ar.authorId,
				ar.subhead,
				ar.subjectline,
				ar.orgStoryID,
				ar.publishDate,
				ar.recommend,
				ar.sequence,
				ar.publishStatus,
				ar.statusOnline,
				ar.status,
				LEFT(strip_tags(ar.content), 150) AS content,
				ar.catId,
				ar.sectionId,
				ar.viewCnt,
				ar.storyProgName,
				ar.expiryDate,
				ar.storySlug,
				ar.stockCode,
				ar.socialMedia,
				ar.abstract,
				ar.smAbstract,
				ar.smTitle,
				ar.importance,
				ar.elementText,
				ar.tag,
				ar.URL,
				ar.isNewWindow,
				ar.relatedArticleID,
				ar.firstPhoto,
				ar.firstVideo,
				ar.previewCode,
				ar.updated,
				ar.firstSection,
				ar.createTime,
				ar.submitTime,
				ar.lastUpdateTime,
				ar.publishDateLite,
				ar.m_sort,
				ar.dnews_id,
				ar.cas_title_id,
				ar.freeUntil' . $sql;			

			//er($sqlData);
			//echo $sqlData.'<br>';
			
			$query=Article::findBySql($sqlData);
			$articles = $query->all();

			$json['articles'] = $articles;
			$json['timestamp'] = date('Y-m-d H:i:s');
			$json['copyright_tc'] = '信報財經新聞有限公司版權所有，不得轉載。';
			$json['copyright_en'] = 'Hong Kong Economic Journal Co. Ltd. © All Rights Reserved.';

			//$ret = \yii\helpers\Json::encode($json);
			
			
			if (isset($json['error']))
			{
					error_log('Error generating online news 7 days feed ' . $json['error']);

			}
			else if (isset($json['articles']) && count($json['articles']))
			{
					//$dir = dirname($file);
					//echo $dir;
				
					//mkdir($dir, 0777, true);
					//error_log('Writing to ' . $file .': '. (file_put_contents($file, $ret)? 'SUCCESS': 'FAILURE'));
					//chmod($file, 0777);
					return $json;
			}

			//return $ret;
			//echo Yii::getAlias('@app');
			//return $json;

	   	}


    	public function beforeAction($action)
		{
			$detect = Yii::$app->mobileDetect;

            $action_id = Yii::$app->controller->action->id;

			if (($action_id != 'getarticlesbyrange') && ($action_id != 'getfocusarticles') && ($action_id != 'gethkexarticlesbyrange') && ($action_id != 'listingeditorchoice') && ($action_id != 'toparticlesjson') && ($action_id != 'article') && $detect->isMobile() && !$detect->isTablet()) {
            //if (($action_id != 'article') && $detect->isMobile() && !$detect->isTablet()) {
				$mobileURL = Yii::$app->params['mobilewebUrl'].$_SERVER["REQUEST_URI"];
				$mobileURL = preg_replace("%instantnews%", 'instantnewsmob', $mobileURL);
				$this->redirect($mobileURL);
			} else {

				// define meta tag
	            if (($action_id != 'article') && ($action_id != 'getarticlesbyrange') && ($action_id != 'getfocusarticles') && ($action_id != 'gethkexarticlesbyrange') && ($action_id != 'listingeditorchoice') && ($action_id != 'toparticlesjson')) {
		    		$this->view->title=Yii::$app->params['instantnewsMeta'][$action_id]['title'];
		    		$this->meta_description=Yii::$app->params['instantnewsMeta'][$action_id]['desc'];				
		    		$this->meta_keywords=Yii::$app->params['instantnewsMeta'][$action_id]['keywords'];
		    		if(empty($this->title)) //default
		    			$this->title='信報網站 - 即時新聞 金融脈搏 獨立股票投資分析 政治經濟 名筆評論 - hkej.com - 信報網站 hkej.com';


		            $fbarticleUrl = Yii::$app->params['www2Url'].'/'.Yii::$app->controller->id.'/'.$action_id;
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
		        	}

					$this->layout = 'webLayout';
		    		return parent::beforeAction($action);
	    	}
        }

        static function date_compare($element1, $element2)
		{
				$datetime1 = strtotime($element1['publishDate']);
				$datetime2 = strtotime($element2['publishDate']);
				return $datetime2 - $datetime1;
		}


}

?>