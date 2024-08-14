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
use app\models\DailyNews;


class DailynewsController extends Controller
{

	public $meta_description='';
    public $meta_keywords='';
    public $title='';


    	public function actionArticle($id)
		{
			$article=Article::findById($id);

			if ($article) {

				Article::updateViewCnt($id);
				
				$article=Article::findDnewsArticleById($id);
				$ary=Yii::$app->params['dailynews_ga_mapping'];
					foreach($ary as $k=>$v){
						if ($article->getSection()->m_cat_Id == $k) {
							//echo $k.$v[0].$v[1];
							$cat_en=$v[0];
							$cat_cn=$v[1];
						}
					}

				$detect = Yii::$app->mobileDetect;

				if ($detect->isMobile() && !$detect->isTablet()) {
				//wrong pattern /dailynews/article/id/1683125/
				if (preg_match('/dailynews\/article/', $_SERVER["REQUEST_URI"]) ) {
					$mobileURL = Yii::$app->params['mobilewebUrl'].$_SERVER["REQUEST_URI"];
					$mobileURL = preg_replace("%.com//%", '.com/', $mobileURL);
					$mobileURL = preg_replace("%dailynews/article/id/%", 'landing/mobarticle2/id/', $mobileURL);
				} else {
					//echo 'correct url';
					$mobileURL = Yii::$app->params['mobilewebUrl'].$_SERVER["REQUEST_URI"];
					$mobileURL = preg_replace("%.com//%", '.com/', $mobileURL);
					$s=Yii::$app->session->get('primarySection');
					$mobileURL = preg_replace("%dailynews/$s/article/%", 'landing/mobarticle2/id/', $mobileURL);
				}
				//echo $mobileURL;	
				$this->redirect($mobileURL);
				}

			} else {
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

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


			$i = Article::getMcatid($article->firstSection);

			$nav=Yii::$app->params['dailynews_cate_name'][$i];
			Yii::$app->session->set('primarySection', $nav);

			$dnewsToday = $article->publishDateLite;
			$articles = Article::findAllByMasterCat($dnewsToday, $i);



			/*if(Yii::$app->session->get('primarySection')){
				$nav=Yii::$app->session->get('primarySection');

				$i=Yii::$app->params['dailynews_cate_id'][$nav];
				//echo $i;
				$dnewsToday = $article->publishDateLite;
				$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);
			}else{

				$i = Article::getMcatid($article->firstSection);
				$dnewsToday = $article->publishDateLite;
				$articles = Article::findAllByMasterCat($dnewsToday, $i);

			}*/
			


			/*
				 * for GA event tracking
			*/
				$category = 'Daily news PHP';

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

				$label='DT:'.$article->publishDateLite.'|TID:'.$article->id.'|CID:'.$i2.'-'.$cat_cn_new.'|PID:'.$article->getSection()->columnType.'|PSN:'.$article->getSection()->sectionLabel.'|AN:'.$authorName.'|CN:'.$article->storyProgName.'|TTL:'.$TTL_full;	

				if(Ejhelper::checkSubscription(Yii::$app->params['premiumPackageCode']) || $article->freeUntil > date('Y-m-d H:i') || (Article::isFbShare($article->sectionId) == true) || ((Article::isOpenday()!== false))) {

					if ($article->freeUntil > date('Y-m-d H:i')) {
						$action = 'Article - TimeLimited';
					} else {
						$action = 'Article - Full';
					}

					$this->view->params['trackEvent']=array(
					'category'=> $category,
					'action'=> $action,
					'label'=> $label,
					);

					$fullarticle = true;

					return $this->render('article',
										[
											'articles'=>$articles,
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
						'action'=> 'Article - Abstract',
						'label'=> $label,
						);
						$fullarticle = false;

						return $this->render('article_abs',
										[
											'articles'=>$articles,
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


		}

		public function actionAuthor()
		{
				//Yii::$app->session->set('primarySection', 'author');
				$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
				$type=isset($_REQUEST['type'])? $_REQUEST['type']: 'picked';
				$limit=100;
				$tab='';

				if ($type == 'allauthor') {
					//$type=$_REQUEST['type'];
					$tab='allauthor';
					$interval=365;
					//$stroke=$_REQUEST['stroke'];
					$stroke=isset($_REQUEST['stroke'])? $_REQUEST['stroke']: '';
				}else{
					//$type='picked';
					$tab='picked';
					$interval=365;
				}

				$cat=isset($_REQUEST['cat'])? $_REQUEST['cat']: '';
				$q=isset($_REQUEST['q'])? $_REQUEST['q']: '';
				$order=isset($_REQUEST['order'])? $_REQUEST['order']: 'l2m'; // l2m: less to more, m2l: more to less
				$stroke=isset($_REQUEST['stroke'])? $_REQUEST['stroke']: '';
				
				$authors=DailyNews::findPickedAuthors($interval, $page, $limit, $total, $tab, $cat, $order, $q, $stroke);

				
				return $this->render('author', compact(				
					'authors', 'limit', 'page', 'total', 'type', 'cat', 'order', 'q', 'stroke'
						) );
			
		}


	    public function actionCntw()
		{
			Yii::$app->session->set('primarySection', 'cntw');

	 		$i=Yii::$app->params['dailynews_cate_id']['cntw'];
			$cat=Yii::$app->params['dailynewsNav']['cntw'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news PHP',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => '兩岸消息',
	            'articles' => $articles,
	        ]);
	        } else {
	            throw new \yii\web\HttpException(404,'The requested page does not exist.');
	        }
			
		}

		public function actionCommentary()
		{
			Yii::$app->session->set('primarySection', 'commentary');

	 		$i=Yii::$app->params['dailynews_cate_id']['commentary'];
			$cat=Yii::$app->params['dailynewsNav']['commentary'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news PHP',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => '時事評論',
	            'articles' => $articles,
	        ]);
	        } else {
	            throw new \yii\web\HttpException(404,'The requested page does not exist.');
	        }
			
		}		

		public function actionCulture()
		{
			Yii::$app->session->set('primarySection', 'culture');

	 		$i=Yii::$app->params['dailynews_cate_id']['culture'];
			$cat=Yii::$app->params['dailynewsNav']['culture'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles1=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), 'I9');
			$articles2=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), 'I8');
			$tmp=array_merge($articles1, $articles2);
			$articles=Article::sortByMsort($tmp);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.'8,9-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => '副刊文化',
	            'articles' => $articles,
	        ]);
	        } else {
	            return $this->render('list_empty');
	        }
			

		}	

		public function actionFinnews()
		{
			Yii::$app->session->set('primarySection', 'finnews');

	 		$i=Yii::$app->params['dailynews_cate_id']['finnews'];
			$cat=Yii::$app->params['dailynewsNav']['finnews'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news PHP',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => '財經新聞',
	            'articles' => $articles,
	        ]);
	        } else {
	            throw new \yii\web\HttpException(404,'The requested page does not exist.');
	        }
			
		}	


		public function actionGettoc()
		{
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			$json = array();

			//$file = Yii::$app->params['cache_path'] .'instantnewsWeb/instantnews_7days.json';
			if(isset($_REQUEST['date']) && !empty($_REQUEST['date'])){
				$pub_date = $_REQUEST['date'];
				if (DailyNews::isPubDate($pub_date)==false) {
					exit();
				}
			} else {
				$pub_date = DailyNews::getLatestPubDate();
			}

			$pub_date2 = str_replace('-', '', $pub_date);


			$file = Yii::getAlias('@app').'/assets/dailynewsWeb/hkej_dailynews_'.$pub_date2.'_toc.json';

			
			$sectionId=Yii::$app->params['section2id']['a1-thumb'];
			$thumb=current(DailyNews::findAllBySection($sectionId, $pub_date));

			
			$keynews=DailyNews::findKeyNews($pub_date);
			
			
			$i=0;
			foreach ($keynews as $key) {
				if ($i==0) {
					$key[0]['content'] = $key[0]['smAbstract'];
				} else {
					//$key['content'] = EjHelper::recap($key['content'],50);
					$key['content'] = $key['smAbstract'];
				}
			$i++;
			}

			$headline=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['headline']);
			$investment=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['investment']);
			$commentary=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['commentary']);
			$finnews=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['finnews']);
			$property=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['property']);
			$views=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['views']);
			$politics=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['politics']);
			$cntw=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['cntw']);
			$international=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['international']);
			$culture=Article::findAllByMasterCatNoCache($pub_date, Yii::$app->params['dailynews_cate_id']['culture']);

			$json['thumb'] = $thumb;
			$json['keynews'] = $keynews;
			//$json['articles'] = $headline;
			$json['articles'] = array_merge($headline, $investment, $commentary, $finnews, $property, $views, $politics, $cntw, $international, $culture);		
			$json['timestamp'] = date('Y-m-d H:i:s');
			$json['copyright_tc'] = '信報財經新聞有限公司版權所有，不得轉載。';
			$json['copyright_en'] = 'Hong Kong Economic Journal Co. Ltd. © All Rights Reserved.';

			if (isset($json['error']))
			{
				error_log('Error generating daily news toc feed ' . $json['error']);

			} else if (isset($json['articles']) && count($json['articles'])){
					return $json;
			} 

		}

		public function actionHeadline()
		{
			Yii::$app->session->set('primarySection', 'headline');

			if(isset($_REQUEST['date']) && !empty($_REQUEST['date'])){
				$pub_date = $_REQUEST['date'];
				if (DailyNews::isPubDate($pub_date)==false) {
					 return $this->render('list_empty');
				}
			} else {
				//$pub_date = DailyNews::getLatestPubDate();
				$pub_date = Yii::$app->session->get('dnewsToday');
			}

			//$pub_date = Yii::$app->session->get('dnewsToday');
			$yyyy = date('Y', strtotime($pub_date));
			$pub_date = str_replace('-', '', $pub_date);

			$listing_json = Yii::getAlias('@app').'/assets/dailynewsWeb/'.$yyyy.'/hkej_dailynews_'.$pub_date.'_toc.json';
			$file = $listing_json;

			if (file_exists($listing_json) ==0) {
				//create json if json not yet exists		   		
		   		$json = DailyNews::createJson($pub_date, $file);
			}

		   	//read json
				$strJsonFileContents = file_get_contents($file);
				$list = json_decode($strJsonFileContents, true);		

				$articles = $list['articles'];

				$i=Yii::$app->params['dailynews_cate_id']['headline'];
				$cat=Yii::$app->params['dailynewsNav']['headline'];
				$i2=substr($i,1);
				if(empty($i)){
						throw new \yii\web\HttpException(404,'The requested page does not exist.');
				}

				$articles = EjHelper::mcat_filter($i, $articles);

				$this->view->params['trackEvent'] = array(
				                'category'=> 'Daily news PHP',
				                'action'=> 'Listing',
				                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
				);
				        	

				return $this->render('list', [
				            'label' => '要聞',
				            'articles' => $articles]);

		   		//end file exist

		
		}

	    public function _actionHeadline()
		{
			Yii::$app->session->set('primarySection', 'headline');

	 		$i=Yii::$app->params['dailynews_cate_id']['headline'];
			$cat=Yii::$app->params['dailynewsNav']['headline'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news PHP',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => '要聞',
	            'articles' => $articles,
	        ]);
	        } else {
	            return $this->render('list_empty');
	            //throw new \yii\web\HttpException(404,'The requested page does not exist.');
	        }
			

		}

		public function actionIndex()
		{
			$this->redirect('/dailynews/headline');
		}

		public function actionInternational()
		{
			Yii::$app->session->set('primarySection', 'international');

	 		$i=Yii::$app->params['dailynews_cate_id']['international'];
			$cat=Yii::$app->params['dailynewsNav']['international'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => 'EJ Global',
	            'articles' => $articles,
	        ]);
	        } else {
	           return $this->render('list_empty');
	        }
			

		}	

	    public function actionInvestment()
		{
			Yii::$app->session->set('primarySection', 'investment');

			$listing_json = Yii::getAlias('@app').'/assets/dailynewsWeb/hkej_dailynews_20220420_toc.json';
			$strJsonFileContents = file_get_contents($listing_json);
			$list = json_decode($strJsonFileContents, true);		

			$articles = $list['articles'];

			$i=Yii::$app->params['dailynews_cate_id']['investment'];
			$cat=Yii::$app->params['dailynewsNav']['investment'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles = EjHelper::mcat_filter($i, $articles);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news PHP',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => '理財投資',
	            'articles' => $articles,
	        ]);
	        } else {
	            return $this->render('list_empty');
	        }
			
		}	

		public function actionPolitics()
		{
			Yii::$app->session->set('primarySection', 'politics');

	 		$i=Yii::$app->params['dailynews_cate_id']['politics'];
			$cat=Yii::$app->params['dailynewsNav']['politics'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => '政壇脈搏',
	            'articles' => $articles,
	        ]);
	        } else {
	            return $this->render('list_empty');
	        }
			

		}

		public function actionProperty()
		{
			Yii::$app->session->set('primarySection', 'property');

	 		$i=Yii::$app->params['dailynews_cate_id']['property'];
			$cat=Yii::$app->params['dailynewsNav']['property'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => '地產市道',
	            'articles' => $articles,
	        ]);
	        } else {
	            return $this->render('list_empty');
	        }
			

		}	

		public function actionToc(){
			Yii::$app->session->set('primarySection', 'toc');

			if(isset($_REQUEST['date']) && !empty($_REQUEST['date'])){
				$pub_date = $_REQUEST['date'];
				if (DailyNews::isPubDate($pub_date)==false) {
					 return $this->render('list_empty');
				}
			} else {
				//$pub_date = DailyNews::getLatestPubDate();
				$pub_date = Yii::$app->session->get('dnewsToday');
			}

			//$pub_date = Yii::$app->session->get('dnewsToday');
			$yyyy = date('Y', strtotime($pub_date));
			$pub_date = str_replace('-', '', $pub_date);

			$listing_json = Yii::getAlias('@app').'/assets/dailynewsWeb/'.$yyyy.'/hkej_dailynews_'.$pub_date.'_toc.json';
			$file = $listing_json;

			if (file_exists($listing_json) ==0) {
				//create json if json not yet exists		   		
		   		$json = DailyNews::createJson($pub_date, $file);
			}

		   	//read json
			$strJsonFileContents = file_get_contents($file);
			$list = json_decode($strJsonFileContents, true);	

			// 重點推介
			$keyNews=$list['keynews'];
			// 頭版大圖
			$thumb=$list['thumb'];

			$headline = EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['headline'], $list['articles']);
			$investment = EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['investment'], $list['articles']);
			$commentary = EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['commentary'], $list['articles']);
			$finnews = EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['finnews'], $list['articles']);
			$property = EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['property'], $list['articles']);
			$views= EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['views'], $list['articles']);
			$politics = EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['politics'], $list['articles']);
			$cntw = EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['cntw'], $list['articles']);
			$international = EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['international'], $list['articles']);
			$culture = EjHelper::mcat_filter(Yii::$app->params['dailynews_cate_id']['culture'], $list['articles']);


			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:TOC'
	        );

			if ($thumb) {


		        return $this->render('toc', compact(
					'thumb', 'keyNews',
					'headline', 'investment', 'commentary',
					'finnews', 'property', 'views', 'politics',
					'cntw', 'international', 'culture' 
					));
	        } else {
	            return $this->render('list_empty');
	        }

		}


		public function _actionToc()
		{
			Yii::$app->session->set('primarySection', 'toc');
			// 重點推介
			$keyNews=DailyNews::findKeyNews(Yii::$app->session->get('dnewsToday'));
			// 頭版大圖
			$sectionId=Yii::$app->params['section2id']['a1-thumb'];
			$thumb=current(DailyNews::findAllBySection($sectionId, Yii::$app->session->get('dnewsToday')));


			// 要聞
			$headline=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['headline']);

			$investment=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['investment']);
			$commentary=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['commentary']);
			$finnews=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['finnews']);
			$property=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['property']);
			$views=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['views']);
			$politics=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['politics']);
			$cntw=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['cntw']);
			$international=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['international']);
			$culture=Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), Yii::$app->params['dailynews_cate_id']['culture']);


			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:TOC'
	        );

			if ($thumb) {
		        return $this->render('toc', compact(
					'thumb', 'keyNews',
					'headline', 'investment', 'commentary',
					'finnews', 'property', 'views', 'politics',
					'cntw', 'international', 'culture' 
					//'sports', 'arts'
					));
	        } else {
	            return $this->render('list_empty');
	        }
			

		}

		public function actionViews()
		{
			Yii::$app->session->set('primarySection', 'views');

	 		$i=Yii::$app->params['dailynews_cate_id']['views'];
			$cat=Yii::$app->params['dailynewsNav']['views'];
			$i2=substr($i,1);
			if(empty($i)){
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}

			$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);

			$this->view->params['trackEvent'] = array(
	                'category'=> 'Daily news',
	                'action'=> 'Listing',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
	        );
	        

	        //return $this->render('list');
	        if ($articles) {
	            return $this->render('list', [
	            'label' => '獨眼香江',
	            'articles' => $articles,
	        ]);
	        } else {
	            return $this->render('list_empty');
	        }
			

		}
    	public function beforeAction($action)
		{

			$action_id = Yii::$app->controller->action->id;

			$detect = Yii::$app->mobileDetect;

			if (($action_id != 'getdays') && ($action_id != 'toc') && ($action_id != 'index') && ($action_id != 'article') && ($action_id != 'author') && ($action_id != 'gettoc') && ($action_id != 'getkeynews') && $detect->isMobile() && !$detect->isTablet()) {
				$mobileURL = Yii::$app->params['mobilewebUrl'].$_SERVER["REQUEST_URI"];
				$mobileURL = preg_replace("%dailynews%", 'dailynewsmob', $mobileURL);
				$this->redirect($mobileURL);
			} else {

			
				if(($action_id != 'getdays') && ($action_id != 'gettoc') && ($action_id != 'getkeynews') && ($action_id != 'index') && ($action_id != 'article') ){

		        $this->view->params['trackEvent'] = array(
		                'category'=> 'Daily news',
		                'action'=> 'Listing',
		                'label'=> 'CID:TOC',
		        );

				// define meta tag
		        
				$this->view->title=Yii::$app->params['dailynewsMeta'][$action_id]['title'];
				$this->meta_description=Yii::$app->params['dailynewsMeta'][$action_id]['desc'];				
				$this->meta_keywords=Yii::$app->params['dailynewsMeta'][$action_id]['keywords'];
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

				if(isset($_REQUEST['date']) && !empty($_REQUEST['date'])){
							//validate date format
							if (Ejhelper::validateDate($_REQUEST['date']) === false) {
								throw new \yii\web\HttpException(404,'The requested page does not exist.');
							} else { 
								// add session
								//app()->session->add('dnewsToday', $_REQUEST['date']);
								if(date("Y-m-d", strtotime($_REQUEST['date']))==$_REQUEST['date']){
									//calculate days interval
									$timestamp = time();
									$req_date=date_create($_REQUEST['date']);
									$today_date=date_create(date('Y-m-d', $timestamp));
									$interval = date_diff($req_date, $today_date);
									$v=$interval->format('%a');
									//if($this->checkSubscription(param('premiumPackageCode')))
									if(Ejhelper::isSubscriber())
									{
										$days=1826;
										Yii::$app->session->set('dnewsToday', $_REQUEST['date']);
										Yii::$app->session->set('days', $days);	
									} else {
										$days=92;
										Yii::$app->session->set('dnewsToday', $_REQUEST['date']);
										Yii::$app->session->set('days', $days);	
									}
									if ($v > $days) { //date out of range, display error
										throw new \yii\web\HttpException(404,'The requested page does not exist.');
										Yii::$app->session->set('dnewsToday', DailyNews::getLatestPubDate());
									}
								}
							}				
			
				} else if(!Yii::$app->session->get('dnewsToday')){
						Yii::$app->session->set('dnewsToday', DailyNews::getLatestPubDate());
				}
			} 
			
			$this->layout = 'webLayout';
    		return parent::beforeAction($action);
	    	} //end mobile detech
    	
        }


		public function actionGetdays($yearmonth)
		{

			if(empty($yearmonth)){
				echo 'error';
				exit;
			}
			$days=DailyNews::getDays($yearmonth);
			header('Content-type: application/json; charset=UTF-8');
			echo json_encode($days);
		}	




}

?>