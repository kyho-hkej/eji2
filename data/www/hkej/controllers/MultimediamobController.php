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

class MultimediamobController extends Controller
{
	public $meta_description='';
	public $meta_keywords='';
	public $title='';
	public $og='';

	//public $tag;

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
	                'action'=> 'LandingPageMobile',
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
		$limit=50;
		//$page=1;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$label='財經';
		$nav='finance';
		$range = '';
		$mode = '';

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
				'action'=> 'ListingPageMobile',
				'label'=> 'PSN:'.$label.'|PG:1'
		);

		if ($list) {
	                 return $this->render('list', ['list'=>$list, 'class'=>$class ,'tag'=>$tag, 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode]);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}

	public function actionHealth()
	{
		$sectionId='26023';
		$limit=50;
		//$page=1;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';

		$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
		$label='信健康';
		$nav='health';
		Yii::$app->session->set('primarySection', $nav);
		$class=EjHelper::findmmClassName($nav);
		$this->view->params['trackEvent']=array(
				'category'=> 'Video ',
				'action'=> 'ListingPageMobile',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));
		if ($list) {
	           return $this->render('list', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode]);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}
	public function actionInterviews()
	{
		$sectionId='26018';
		$limit=50;
		//$page=1;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';
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
				'action'=> 'ListingPageMobile',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));

		if ($list) {
	           return $this->render('list', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode]);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}	
	public function actionNews()
	{
		$sectionId='26017';
		$limit=50;
		//$page=1;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';

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
				'action'=> 'ListingPageMobile',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));

		if ($list) {
	           return $this->render('list', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode]);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}

	public function actionProperty()
	{
		$sectionId='26016';
		$limit=50;
		//$page=1;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';

		$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		$label='地產';
		$nav='property';
		Yii::$app->session->set('primarySection', $nav);
		$class=EjHelper::findmmClassName($nav);
		$this->view->params['trackEvent']=array(
				'category'=> 'Video ',
				'action'=> 'ListingPageMobile',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));

		if ($list) {
	           return $this->render('list', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode]);
	    } else {
	            echo '<!-- 信報視頻 no articles -->';
	    }
	}	

	public function actionStartupbeat()
	{
		$sectionId='26019';
		$limit=50;
		//$page=1;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$range = '';
		$mode = '';
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
				'action'=> 'ListingPageMobile',
				'label'=> 'PSN:'.$label.'|PG:1'
		);
		//$this->render('list', compact('list', 'label', 'class', 'nav', 'total'));

		if ($list) {
	           return $this->render('list', ['list'=>$list, 'class'=>$class , 'nav'=>$nav, 'label'=>$label, 'mode'=>$mode]);
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
		if (!$detect->isMobile() && $detect->isTablet()) {
			$desktopURL = Yii::$app->params['www2Url'].$_SERVER["REQUEST_URI"];
			$desktopURL = preg_replace("%.com//%", '.com/', $desktopURL);
			$desktopURL = preg_replace("%multimediaMob/view%", 'multimedia/view', $desktopURL);
			$desktopURL = preg_replace("%multimediamob/view%", 'multimedia/view', $desktopURL);
			$this->redirect($desktopURL);

		} else {

			$article=Article::findById($id);
			//$article=Article::findArticleById($id, $sectionIds);

			if($article) {

				//Article::updateViewCnt($id);

				$sectionNav=$this->findSectionNav($article);
				if ($sectionNav!='all') {
					$sectionNav=$sectionNav;
					$section=$article->getSection();
					$sectionTag=$section->sectionTag;
					$primarySection=Yii::$app->session->set('primarySection', $sectionNav);

				} else {
					$section=$this->findMatchedSectionNav($article->sectionId);
					$sectionNav=$section->sectionCode;
					$sectionTag=$section->sectionLabel;
					$primarySection=Yii::$app->session->set('primarySection', $sectionNav);
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
						'action'=> 'ArticlePageMobile',
						'label'=> $label,
				);

				$this->view->params['woopraEvent']=array(
						'category'=> 'Video ',
						'action'=> 'ArticlePageMobile',
                        'ej_publish_date'=> $article->publishDateLite,
                        'ej_article_id'=> $article->id,
                        'ej_dnews_section'=> '',
                        'ej_paper_pg_section'=> '',
                        'ej_paper_art_section'=> $article->getSection()->sectionLabel,
                        'ej_author'=> '',
                        'ej_column'=> $article->storyProgName,
                        'ej_title'=> $TTL_full,
                        'ej_member_type' => EjHelper::checkmemberType()
                        );

		        /*dfp keyword targetting */
		        $this->view->params['dfp_keyword']=array(
		                            'keyword' => $article->tag,
		                            'stockcode' => $article->stockCode,
		        );

				if (strpos($article->sectionId, '26683') == true){ //YT Layout
					return $this->render('view_youtube', compact('article', 'sectionTag', 'section', 'sectionNav'));
				} else {		
					return $this->render('view', compact('article', 'sectionTag', 'section', 'sectionNav'));
				}
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

        if ($detect->isMobile() && !$detect->isTablet()) {

			$action_id = Yii::$app->controller->action->id;
			// define meta tag
	        
			$this->view->title=Yii::$app->params['mm_meta_title'];
			$this->meta_description=Yii::$app->params['mm_meta_desc'];				
			$this->meta_keywords=Yii::$app->params['mm_meta_keywords'];
			//$this->meta_eng_keywords=Yii::$app->params['hkej_meta_eng_keywords'];
			if(empty($this->title)) //default
				$this->title='信報視頻 - 信報網站 hkej.com';


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

	        //create or remove header cookie on landing page
			if (Yii::$app->controller->action->id == 'index') {
		        $cookies = Yii::$app->response->cookies;

				if(isset($_REQUEST['noheader']) && !empty($_REQUEST['noheader'])){

					if ($_REQUEST['noheader'] == 1) {

							$cookies->add(new \yii\web\Cookie([
						    'name' => 'noheader',
						    'value' => '1',
							]));

						//Yii::$app->getRequest()->getCookies()->getValue('noheader') == 1;

					} else if ($_REQUEST['noheader'] == -1) {
	
						$cookies->remove('noheader');
						//Yii::$app->getRequest()->getCookies()->getValue('noheader') == -1;
						
					} else {
						//Yii::$app->getRequest()->getCookies()->getValue('noheader') == -1;
					}
				} 
			}

	        if (Yii::$app->controller->action->id == 'view') {
	        	$this->layout = 'mobArticleLayout';
	        } else {
	        	$this->layout = 'mobLayout';
	        }
	    	
			return parent::beforeAction($action);

		} else {
                //$forwardURL = urlencode(app()->createAbsoluteUrl().$_SERVER["REQUEST_URI"]);
                $desktopURL = Yii::$app->params['www2Url'].$_SERVER["REQUEST_URI"];
                $desktopURL = preg_replace("%//multimediamob%", '/multimedia', $desktopURL);
                $desktopURL = preg_replace("%//multimediaMob%", '/multimedia', $desktopURL);
                //echo $desktopURL;
                $this->redirect($desktopURL);
        }

	}



}