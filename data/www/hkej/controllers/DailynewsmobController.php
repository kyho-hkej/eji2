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

class DailynewsmobController extends Controller
{
	public $meta_description='';
    public $meta_keywords='';
    public $title='';

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
                'category'=> 'Daily news',
                'action'=> 'Listing Mobile',
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
                'category'=> 'Daily news',
                'action'=> 'Listing Mobile',
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
                'action'=> 'Listing Mobile',
                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.'8,9-'.$cat
        );
        

        //return $this->render('list');
        if ($articles) {
            return $this->render('list', [
            'label' => '副刊文化',
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}	


	public function actionIndex()
	{
		$this->redirect('/dailynewsmob/headline');
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
                'action'=> 'Listing Mobile',
                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
        );
        

        //return $this->render('list');
        if ($articles) {
            return $this->render('list', [
            'label' => 'EJ Global',
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
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
                'category'=> 'Daily news',
                'action'=> 'Listing Mobile',
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
    public function actionHeadline()
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
                'category'=> 'Daily news',
                'action'=> 'Listing Mobile',
                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
        );
        

        //return $this->render('list');
        if ($articles) {
            return $this->render('list', [
            'label' => '要聞',
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		

	}
   public function actionInvestment()
	{
		Yii::$app->session->set('primarySection', 'investment');

 		$i=Yii::$app->params['dailynews_cate_id']['investment'];
		$cat=Yii::$app->params['dailynewsNav']['investment'];
		$i2=substr($i,1);
		if(empty($i)){
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}

		$articles = Article::findAllByMasterCat(Yii::$app->session->get('dnewsToday'), $i);

		$this->view->params['trackEvent'] = array(
                'category'=> 'Daily news',
                'action'=> 'Listing Mobile',
                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
        );
        

        //return $this->render('list');
        if ($articles) {
            return $this->render('list', [
            'label' => '理財投資',
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
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
                'action'=> 'Listing Mobile',
                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
        );
        

        //return $this->render('list');
        if ($articles) {
            return $this->render('list', [
            'label' => '政壇脈搏',
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
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
                'action'=> 'Listing Mobile',
                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
        );
        

        //return $this->render('list');
        if ($articles) {
            return $this->render('list', [
            'label' => '地產市道',
            'articles' => $articles,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
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
                'action'=> 'Listing Mobile',
                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday').'|CID:'.$i2.'-'.$cat
        );
        

        //return $this->render('list');
        if ($articles) {
            return $this->render('list', [
            'label' => '獨眼香江',
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
			$action_id = Yii::$app->controller->action->id;

			if(($action_id != 'getdays') && ($action_id != 'index')){

		        $this->view->params['trackEvent'] = array(
		                'category'=> 'Daily news',
		                'action'=> 'Listing Mobile',
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
										$days=Yii::$app->params['subscriber_limit_days']+3;
										Yii::$app->session->set('dnewsToday', $_REQUEST['date']);
										Yii::$app->session->set('days', $days);	
									} else {
										$days=Yii::$app->params['non_subscriber_limit_days']+1;
										Yii::$app->session->set('dnewsToday', $_REQUEST['date']);
										Yii::$app->session->set('days', $days);	
									}
									if ($v > $days) { //date out of range, display error
										throw new \yii\web\HttpException(404,'The requested page does not exist.');
										Yii::$app->session->set('dnewsToday', DailyNews::getLatestPubDate());
									}
								}
							}
				}else if(!Yii::$app->session->get('dnewsToday')){
							Yii::$app->session->set('dnewsToday', DailyNews::getLatestPubDate());
				}
			
			}

			$this->layout = 'mobLayout';
			return parent::beforeAction($action);

        } else {
                //$forwardURL = urlencode(app()->createAbsoluteUrl().$_SERVER["REQUEST_URI"]);
                $desktopURL = Yii::$app->params['www1Url'].$_SERVER["REQUEST_URI"];
                $desktopURL = preg_replace("%//dailynewsmob%", '/dailynews', $desktopURL);
                $desktopURL = preg_replace("%//dailynewsMob%", '/dailynews', $desktopURL);
                //echo $desktopURL;
                $this->redirect($desktopURL);
        }


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