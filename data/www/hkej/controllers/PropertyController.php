<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use uii\web\UrlManager;
//use yii\data\Pagination;
use yii\helpers\EjHelper;
use yii\helpers\Url;
use app\models\Article;
use app\models\Author;
use app\models\Estate;
use app\models\Photo;
use app\models\InstantNews;
use yii\data\Pagination;


class PropertyController extends Controller
{
	public $meta_description='';
	public $meta_keywords='';
	public $title='';

	public function actionArticle($id){
			$detect = Yii::$app->mobileDetect;
			$article = Article::findById($id);
			if ($article) {
				Article::updateViewCnt($id);

		    		//$sectionIds = Yii::$app->params['section2id']['property-all'];
					$sectionIds = $article->getSection()->id;
					$article=Article::findArticleById($id, $sectionIds);

					Yii::$app->session->set('primarySection', $article->getSection()->nav);

					/*
					if (($article->catId=='1005')) {
						Yii::$app->session->set('primarySection', 'property');
					} else {
						Yii::$app->session->set('primarySection', $article->getSection()->nav);
					}*/

				if ($detect->isMobile() && !$detect->isTablet()) {
			   		$mobileURL = Yii::$app->params['mobilewebUrl'].$_SERVER["REQUEST_URI"];
			   		$mobileURL = preg_replace("%.com//%", '.com/', $mobileURL);
			   		$s=Yii::$app->session->get('primarySection');
			   		$mobileURL = preg_replace("%property/$s/article/%", 'landing/mobarticle2/id/', $mobileURL);
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

					$this->view->title = '信報地產投資 -- ' . $TTL_full;

					Yii::$app->view->registerMetaTag([
					        'name' => 'keywords',
					        'content' => '信報地產投資 '.$article->getSection()->sectionLabel.$TTL_full . ' - 信報 信報網站 Hkej hkej.com',
					]);

					Yii::$app->view->registerMetaTag([
					        'name' => 'description',
					        'content' =>  EjHelper::recap($article->content, $len=200),
					]);

					Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->view->title], 'og_title');
					Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'article'], 'og_type');
					Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->params['mobilewebUrl'].InstantNews::genArticleUrl($article)], 'og_url');

					if ($article->firstPhoto == '') {
						$imgUrl = '/images/backup_img/generic_social.png'; 
					} else {
						$imgUrl = $article->imgUrl();
					}

					Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $imgUrl], 'og_image');
					Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => '620'], 'og:image:width');
					Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => '320'], 'og:image:height');
					Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => '信報地產投資 hkej.com'], 'og:site_name');
					Yii::$app->view->registerMetaTag(['property' => 'fb:admins', 'content' => 'writerprogram'], 'fb:admins');
					Yii::$app->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '160465764053571'], 'fb:app_id');
					Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => EjHelper::recap($article->content, $len=200)], 'og_description');
				
					/*
					* for GA event tracking
					*/
					$label='DT:'.$article->publishDateLite.'|TID:'.$article->id.'|PID:|PSN:'.$article->getSection()->sectionLabel.'|AN:|CN:'.$article->storyProgName.'|TTL:'.$TTL_full;			
					$d=date('Y-m-d', strtotime($article->publishDate));
					
					$this->view->params['trackEvent']=array(
							'category'=> 'Property news',
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

	
	public function actionAuthordetail($id)
	{
		//$author=Author::findByPk($id);
		$author=Author::findOne($id);
		if($author===null)
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$limit=10;
		$total=count($author->articles);
		//$this->showSubMenu=true;
		//$author->updateViewCnt();
		//app()->ejLog->logAuthor($author);

		$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
		]);
        

		$this->view->params['trackEvent']=array(
				'category'=> 'Property news',
				'action'=> 'Listing',
				'label'=> 'CID:'.$author->authorName.'|PG:'.$page
		);
		
		return $this->render('author_detail', array(
				'author'=>$author,
				'page'=>$page,
				'total'=>$total,
				'pagination'=>$pagination
		)
		);
	}

	public function actionIndex()
	{
			Yii::$app->session->set('primarySection', 'index');

			//Top Slider
			$sectionId = Yii::$app->params['section2id']['index-sticky'];
			$limit=3;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=3;
			$range=180;
			$slider=Article::findAllBySection($sectionId, $limit, $page, $total, $range);

			//地產即時
			$sectionId = Yii::$app->params['section2id']['property-all'];
			$limit=4;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=4;
			$range=30;
			$latest_articles=Article::findAllBySection($sectionId, $limit, $page, $total, $range);

			//新盤情報
	    	$sticky=Article::findBySection(Yii::$app->params['section2id']['firsthand-sticky'], $range=7);
			$sectionId = Yii::$app->params['section2id']['firsthand'];
			$limit=5;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=5;
			$range=30;
			$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
			$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 4);
			$firsthand_articles=array_merge($sticky, $articles);

			//二手市場
	    	$sticky=Article::findBySection(Yii::$app->params['section2id']['secondhand-sticky'], $range=7);
			$sectionId = Yii::$app->params['section2id']['secondhand'];
			$limit=5;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=5;
			$range=30;
			$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
			$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 4);
			$secondhand_articles=array_merge($sticky, $articles);

			//工商舖市道
	    	$sticky=Article::findBySection(Yii::$app->params['section2id']['business-sticky'], $range=7);
			$sectionId = Yii::$app->params['section2id']['business'];
			$limit=5;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=5;
			$range=30;
			$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
			$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 4);
			$biz_articles=array_merge($sticky, $articles);

			$prop_articles = [
	             'latest' => $latest_articles,
	             'firsthand' => $firsthand_articles,
	             'secondhand' => $secondhand_articles,
	             'business' => $biz_articles
        	];


			$tabList = [
				'latest' => ['desc' => '地產即時', 'style' => 'cursor:pointer'],
				'firsthand' => ['desc' => '新盤情報', 'style' => 'cursor:pointer'],
				'secondhand' => ['desc' => '二手市場', 'style' => 'cursor:pointer'],
				'business' => ['desc' => '工商舖市道', 'style' => 'cursor:pointer']
			];


			//睇樓速遞
			$sticky=Article::findBySection(Yii::$app->params['section2id']['resident-sticky'], $range=7);
			$sectionId = Yii::$app->params['section2id']['resident'];
			$limit=3;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=3;
			$range=180;
			$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
			$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 3);
			$resident_articles=array_merge($sticky, $articles);


			//專家評論
			$sticky=Article::findBySection(Yii::$app->params['section2id']['opinion-sticky'], $range=7);
			$sectionId = Yii::$app->params['section2id']['opinion'];
			$limit=6;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=6;
			$range=30;
			$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
			$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 6);
			$opinion_articles=array_merge($sticky, $articles);


			//工商舖市道
			$sticky=Article::findBySection(Yii::$app->params['section2id']['business-sticky'], $range=7);
			$sectionId = Yii::$app->params['section2id']['business'];
			$limit=5;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=5;
			$range=30;
			$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
			$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 5);
			$biz_articles=array_merge($sticky, $articles);


			//屋苑樓價
			$sticky=Article::findBySection(Yii::$app->params['section2id']['estate-price-sticky'], $range=7);
			$sectionId = Yii::$app->params['section2id']['estate-price'];
			$limit=3;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=3;
			$range=30;
			$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
			$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 3);
			$estate_articles=array_merge($sticky, $articles);


			$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'LandingPage',
		                'label'=>  'PSN:全部'.'|PG:1'
		    );

		     return $this->render('index', [
            	'slider' => $slider,
            	'articlesMap'=>$prop_articles,
            	'tabList'=>$tabList,
            	'resident_articles'=>$resident_articles,
            	'opinion_articles'=>$opinion_articles,
            	'biz_articles'=>$biz_articles,
            	'estate_articles'=>$estate_articles,
        	]);

			//return $this->render('index');
	}

	public function actionBusiness(){

		Yii::$app->session->set('primarySection', 'business');
    	$sticky=Article::findBySection(Yii::$app->params['section2id']['business-sticky'], $range=7);

		//other articles
		$sectionId = Yii::$app->params['section2id']['business'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		
		$range='';

		$total=1000;

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 20);

		$articles=array_merge($sticky, $articles);

		//$total=count($articles);

		$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
		]);
        
		$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:工商舖市道'.'|PG:'.$page
		);        

		if ($articles) {
            return $this->render('list', [
            'articles' => $articles,
            'limit'=>$limit,
            'pagination'=>$pagination,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}

	/*public function actionDetail()
	{
		$e=trim($_REQUEST['estate']);
		if(empty($e)){
			$this->forward('index');
		}
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$limit=10;
		$sectionId=app()->params['section2id']['prop-all'];
		$this->articles=HKEJArticle::model()->findAllByTag($e, $sectionId, $limit, $page, $total);
		$estate=Estate::getByName($e);
		if($estate){
			$estate->viewCnt=$estate->viewCnt+1;
			$estate->save();
			$this->render('market_prices_details', compact('page', 'total', 'estate')		);
		}else{
			$this->render('market_prices_detail', compact('page', 'total', 'e')		);
		}
	}*/

	public function actionDetails($estate)
	{
		$_REQUEST['estate'] = $estate;
		$e=empty($_REQUEST['estate2'])? empty($_REQUEST['estate'])? '': trim($_REQUEST['estate']): trim($_REQUEST['estate2']);
		if(empty($e)){
			return Yii::$app->response->redirect('/property/index');
			//echo 'empty';
		}
		if(is_numeric($e))
			$estate=Estate::findById($e);
		else
			$estate=Estate::getByName($e);
		
		if ($estate) {
			$estate = $estate[0];
		} else {
			Yii::$app->session->setFlash('note', "你所選擇的屋苑在100個熱門屋苑名單之外，恕暫時未能提供該屋苑樓價及註冊量數據。");
			return Yii::$app->response->redirect('/property/marketprices');
		}
		
		//$estate=isset($estate[0])? $estate: '';


		if(!$estate || !$estate['updateDateTime']){
		//if($estate == ''){
			Yii::$app->session->setFlash('note', "你所選擇的屋苑在100個熱門屋苑名單之外，恕暫時未能提供該屋苑樓價及註冊量數據。");
			//app()->user->setFlash('note', '你所選擇的屋苑在100個熱門屋苑名單之外，恕暫時未能提供該屋苑樓價及註冊量數據。');
			//$this->forward('marketPrices');
			return Yii::$app->response->redirect('/property/marketprices');
		}
		
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$limit=10;
		$total=100;
		$sectionId=Yii::$app->params['section2id']['property-all'];
		$articles=Article::findAllByTag($estate['estateNameChi'], $sectionId, $limit, $page, $total);

		//print_r($articles);
		//$estate->viewCnt=$estate->viewCnt+1;
		//$estate->save();

		$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
		]);

		$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:屋苑樓價'.$estate['estateNameChi'].'|PG:'.$page
		);     

		echo $this->render('market_prices_details', compact('page', 'total', 'articles','estate', 'pagination')		);
	}
	

	public function actionFirsthand(){

		Yii::$app->session->set('primarySection', 'firsthand');
    	$sticky=Article::findBySection(Yii::$app->params['section2id']['firsthand-sticky'], $range=7);

		//other articles
		$sectionId = Yii::$app->params['section2id']['firsthand'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=1000;
		$range='';

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 20);

		$articles=array_merge($sticky, $articles);

		$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
		]);
        
		$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:新盤情報'.'|PG:'.$page
		);        

		if ($articles) {
            return $this->render('list', [
            'articles' => $articles,
            'limit'=>$limit,
            'pagination'=>$pagination,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}

	/**
	 * get estates by region
	 */
	public function actionGetestates($regionId)
	{
		if(!is_numeric($regionId)){
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}
		$estates=Estate::getByRegion($regionId);
		echo json_encode($estates);
	
	}
	
	

	public function actionLatest()
	{
			Yii::$app->session->set('primarySection', 'latest');
			
			$sectionId = Yii::$app->params['section2id']['property-all'];
			$limit=20;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=1000;
			$range='';

			$articles = Article::findAllBySection($sectionId, $limit, $page, $total, $range);


			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:即時新聞'.'|PG:'.$page
		    );

			return $this->render('list', ['articles'=>$articles, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);
	}

	public function actionMarketarticles(){
		Yii::$app->session->set('primarySection', 'marketprices');

		$stickyArticle=Article::findBySection(Yii::$app->params['section2id']['estate-price-sticky'], $range=7);

		$stickyArticle = $stickyArticle[0];

		//print_r($stickyArticle);

		if($stickyArticle){		
			$stickyEstate=Estate::getByArticleId($stickyArticle->id);
			$stickyEstateId=$stickyEstate["estateId"];
			$stickyEstate['articleId']=$stickyArticle->id;
			$stickyEstate['article']=$stickyArticle;

			//print_r($estate);
		}else{
			$stickyEstateId='';
		}
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$limit=20;
		$sectionId=Yii::$app->params['section2id']['estate-price'];
		$total=1000;

		$_REQUEST['regionId']=isset($_REQUEST['regionId'])? $_REQUEST['regionId']: '';
		if(is_numeric($_REQUEST['regionId']) ){
			$sectionId .= ','. $_REQUEST['regionId'];
			$selectedRegionId=$_REQUEST['regionId'];
		} else {
			$sectionId = $sectionId;
			$selectedRegionId=$_REQUEST['regionId'];
		}

		$articles=Article::findAllMatchSection($sectionId, $limit, $page, $total);
		$total=1000;

		$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
		]);

		foreach($articles as &$article){
			$article->estate=Estate::getByArticleId($article->id);
			//print_r($article->estate);
		}

		$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:屋苑樓價文章'.'|PG:'.$page
		);
		
		return $this->render('market_articles', 
			compact('stickyEstate', 'articles', 'selectedRegionId', 'page', 'total', 'limit', 'pagination'));

	}

	public function actionMarketprices(){
		Yii::$app->session->set('primarySection', 'marketprices');

		$stickyArticle=Article::findBySection(Yii::$app->params['section2id']['estate-price-sticky'], $range=7);

		$stickyArticle = $stickyArticle[0];

		if($stickyArticle){		
			
			$stickyEstate=Estate::getByArticleId($stickyArticle->id);
			$stickyEstateId=$stickyEstate["estateId"];
			$stickyEstate['articleId']=$stickyArticle->id;
			$stickyEstate['article']=$stickyArticle;

			//print_r($estate);
		}else{
			$stickyEstateId='';
		}
		$estates=Estate::randomByRegion($filter=$stickyEstateId);
		foreach ($estates as &$e){
			$e['article']=Estate::getLatestPriceArticleByEstate($e['estateNameChi'], Yii::$app->params['section2id']['estate-price']);			
			$e['regionName']=Yii::$app->params['property_region'][$e['regionId']];
		}

		//array_unshift($estates, $stickyEstate);
		//$estates=$estates[0]['article'];
		$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:屋苑樓價'.'|PG:1'
		);

		/*foreach ($estates as $e) {
			$a=$e['article'];
			$a=$a[0];
			echo $a['subjectline'];
			//print_r($a);
			//print_r($e['article']);
		}*/
		return $this->render('market_prices', [
				'sticky'=>$stickyEstate,
				'estates'=>$estates
		]);
		//print_r( $estates);
		
	}

	public function actionOpinion(){

		Yii::$app->session->set('primarySection', 'opinion');
    	$sticky=Article::findBySection(Yii::$app->params['section2id']['opinion-sticky'], $range=7);

		//other articles
		$sectionId = Yii::$app->params['section2id']['opinion'];
		$limit=7;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=7;
		$range='';

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 6);

		$articles=array_merge($sticky, $articles);

		$authors=Author::findAllBySection($sectionId, $limit=20, $page, $total, $order='au.priority ASC ');

		//print_r($authors);

		$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
		]);
        
		$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:專家評論'.'|PG:'.$page
		);        

		if ($articles) {
            return $this->render('opinion', [
            'articles' => $articles,
            'authors' => $authors,
            'limit'=>$limit,
            'page'=>$page,
            'pagination'=>$pagination,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}

	public function actionOpinionlist()
	{
			Yii::$app->session->set('primarySection', 'opinion');
			
			$sectionId = Yii::$app->params['section2id']['opinion'];
			$limit=20;
			$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
			$total=1000;
			$range='';

			$articles = Article::findAllBySection($sectionId, $limit, $page, $total, $range);

			$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
			]);

			$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:專家評論'.'|PG:'.$page
		    );

			return $this->render('list', ['articles'=>$articles, 'page'=>$page, 'limit'=>$limit,'pagination'=>$pagination]);
	}

	public function actionResident(){

		Yii::$app->session->set('primarySection', 'resident');
    	$sticky=Article::findBySection(Yii::$app->params['section2id']['resident-sticky'], $range=7);

		//other articles
		$sectionId = Yii::$app->params['section2id']['resident'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=1000;
		$range='';

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 20);

		$articles=array_merge($sticky, $articles);

		$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
		]);
        
		$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:睇樓速遞'.'|PG:'.$page
		);        

		if ($articles) {
            return $this->render('list', [
            'articles' => $articles,
            'limit'=>$limit,
            'pagination'=>$pagination,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}

	public function actionSecondhand(){

		Yii::$app->session->set('primarySection', 'secondhand');
    	$sticky=Article::findBySection(Yii::$app->params['section2id']['secondhand-sticky'], $range=7);

		//other articles
		$sectionId = Yii::$app->params['section2id']['secondhand'];
		$limit=21;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=1000;
		$range='';

		$tmp = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$articles=EjHelper::takeOutDuplicated($tmp, $sticky, 20);

		$articles=array_merge($sticky, $articles);

		$pagination = new Pagination([
				'defaultPageSize' => $limit,
				'totalCount' => $total,
		]);
        
		$this->view->params['trackEvent'] = array(
		                'category'=> 'Property news ',
		                'action'=> 'Listing',
		                'label'=>  'PSN:二手市場'.'|PG:'.$page
		);        

		if ($articles) {
            return $this->render('list', [
            'articles' => $articles,
            'limit'=>$limit,
            'pagination'=>$pagination,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}

	public function actionToolscalc()
	{
		Yii::$app->session->set('primarySection', 'toolscalc');
		$tsection=isset($_REQUEST['tsection'])? $_REQUEST['tsection']: 'toolscalc';
		$limit=1;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=1;
		$range='';

		switch ($tsection){
			case 'toolsmortgagefaq':
				$tmp='toolsmortgagefaq';
				$sectionId=Yii::$app->params['section2id']['toolsmortgagefaq'];
				$articles=Article::findAllBySection($sectionId, $limit, $page, $total, $range);
				break;
			case 'toolsmortgage':
				$tmp='toolsmortgage';
				$sectionId=Yii::$app->params['section2id']['toolsmortgage'];
				$articles=Article::findAllBySection($sectionId, $limit, $page, $total, $range);
				break;
			break;
			case 'toolstax':
				$tmp='toolstax';
				$sectionId=Yii::$app->params['section2id']['toolstax'];
				$articles=Article::findAllBySection($sectionId, $limit, $page, $total, $range);
				break;
			break;
			default:
				$tmp='toolscalc';
				$articles='';
				break;					
			}
			$this->view->params['trackEvent'] = array(
					'category'=> 'Property news',
					'action'=> 'Listing',
					'label'=> 'PSN:置業工具|PG:'.$page
			);			

			//if ($articles) {
	            return $this->render($tmp, [
	            'articles' => $articles,
	        	]);
        	/*} else {
            	throw new \yii\web\HttpException(404,'The requested page does not exist.');
        	}*/

	}


	public function beforeAction($action)
	{
			// define meta tag
	        $action_id = Yii::$app->controller->action->id;
			$this->view->title=Yii::$app->params['prop_meta_title'];
			$this->meta_description=Yii::$app->params['prop_meta_desc'];				
			$this->meta_keywords=Yii::$app->params['prop_meta_keywords'];
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
			$this->layout = 'webLayout';
    		return parent::beforeAction($action);

    }
}