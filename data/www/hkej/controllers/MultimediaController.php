<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use uii\web\UrlManager;
//use yii\data\Pagination;
use yii\helpers\EjHelper;
use yii\helpers\Url;
use app\models\Article;
use app\models\Section;

class MultimediaController extends Controller
{
	public $meta_description='';
	public $meta_keywords='';
	public $title='';
	public $og='';

	//public $tag;
	public function init(){
    
    	$this->enableCsrfValidation = false;
	}

	public function actionTest($tag) {
		echo $tag;
		//$tag=trim($tag);
		//$tag=$_REQUEST['tag'];
		/*if (!$tag) {
			echo 'list all';
		} else {
		echo $tag;

		}*/
	}
	
	
	public function actionIndex()
	{
		$range=7;
		$sliderArticle1=Article::findBySection('26021, 26600', $range);
		$sliderArticle2=Article::findBySection('26022, 26601', $range);
		$sliderArticle3=Article::findBySection('26029, 26602', $range);
		$sliderArticle4=Article::findBySection('26030, 26603', $range);
		$sliderArticle5=Article::findBySection('26031, 26604', $range);
		$sliderArticle6=Article::findBySection('26032, 26605', $range);
		$slider_all=array_merge($sliderArticle1,$sliderArticle2,$sliderArticle3,$sliderArticle4,$sliderArticle5,$sliderArticle6);
		//$slider_all=array($sliderArticle1,$sliderArticle2,$sliderArticle3,$sliderArticle4,$sliderArticle5,$sliderArticle6);
		/*foreach ($slider_all as $s)
		{
			print_r($s);
			echo '<p>';
		}*/

		$this->view->params['trackEvent'] = array(
	                'category'=> 'Video',
	                'action'=> 'Landing',
	                //'label'=> 'CID:TOC',
	                'label'=> 'PSN:全部|PG:1',
	    );

		return $this->render('index',['slider_all'=>$slider_all]);
			/*if (($sticky) || ($articles)) {
	                 return $this->render('index', ['sticky'=>$sticky, 'articles'=>$articles ,'publishDate'=>$publishDate]);
	        } else {
	            echo '<!-- 信報視頻 no articles -->';
	        }*/
	}

	public function actionFinance()
	{
		$sectionId='26015';
		$limit=16;
		//$page=1;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$label='財經';
		$nav='finance';
		$range = '';
		$mode = '';
		$total = 1000;

		Yii::$app->session->set('primarySection', $nav);

		$class=EjHelper::findmmClassName($nav);
		if (isset($_REQUEST['tag']) && $_REQUEST['tag']!='所有'){
			$tag=$_REQUEST['tag'];
			$tag=addslashes(trim($tag));
			$list = Article::findAllByTag($tag, $sectionId, $limit, $page, $total);
		} else {
			$tag='所有';
			$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		}
		/*
		if ($tag=='所有') {
			$query = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
			$list = $query->all();
			//$list=Article::model()->findAllBySection('26015', $limit, $page, $total);
		} else {
			$query = Article::findAllByTag($tag, '26015', $limit, $page, $total);
			$list = $query->all();
		}*/


		$this->view->params['trackEvent']=array(
				'category'=> 'Video ',
				'action'=> 'ListingPage',
				'label'=> 'PSN:'.$label.'|PG:1'
		);

		if ($list) {
	                 return $this->render('listing', ['list'=>$list, 'class'=>$class ,'tag'=>$tag, 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode, 'total'=>$total]);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}

	public function actionHealth()
	{
		$sectionId='26023';
		$limit=16;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';
		$total = 1000;

		$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$label='信健康';
		$nav='health';
		Yii::$app->session->set('primarySection', $nav);
		$class=EjHelper::findmmClassName($nav);
		$this->view->params['trackEvent']=array(
				'category'=> 'Video ',
				'action'=> 'ListingPage',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));
		if ($list) {
	           return $this->render('listing', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode, 'total'=>$total, 'tag'=>'']);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}
	public function actionInterviews()
	{
		$sectionId='26018';
		$limit=16;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';
		$total = 1000;
		$label='人訪';
		$nav='interviews';
		Yii::$app->session->set('primarySection', $nav);
		$class=EjHelper::findmmClassName($nav);

		if (isset($_REQUEST['tag'])){
			$tag = $_REQUEST['tag'];
			$list = Article::findAllByTag($tag, $sectionId, $limit, $page, $total);
		} else {
			$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		}
		
		$this->view->params['trackEvent']=array(
				'category'=> 'Video ',
				'action'=> 'ListingPage',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));

		if ($list) {
	           return $this->render('listing', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode, 'total'=>$total, 'tag'=>'']);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}	

	public function actionListingresults()
	{
		$path='/multimedia/';
		$section= isset($_REQUEST['section'])? $_REQUEST['section']: '';
		//$no = $_POST['getresult'];
		$no = isset($_POST['getresult'])? $_POST['getresult']: 16;
		$page = isset($_POST['pageNum'])? $_POST['pageNum']: 1;
		$tag=isset($_REQUEST['tag'])? $_REQUEST['tag']: '所有';
		$tag=addslashes(trim($tag));
		if (empty($section)){
			$sectionId=Yii::$app->params['section2id']['mm-all'];
		} else {
			$sectionId=Yii::$app->params['section2id']['mm-'.$section];
		}
		$limit = 16;
		$range = '';
		if (empty($section)) {
			$sectionId=Yii::$app->params['section2id']['mm-all'];
			$list=Article::findAllByTag($tag, $sectionId, $limit, $page, $no);
			//print_r($list);
		} else if ($section=='finance') {

			if (isset($_REQUEST['tag']) && $_REQUEST['tag']!='所有'){
				$tag=$_REQUEST['tag'];
				$tag=addslashes(trim($tag));
				$list = Article::findAllByTag($tag, $sectionId, $limit, $page, $total);
			} else {
				$tag='所有';
				$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
			}

			/*if(empty($tag)){
				//throw new CHttpException(404,'The requested page does not exist.');
				$tag='EJ Markets';
				$list=Article::findAllByTag($tag, $sectionId, $limit, $page, $no);
			} else if ($tag=='所有') {
				$list=Article::findAllBySection($tag, $sectionId, $limit, $page, $no);
			} else {
				$list=Article::findAllByTag($tag, $sectionId, $limit, $page, $no);
			}*/
	
		} else {
			if(empty($tag)){
				$list=Article::findAllBySection($sectionId, $limit, $page, $no);
			} else {
				$list=Article::findAllByTag($tag, $sectionId, $limit, $page, $no);
			}
		}
	
	//echo $sectionId;

		foreach ($list as $l)
		{
			$tagLabel='';
			if (isset($l->tag)) {
					$tags = explode(",", $l->tag);
					$tagLabel = $tags[0];
			} else {
			  		$tagLabel = '';
			}
			$articleUrl=Yii::$app->params['www2Url'].'multimedia/view/id/'. $l->id;
			if($l->firstPhoto != ''){
				$imgUrl=$l->imgUrl($size=620);
			}else{
				$imgUrl=Yii::$app->params['staticUrl'].'images/generic_image_620.jpg';
			}
			?>
		              <div class="item">
			  
									 <div class="text">
										 <a href="<?=$path.'view/id/'.$l->id?>">	
										 <div class="pic"><span class="time"><?=$l->storyProgName?></span><span class="date"><?=EjHelper::relative_date(strtotime($l->publishDate))?></span><img src="<?=$l->imgUrl($size=620)?>" alt="<?=$l->subjectline?>" /> </div>
										 <h4><?=$l->subjectline?></h4>
		                           		 </a> 
										 
										 <?php 
										 
		                           		 if ($section !='health') {	
		                           		 		if (isset($mode)) {?>
		                           		 		<div class="subtext"><a href="<?=$path.'search/tag/'.$tagLabel?>"><?=$tagLabel?></a></div>
		                           		 <?php } else {?>
											 	<div class="subtext"><a href="<?=$path.$section.'/tag/'.$tagLabel?>"><?=$tagLabel?></a></div>
										 <?php } 
										 }?>
									</div> 
		              </div> 
					<?php 	
			}
			exit();
					
			
	}
		
	public function actionNews()
	{
		$sectionId='26017';
		$limit=16;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';
		$total = 1000;
		$label='新聞';
		$nav='news';
		Yii::$app->session->set('primarySection', $nav);

		if (isset($_REQUEST['tag'])){
			$tag = $_REQUEST['tag'];
			$list = Article::findAllByTag($tag, $sectionId, $limit, $page, $total);
		} else {
			$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		}
		
		$class=EjHelper::findmmClassName($nav);
		$this->view->params['trackEvent']=array(
				'category'=> 'Video ',
				'action'=> 'ListingPage',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));

		if ($list) {
	           return $this->render('listing', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode, 'total'=>$total, 'tag'=>'']);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}

	public function actionProperty()
	{
		$sectionId='26016';
		$limit=16;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';
		$total = 1000;

		$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		$label='地產';
		$nav='property';
		Yii::$app->session->set('primarySection', $nav);
		$class=EjHelper::findmmClassName($nav);
		$this->view->params['trackEvent']=array(
				'category'=> 'Video ',
				'action'=> 'ListingPage',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));

		if ($list) {
	           return $this->render('listing', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode, 'total'=>$total, 'tag'=>'']);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}	

	public function actionStartupbeat()
	{
		$sectionId='26019';
		$limit=16;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';
		$total = 1000;

		$label='Startupbeat';
		$nav='startupbeat';
		Yii::$app->session->set('primarySection', $nav);
		$class=EjHelper::findmmClassName($nav);

		if (isset($_REQUEST['tag'])){
			$tag = $_REQUEST['tag'];
			$list = Article::findAllByTag($tag, $sectionId, $limit, $page, $total);
		} else {
			$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		}
		

		$this->view->params['trackEvent']=array(
				'category'=> 'Video ',
				'action'=> 'ListingPage',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));

		if ($list) {
	           return $this->render('listing', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode, 'total'=>$total, 'tag'=>'']);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}	

	public function actionSearch($tag)
	{
		$limit=50;
		//$page=1;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		/*$tag=isset($_REQUEST['tag'])? $_REQUEST['tag']: 'EJ Markets';*/
		if(empty($tag)){
			//throw new CHttpException(404,'The requested page does not exist.');
			$tag='EJ Markets';
		}
		
		$tag=addslashes(trim($tag));

		$label=$tag;
		$nav='search';
		$range = '';
		$mode = '';
		$sectionId=Yii::$app->params['section2id']['mm-all'];
		$class=EjHelper::findmmClassName($nav);

		Yii::$app->session->set('primarySection', $nav);

		$list = Article::findAllByTag($tag, $sectionId, $limit, $page, $total);

		$this->view->params['trackEvent']=array(
				'category'=> 'Video ',
				'action'=> 'ListingPageMobile',
				'label'=> 'PSN:'.$tag.'|PG:1'
		);

		if ($list) {
	           return $this->render('list', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode]);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }

	}

	public function actionView($id)
	{
		$detect = Yii::$app->mobileDetect;
	
		//if device is not mobile, redirect to desktop version
		if ($detect->isMobile()) {
			$mobileURL = Yii::$app->params['www2Url'].$_SERVER["REQUEST_URI"];
			$mobileURL = preg_replace("%.com//%", '.com/', $mobileURL);
			$mobileURL = preg_replace("%multimediaMob/view%", 'multimedia/view', $mobileURL);
			$mobileURL = preg_replace("%multimediamob/view%", 'multimedia/view', $mobileURL);
			$this->redirect($mobileURL);

		} else {

			$article=Article::findById($id);
			//$article=Article::findArticleById($id, $sectionIds);

			if($article) {

				Article::updateViewCnt($id);

				$sectionNav=$this->findSectionNav($article);
				if ($sectionNav!='all') {
					$sectionNav=$sectionNav;
					$section=$article->getSection();
					$sectionTag=$section->sectionTag;
					$primarySection=Yii::$app->session->set('primarySection', $sectionNav);
					$className = $this->findClassName($sectionNav);

				} else {
					$section=$this->findMatchedSectionNav($article->sectionId);
					$sectionNav=$section->sectionCode;
					$sectionTag=$section->sectionLabel;
					$primarySection=Yii::$app->session->set('primarySection', $sectionNav);
					$className = $this->findClassName($sectionNav);
				}
				
				if ($article->subhead){
						$TTL_full=$article->subjectline.' '.$article->subhead;
				} else {
						$TTL_full=$article->subjectline;
				}

				$this->view->title =  $TTL_full . ' - 信報網站 hkej.com ';

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
				Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->params['mobilewebUrl'].'/multimediamob/view/id/'.$article->id], 'og_url');

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
				
				$label='DT:'.$article->publishDateLite.'|TID:'.$article->id.'|PID:|PSN:'.$sectionTag.'-'.$article->getSection()->sectionLabel.'|AN:|CN:|TTL:'.$TTL_full;		

				$this->view->params['trackEvent']=array(
						'category'=> 'Video ',
						'action'=> 'ArticlePage',
						'label'=> $label,
				);

				return $this->render('view', compact('article', 'sectionTag', 'section', 'sectionNav', 'className'));
		
			} else {
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}
		}

	}

	public function findClassName($nav) {
		$aryNav=Yii::$app->params['mmClassName'];
		foreach($aryNav as $k=>$v){
			if ($nav==$k) {
				return $v;
			}
		}
	}

	public function findMatchedSectionNav($s) {
		//$s='7700,26015,7706,26012';
		$sectionIds=Yii::$app->params['section2id']['mm-all'];
	
		/*echo $s;
			echo '<hr>';
		echo $sectionIds;*/
	
		$a1=(explode(',',$s));
		$a2=(explode(',',$sectionIds));
	
		$result=array_intersect($a1,$a2);
		$result=(array_values($result));
	
		if (isset($result[0])) {
			$r=$result[0];
			$section=Section::findById($r);
			//echo count($ss);
			//echo $ss->sectionCode;
			return $section;
		} else {
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}
	
	}

	public function findSectionNav($article) {
		$section=$article->getSection();
		$sectionId=$section->id;
		$sectionIds=Yii::$app->params['section2id']['mm-all'];
	
		$pos = strpos($sectionIds, $sectionId);
			
		if ($pos !== false){
			return $section->sectionCode;
		} else {
			return 'all';
				
		}
	}
   	public function beforeAction($action)
	{
		$detect = Yii::$app->mobileDetect;
		
		//if device is mobile, redirect to mobile version
		if ($detect->isMobile() && !$detect->isTablet() && (stripos($_SERVER['REQUEST_URI'], "article")===false) ) {

			$mobileURL = Yii::$app->params['mobilewebUrl'].$_SERVER["REQUEST_URI"];
			$mobileURL = preg_replace("%multimedia%", 'multimediamob', $mobileURL);
			$this->redirect($mobileURL);

		} else {

			$action_id = Yii::$app->controller->action->id;
			// define meta tag
	        
			$this->view->title=Yii::$app->params['mm_meta_title'];
			$this->meta_description=Yii::$app->params['mm_meta_desc'];				
			$this->meta_keywords=Yii::$app->params['mm_meta_keywords'];
			//$this->meta_eng_keywords=Yii::$app->params['hkej_meta_eng_keywords'];
			if(empty($this->title)) //default
				$this->title='信報視頻 - 信報網站 hkej.com';


	        $fbarticleUrl = Yii::$app->params['www2Url'].Yii::$app->controller->id.'/'.$action_id;
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



}