<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use uii\web\UrlManager;
//use yii\data\Pagination;
use yii\helpers\EjHelper;
use yii\helpers\Url;
use yii\data\Pagination;

class SearchmobController extends Controller
{

	public function actionResults()
	{
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$maxrows=100; 
		$author=isset($_REQUEST['author'])? $_REQUEST['author']: '';;
		$q=isset($_REQUEST['q'])? $_REQUEST['q']: '';;

		$this->view->params['trackEvent']=array(
				'category'=> 'Search Engine Mobile',
				'action'=> 'Search',
				'label'=> $q,
		);

 		$this->view->title = '搜尋結果 - '. $q.' - 信報網站 - 即時新聞 金融脈搏 獨立股票投資分析 政治經濟 名筆評論 - hkej.com - 信報網站 hkej.com';

		if ($author){
			$mode=0;
			$articles=$this->fetchListing($mode, $author, $page, $maxrows);
			if ($articles) {
					$meta=$this->getMeta($mode, $author, $page, $maxrows);	
					$articles=$articles['results'];
					$pagination = new Pagination([
						//'defaultPageSize' => $maxrows,
						'pageSize' => $maxrows,
						'totalCount' => $meta['rows_found'],
					]);

					return $this->render('results', ['articles'=>$articles, 'meta'=>$meta, 'q'=>$author, 'pagination'=>$pagination]);
				
				} else {
					return $this->render('noresults', ['q'=>$author]);
				}


		} else {	
				$mode=1;			
				$articles=$this->fetchListing($mode, $q, $page, $maxrows);
				if ($articles) {
					$meta=$this->getMeta($mode, $q, $page, $maxrows);	
					$articles=$articles['results'];
					$pagination = new Pagination([
						//'defaultPageSize' => $maxrows,
						'pageSize' => $maxrows,
						'totalCount' => $meta['rows_found'],
					]);

					return $this->render('results', ['articles'=>$articles, 'meta'=>$meta, 'q'=>$q, 'pagination'=>$pagination]);
				
				} else {
					return $this->render('noresults', ['q'=>$q]);
				}


		}
		

	}

	public function actionIndex()
	{
		$this->redirect('/landingmob/index');
	}


    public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        $detect = Yii::$app->mobileDetect;

        if ($detect->isMobile() && !$detect->isTablet()) {

	        $this->view->title = '信報網站 - 即時新聞 金融脈搏 獨立股票投資分析 政治經濟 名筆評論 - hkej.com - 信報網站 hkej.com';

			$this->layout = 'mobLayout';
			return parent::beforeAction($action);

		} else {
                //$forwardURL = urlencode(app()->createAbsoluteUrl().$_SERVER["REQUEST_URI"]);
                $desktopURL = Yii::$app->params['searchDestopUrl'].$_SERVER["REQUEST_URI"];
                $desktopURL = preg_replace("%/searchmob/results%", '/template/fulltextsearch/php/search.php', $desktopURL);
                //echo $desktopURL;
                $this->redirect($desktopURL);
        }

	}

	public function fetchListing($mode, $q, $page, $maxrows)
	{
		
		$articles=[];
		//$cacheKey='featuresMob_listing_'.md5($tag.'_'.$maxrows);
		$cacheKey='searchmob_listing_'.md5($mode.'_'.$q.'_'.$page.'_'.$maxrows);
				
		$cache = Yii::$app->cache;
		$articles=$cache->get($cacheKey);
		
		if($articles == false){
			$data=[];
			$url= Yii::$app->params['searchAPI'] ;
			//$maxrows = 100;
			if ($mode==1){
				if($q)
					$url .='q='.urlencode($q).'&';
			} else {
				if($q)
					$author=$q;
					$url .='author='.urlencode($author).'&';
			}
			if($page)
				$url .='page='.$page.'&';
			if($maxrows)
				$url .='maxRows='.$maxrows;
			//echo $url;
			$ch = curl_init();
			$options = array(
					CURLOPT_POST => 1,
					CURLOPT_HEADER => 0,
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_POSTFIELDS => $data,
			);
	
			curl_setopt_array($ch, ($options));
			if( ! $result = curl_exec($ch))
			{
				error_log('curl error occurs: '.curl_error($ch));
				//throw new \yii\web\HttpException(404,'The requested page does not exist.');
			}
			curl_close($ch);
			
			//$articles=json_decode(FeaturesArticle::decryptStr(Yii::$app->params['featuresHash'], $result));
			//echo count($articles[4]).'<br>';


			$articles=json_decode($result, true);
			
			//if(count($articles) > 0){
			if($articles) {
				$cache->set($cacheKey, $articles, 900);
			
			} 			

		}
	
		return $articles;
	}


	public function getMeta($mode, $q, $page, $maxrows)
	{
		$topicmeta=[];
		$topics=$this->fetchListing($mode, $q, $page, $maxrows);
	
		$topicmeta=$topics['meta'];

		/*foreach($topics as $t){
			foreach($t as $k=>$v){
				if($k=='meta'){
					$topicmeta=$v;
					goto end;
				}
			}
	
		}
		end:*/

		return $topicmeta;
			
	
	}
	
}