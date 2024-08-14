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

class HkejwritermobController extends Controller
{
	public $meta_description='';
    public $meta_keywords='';
    public $meta_eng_keywords='';
    public $title='';
    public $og='';

	public function actionIndex(){

		//first 6 sticky articles
		$publishDate=Yii::$app->session->get('dnewsToday2');
		//$publishDate='2018-12-26';	
		
		// $publishDate=DailyNews::getLatestPubDate();

        $writerCnt = 1;
        $tmp = array();
        $articles = array();
        for ($writerCnt = 1; $writerCnt <= 6; $writerCnt++){
            $articles = Article::findBySectionPubdate(Yii::$app->params['section2id']["sticky-hkejwriter{$writerCnt}"], $limit=1, $publishDate=$publishDate);
            //print_r($query);

            if (is_array($articles)){
                $tmp[$writerCnt-1] = $articles[0];
            } else{
                $tmp[$writerCnt-1] = $articles;
            }
        }
        $sticky = $tmp;

        //$s[]=$this->findBySection(app()->params['section2id']['sticky-hkejwriter6'], $limit=1, $publishDate=$publishDate);
        
        //$sticky=(array_filter($s));
        

		
		//other non-sticky articles
		$sectionId=Yii::$app->params['section2id']['hkejwriter'];
		//$query=Article::findAllByPubDate($sectionId, $limit=30, $page=1, $total, $publishDate=$publishDate);


		$articles=Article::findBySectionPubdate(Yii::$app->params['section2id']['hkejwriter'], $limit='', $publishDate=$publishDate);

		//print_r($articles);

		$this->view->params['trackEvent'] = array(
	                'category'=> '信報手筆',
	                'action'=> 'Listing Mobile',
	                //'label'=> 'CID:TOC',
	                'label'=> 'DT:'.Yii::$app->session->get('dnewsToday2').'|CID:TOC',
	    );


		if (($sticky) || ($articles)) {
                 return $this->render('index', ['sticky'=>$sticky, 'articles'=>$articles ,'publishDate'=>$publishDate]);
        } else {
            echo '<!-- 信報手筆 last publish date is '. $publishDate.' pls select sticky articles -->';
        }
		
       
		

	}

   public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        $detect = Yii::$app->mobileDetect;

        if ($detect->isMobile() && !$detect->isTablet()) {

			$action_id = Yii::$app->controller->action->id;

			if($action_id != 'Submitfeedbackform') {

		        // define meta tag
		        
				$this->view->title=Yii::$app->params['hkej_meta_title'];
				$this->meta_description=Yii::$app->params['hkej_meta_desc'];				
				$this->meta_keywords=Yii::$app->params['hkej_meta_keywords'];
				$this->meta_eng_keywords=Yii::$app->params['hkej_meta_eng_keywords'];
				if(empty($this->title)) //default
					$this->title='信報手筆 - 信報網站 hkej.com';


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


		        Yii::$app->view->registerMetaTag([
		                'name' => 'keywords',
		                'content' => $this->meta_eng_keywords,
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
										Yii::$app->session->set('dnewsToday2', $_REQUEST['date']);
										Yii::$app->session->set('days', $days);	
									} else {
										$days=92;
										Yii::$app->session->set('dnewsToday2', $_REQUEST['date']);
										Yii::$app->session->set('days', $days);	
									}
									if ($v > $days) { //date out of range, display error
										throw new \yii\web\HttpException(404,'The requested page does not exist.');
										Yii::$app->session->set('dnewsToday2', DailyNews::getLatestPubDate());
									}
								}
							}
				}else if(!Yii::$app->session->get('dnewsToday2')){
							Yii::$app->session->set('dnewsToday2', DailyNews::getLatestPubDate());
				}
			
			}

			$this->layout = 'mobLayout';
			return parent::beforeAction($action);

        } else {
                //$forwardURL = urlencode(app()->createAbsoluteUrl().$_SERVER["REQUEST_URI"]);
                $desktopURL = Yii::$app->params['www1Url'].$_SERVER["REQUEST_URI"];
                $desktopURL = preg_replace("%//hkejwritermob%", '/hkejwriter', $desktopURL);
                $desktopURL = preg_replace("%//hkejwriterMob%", '/hkejwriter', $desktopURL);
                //echo $desktopURL;
                $this->redirect($desktopURL);
        }
	}

	public function actionSubmitfeedbackform(){
		if($_POST)

		{
	
			$userId=$_POST['user_id'];
			$d=$_POST['publishdate'];
			$url=$_POST['url']; 
			$q=addslashes(trim($_POST['f_que']));
			$u=addslashes(trim($_POST['f_username']));
			$e=addslashes(trim($_POST['f_email']));
			$ip=$_SERVER['REMOTE_ADDR'];
			$b=$_SERVER['HTTP_USER_AGENT'];
			$current_time=date("Y-m-d H:i:s");
			
			
			try {

				$connection = Yii::$app->nejdb1;
				$connection->createCommand()->insert('hkej_member_hkejwriter_feedback', [
				    'user_id' => $userId,
				    'name' => $u,
				    'email' =>$e,
				    'feedback' => $q,
				    'publishDate' => $d,
				    'url' => $url,
				    'ipaddress' => $ip,
				    'browserinfo' => $b,
				    'lastupdatetime' => $current_time,
				])->execute();

				/*$sql="INSERT INTO hkej_member_hkejwriter_feedback ('user_id', 'name', 'email', 'feedback', 'publishDate', 'url', 'ipaddress', 'browserinfo', 'lastupdatetime') VALUES ('$userId', '$u', '$e', '$q', '$d', '$url', '$ip', '$b', '$current_time')";

				//$command = Yii::$app->dbMainsiteRemoteWeb->createCommand($sql);
				
				$command->bindparam(":feedback",$q, PDO::PARAM_STR);
				$command->bindparam(":name",$u, PDO::PARAM_STR);
				$command->bindparam(":email",$e, PDO::PARAM_STR);
				$command->execute();
					*/
				
			} catch (Exception $ex) {
				echo 'Query failed', $ex->getMessage();
			}
			
		}
	}

}