<?php

namespace app\controllers;

use Yii;
//use yii\filters\AccessControl;
//use yii\base\Controller;

use yii\web\Controller;
use yii\data\Pagination;
use yii\helpers\EjiHelper;
use yii\helpers\Url;
use app\models\Article;
use app\models\Author;
use app\models\LoginForm;
use app\models\User;
use app\models\HKEJUser;

//use yii\web\Response;
//use yii\filters\VerbFilter;
//use app\models\LoginForm;
//use app\models\ContactForm;

class EjiController extends Controller
{	
	public $meta_description='';
	public $meta_keywords='';
	public $title='';
	public $catId='1002';
	
	public function actionAboutus()
	{
		$this->view->params['trackEvent'] = array(
				'category'=> 'EJINSIGHT',
				'action'=> 'About Us',
				'label'=> 'CID:EJINSIGHT-Contact Us',
		);
		return $this->render('aboutus');
	}

	public function actionArticle($id) 
	{
		//$id = isset($_REQUEST['id'])? $_REQUEST['id']:'';
		$query = Article::findById($id);
		//echo $query;
		$article = $query->all();

		if(isset($article[0])){
    		$article[0]=$article[0];
    		Article::updateViewCnt($id);
		} else {
			//throw new \yii\web\HttpException(404,'The requested page does not exist.');
			return $this->redirect('/site/errorpage');
			exit;
		}

		Yii::$app->view->registerMetaTag([
		        'name' => 'keywords',
		        'content' => 'ejinsight '.$article[0]->storySlug.' Hkej ejinsight.com',
		]);

		Yii::$app->view->registerMetaTag([
		        'name' => 'description',
		        'content' => 'ejinsight '.$article[0]->storySlug.' Hkej ejinsight.com',
		]);


		$author = Author::findOne($article[0]->authorId);
		if($author) {
			$authorName = $author->authorName;
		} else {
			$authorName = '';
		}

		$this->view->params['trackEvent'] = array(
				'category'=> 'EJINSIGHT',
				'action'=> 'Article Full',
				'label'=> 'EJI:Article|DT:'.$article[0]->publishDateLite.'|TID:'.$article[0]->id.'|AN:'.$authorName.'|CN:'.$article[0]->storyProgName.'|TTL:'.$article[0]->subjectline,
		);

		Article::updateViewCnt($id);
		
		return $this->render('article', [
            'article' => $article[0],
        ]);
		
	}

	public function actionAuthor($id)
	{
		//$id = isset($_REQUEST['id'])? $_REQUEST['id']:'';
		$limit=20;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$author = Author::findOne($id);
		$authorName = $author->authorName;
		$query=Article::find()
		->andWhere(
			'authorId=:authorId', [':authorId' => $id]
		)
		->andWhere('publishDateLite <= CURDATE()')
		->orderBy(['publishDateLite'=>SORT_DESC]);
		$countQuery = clone $query;
		$pagination = new Pagination([
			'defaultPageSize' => $limit,
			'totalCount' => $countQuery->count(),
		]);

		//echo $query->createCommand()->sql;

		$articles = $query->offset($pagination->offset)
        	->limit($pagination->limit)
        	->all();

        if (empty($articles)){
        	throw new \yii\web\HttpException(404,'The requested page does not exist.');    	
        } else {
			$articles = $articles;
        }

        //print_r($articles);

        Yii::$app->view->registerMetaTag([
		        'name' => 'keywords',
		        'content' => 'ejinsight '.html_entity_decode($authorName).' Hkej ejinsight.com',
		]); 

        Yii::$app->view->registerMetaTag([
		        'name' => 'description',
		        'content' => 'ejinsight '.html_entity_decode($authorName).' Hkej ejinsight.com',
		]); 

		$this->view->params['trackEvent'] = array(
				'category'=> 'EJINSIGHT',
				'action'=> 'Author',
				'label'=> 'CID:EJINSIGHT-'.html_entity_decode($authorName).'|PG:'.$page,
		);


		return $this->render('author_details', [
			'id' => $id,
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
	}

	public function actionColumnists()
	{
		echo 'columnists';
	}

	public function actionContactus()
	{
		$this->view->params['trackEvent'] = array(
				'category'=> 'EJINSIGHT',
				'action'=> 'Contact',
				'label'=> 'CID:EJINSIGHT-Contact Us',
		);

		return $this->render('contactus');
	}

	public function actionCategory($category)
	{

		if (($category=='business') || ($category=='hongkong') || ($category=='startups') || ($category=='world') || ($category=='living')) {
			
		//$sectionId='2185';

		$category=isset($category)? $category:'hongkong';


		//sticky article x 1 on top

		//$query_sticky=Article::findBySection(Yii::$app->params['section2id']['sticky-'.$category], $range=180);

		//$sticky = $query_sticky->all();

		//other articles
		$sectionId = Yii::$app->params['section2id'][$category];
		$limit=20;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total='';
		$range='';


		$query = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		//echo $total;

		//$countQuery = clone $query;
		$pagination = new Pagination([
			'defaultPageSize' => $limit,
			'totalCount' => $total,
		]);
		
		$articles = $query->offset($pagination->offset)
        	->limit($pagination->limit)
        	->all();

		//$articles=EjiHelper::takeOutDuplicated($tmp, $sticky, 20);
		/*
		$articles = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();*/

		//$articles=Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		//print_r($articles);

		Yii::$app->view->registerMetaTag([
		        'name' => 'keywords',
		        'content' => 'ejinsight '.$category.' Hkej ejinsight.com',
		]); 

		Yii::$app->view->registerMetaTag([
		        'name' => 'description',
		        'content' => 'ejinsight '.$category.' Hkej ejinsight.com',
		]); 


		$this->view->params['trackEvent'] = array(
				'category'=> 'EJINSIGHT',
				'action'=> 'ListingPage',
				'label'=> 'CID:EJINSIGHT-'.$category.'|PG:'.$page,
		);


		return $this->render('listing', [
			//'sticky' => $sticky,
            'articles' => $articles,
            'pagination' => $pagination,
            'page' => $page,
            'category' => $category,

        ]);


		} else {
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}

	}

	public function actionIndex()
	{		
		$slider_limit=2;
		$limit=4;
		$page=1;
		$total=4;
		$range=180;


		//landing slider
		//echo  Yii::$app->params['section2id']['eji-landing-slider'];
		$slider = Yii::$app->params['section2id']['eji-landing-slider'];
		$squery = Article::findAllBySection($slider, $slider_limit, $page, $total, $range);
		$slider_widget = $squery->all();

		//BUSINESS

		//$query_sticky1=Article::findBySection(Yii::$app->params['section2id']['sticky-business'], $range=180);
		//$sticky1 = $query_sticky1->all();

		$sid1 = Yii::$app->params['section2id']['business'];
		$query1 = Article::findAllBySection($sid1, $limit, $page, $total, $range);
		$widget1 = $query1->all();

		//$widget1=EjiHelper::takeOutDuplicated($tmp1, $sticky1, 3);

		//$widget1=array_merge($sticky1, $widget1);

		//STARTUPS
		$sid2 = Yii::$app->params['section2id']['startups'];
		$query2 = Article::findAllBySection($sid2, $limit, $page, $total, $range);
		$widget2 = $query2->all();

		//HONGKONG
		$sid3 = Yii::$app->params['section2id']['hongkong'];
		$query3 = Article::findAllBySection($sid3, $limit, $page, $total, $range);
		$widget3 = $query3->all();

		//WORLD
		$sid4 = Yii::$app->params['section2id']['world'];
		$query4 = Article::findAllBySection($sid4, $limit, $page, $total, $range);
		$widget4 = $query4->all();

		//LIVING
		$sid5 = Yii::$app->params['section2id']['living'];
		$query5 = Article::findAllBySection($sid5, $limit, $page, $total, $range);
		$widget5 = $query5->all();

		$query_hot = Article::findHotArticles($limit=10, $interval=14);
        $hot =  $query_hot->all();


		Yii::$app->view->registerMetaTag([
		       	'name' => 'keywords',
		        'content' => 'EJInsight hkej ejinsight.com',
		]);

		Yii::$app->view->registerMetaTag([
		        'name' => 'description',
		        'content' => 'EJInsight On the pulse',
		]);


		$this->view->params['trackEvent'] = array(
				'category'=> 'EJINSIGHT',
				'action'=> 'LandingPage',
				'label'=> 'CID:EJINSIGHT',
		);


		return $this->render('index', [
			'slider_widget' => $slider_widget,
            'widget1' => $widget1,
            'widget2' => $widget2,
            'widget3' => $widget3,
            'widget4' => $widget4,
            'widget5' => $widget5,
            //'trackEvent' => $trackEvent,
        ]);
	}

	public function actionIndex2()
	{		
		$query = Article::find();

		$pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);

		/*$articles = Yii::$app->db->createCommand('SELECT * FROM article order by publishDateLite DESC LIMIT 20')->queryAll();*/

	    $articles = $query->orderBy('publishDateLite DESC')
           ->offset($pagination->offset)
           ->limit($pagination->limit)
           ->all();
            	

        

		return $this->render('index', [
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
	}

	function formatDate($date)
	{
			$timestamp = '';
			$timestamp = strtotime($date);
			$timestamp = date("F d, Y H:i", $timestamp);
			return $timestamp;

	}
	
	public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
		//echo 'user id';

		//echo basename($incoming_url);
		

		
		$this->title='EJINSIGHT - ejinsight.com';
		/*Yii::$app->view->registerMetaTag([
		        'name' => 'description',
		        'content' => 'Description of the page...'
		    ]);

		Yii::$app->view->registerMetaTag(Yii::$app->params['og_title'], 'og_title');
    	Yii::$app->view->registerMetaTag(Yii::$app->params['og_description'], 'og_description');
    	Yii::$app->view->registerMetaTag(Yii::$app->params['og_url'], 'og_url');
    	Yii::$app->view->registerMetaTag(Yii::$app->params['og_image'], 'og_image');
		*/
		$this->layout = 'ejiv2Layout';
		return parent::beforeAction($action);

	}


	/*
	public function afterAction($action, $result)
	{
		$result = parent::afterAction($action, $result);
    	// your custom code here
    	$id = isset($_REQUEST['id']);
		if(isset($id)==''){
		//	echo $id;
			
		} else {
			Article::updateViewCnt($id);
		}
    	return $result;
		
	}*/




}