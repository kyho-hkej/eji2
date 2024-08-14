<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use uii\web\UrlManager;
//use yii\data\Pagination;
use yii\helpers\EjHelper;
use yii\helpers\Url;
use app\models\FeaturesArticle;
use app\models\Article;
use yii\data\Pagination;

class FeaturesmobController extends Controller
{
	public $meta_description='';
	public $meta_keywords='';
	public $title='';
	public $og='';
	public $url='';

	public function actionAll()
	{
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$specials=FeaturesArticle::getLandingSpecials($page);
		$stickies=FeaturesArticle::getLandingStickies($page);
		$this->view->params['trackEvent']=array(
				'category'=> '專題',
				'action'=> 'All Features Mobile',
				'label'=> 'PG:'.$page,
		);
		
		return $this->render('all',array ('specials'=>$specials, 'stickies'=>$stickies, 'page'=>$page)
		);
	}
	
	public function actionArticle($q, $suid)
	{

		$cookie = isset($_COOKIE['HKEJ004'])? $_COOKIE['HKEJ004']: ''; 

	 	if ($this->previewAllow($cookie,  str_replace("#", "", $q))===true || EjHelper::isBDCode() ) {
   	

		$topicmeta=FeaturesArticle::getTopicmetaInfo($q);
		$article=FeaturesArticle::fetchArticle($q, $suid);

		//print_r($article);

		if (strpos($article->tag,$_REQUEST['q']) === false) //article tag not matched
			 throw new \yii\web\HttpException(404,'The requested page does not exist.');
		
		if($article===null)
			 throw new \yii\web\HttpException(404,'The requested page does not exist.');

		//override meta_description, meta_keywords in article page

		if ($article->subhead){
				$TTL_full='專題 - '.str_replace("#", "", $q). ' - '. $TTL_full=$article->subjectline.' '.$article->subhead;
		} else {
				$TTL_full='專題 - '.str_replace("#", "", $q). ' - '. $TTL_full=$article->subjectline;
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

		//$absUrl = preg_replace('&amp;suid', '&suid', $absUrl);
		//$url = FeaturesArticle::genArticleUrl($article);
		$url = '/featuresmob/article?q='.$q.'&suid='.$suid;
		//$url = str_replace('&amp;', '&', $url);

		
		//$url = htmlspecialchars(html_entity_decode($url, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');

		Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => '專題-- '.$this->view->title], 'og_title');

		Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'article'], 'og_type');
		Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => $url], 'og_url');

		if ($article->thumbnail == '') {
			$imgUrl = '/images/backup_img/generic_social.png'; 
		} else {
			$imgUrl = $article->thumbnail;
		}

		Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $imgUrl], 'og_image');
		Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => '620'], 'og:image:width');
		Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => '320'], 'og:image:height');
		Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => '專題'], 'og:site_name');
		Yii::$app->view->registerMetaTag(['property' => 'fb:admins', 'content' => 'writerprogram'], 'fb:admins');
		Yii::$app->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '160465764053571'], 'fb:app_id');
		Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => EjHelper::recap($article->content, $len=200)], 'og_description');


		$today=date('Y-m-d');

		/*dfp keyword targetting */
		        $this->view->params['dfp_keyword']=array(
		                            'keyword' => $article->tag,
		                            'stockcode' => $article->stockCode,
		);


		foreach ($topicmeta as $t){
					if (EjHelper::isSubscriber() || (FeaturesArticle::isFree($t->sectionId) == true) || (strpos(Yii::$app->params['openday'], $today) !== false)) { //subscriber OR freecontent OR sticky matched= YES OR openday

					$this->view->params['trackEvent']=array(
					'category'=> '專題',
								'action'=> 'Article Mobile - Full',
								'label'=> 'FE:'.str_replace('#', '', 't->tag').'|DT:'.$article->publishDate.'|TID:'.$article->id.'|SID:'.$article->suid.'|AN:'.$article->authorName.'|CN:'.$article->storyProgName.'|TTL:'.$article->subjectline,
					);


			
					$view='article';
				} else {
					$this->view->params['trackEvent']=array(
							'category'=> '專題',
							'action'=> 'Article Mobile- Abstract',
							'label'=> 'FE:'.str_replace('#', '', $t->tag).'|DT:'.$article->publishDate.'|TID:'.$article->id.'|SID:'.$article->suid.'|AN:'.$article->authorName.'|CN:'.$article->storyProgName.'|TTL:'.$article->subjectline,
					);
					$view='article_abs';
				}
					

			return $this->render($view, 
				//compact('article')
						compact('article','topicmeta','label')
			);
		}


	} else {
		echo 'no access';
	}

	}


	public function actionCategory($code)
	{
		$cat=isset($code)? $code: '';
		//$cat=$code
		$limit=isset($_REQUEST['limit'])? $_REQUEST['limit']: '';
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$maxrowssp=isset($_REQUEST['maxrowssp'])? $_REQUEST['maxrowssp']: 20;
		
		//$specials=$this->getCatLandingSpecials($cat, $limit, $page, $maxrowssp);
		//$pagination=$this->getCatPagination($cat, $page);
		//SEO
		$aryNav=Yii::$app->params['featuresNav'];
		foreach($aryNav as $k=>$v){
			if ($cat == $k) {
				$cat_label=$v;
			}
		}
		$cat_label = '';
		$event_label = '';
		$aryNav2=Yii::$app->params['featuresEvents'];
		foreach($aryNav2 as $k2=>$v2){
			if ($cat == $k2) {
				$event_label=$v2;
			}
		}

		$this->view->params['trackEvent']=array(
				'category'=> '專題',
				'action'=> 'Category Listing',
				'label'=> 'FE:'.$cat_label.$event_label.'|PG:'.$page,
		);
		if (($cat == 10) || ($cat == 6) || ($cat == 7) || ($cat == 8) || ($cat == 9)){ //活動專輯	

			$this->redirect('/featuresmob/event');						
			/*$specials=FeaturesArticle::getCatLandingSpecials($cat, $limit, $page, $maxrowssp);
			return $this->render('topic_events', array(
					'cat'=>$cat,
					'specials'=>$specials));	*/
		//名家論壇				
		} else if (($cat == 5) || ($cat == 11) || ($cat == 12) || ($cat == 13) || ($cat == 14) || ($cat == 15) || ($cat == 16) || ($cat == 'annual45th')) { 
			//redirect to HKEJ landing
			$this->redirect('/featuresmob/index');
				
		} else {	
			$specials=FeaturesArticle::getCatLandingSpecials($cat, $limit, $page, $maxrowssp);
			return $this->render('category', array('specials'=>$specials, 'cat'=>$cat));
		}
	}
   public function actionEmbedevent(){

        $articles='';
        $cacheKey='embed_event_article_widget_mobileweb'.date('Y-m-d');
        $cache = Yii::$app->cache;
        $article=$cache->get($cacheKey);

        if($articles == false){
            $data=[];
            $url= Yii::$app->params['featuresEventWidgetUrl'];
            //$url=($tag)? $this->topicsUrl.'?q='.urlencode($tag): $this->topicsUrl;
            //echo ' fetchTopics $url: '.$url;
            $ch = curl_init();
            $options = array(
                    CURLOPT_POST => 1,
                    CURLOPT_HEADER => 0,
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_POSTFIELDS => $data,
            );
           
            //if (param('logErrorAll')) error_log("[feature2016] -- b4 curl $ch $url @ ".date('Y-m-d h:i:s'), 0);
            curl_setopt_array($ch, ($options));
            if( ! $result = curl_exec($ch))
            {
                echo 'curl error';
                er('curl error occurs: '.curl_error($ch));
            }
            curl_close($ch);
            //if (param('logErrorAll')) error_log("[feature2016] -- after curl $ch @ ".date('Y-m-d h:i:s'), 0);
            
            $articles=json_decode(FeaturesArticle::decryptStr(Yii::$app->params['featuresHash'], $result));

            //$articles=$result;
            //if(count($articles) > 0){
           
            if ($articles) {    
                $cache->set($cacheKey, $article, 300);
            }
        }

        if ($articles) {
        	$stickies = $articles[0]->stickies;
                return $this->renderAjax('embed_event', [
                'stickies' => $stickies,
            ]);
        } else {
            echo '<!-- features event widget no stickies articles -->';
        }

    }

    public function actionEmbedfeatures(){
        $s1=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header"], $range=365);       
        $s2=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header2"], $range=365);
        $s3=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header3"], $range=365);
        $s4=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header4"], $range=365);
        $s5=Article::findBySection(Yii::$app->params['section2id']["sticky-features-header5"], $range=365);

        $sticky = array_merge($s1, $s2, $s3, $s4, $s5);

        //print_r($photos);
        //print_r($sticky);
        if ($sticky) {
                return $this->renderAjax('embed_features', [
                'sticky' => $sticky,
            ]);
        } else {
            echo '<!-- features widget no articles -->';
        }
    }

   public function actionEmbedfeatures_bak(){

        $articles='';
        $cacheKey='embed_features_article_widget_mobileweb'.date('Y-m-d');
        $cache = Yii::$app->cache;
        $article=$cache->get($cacheKey);

        if($articles == false){
            $data=[];
            $url= Yii::$app->params['datafeed2_features'];
            //$url=($tag)? $this->topicsUrl.'?q='.urlencode($tag): $this->topicsUrl;
            //echo ' fetchTopics $url: '.$url;
            $ch = curl_init();
            $options = array(
                    CURLOPT_POST => 1,
                    CURLOPT_HEADER => 0,
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_POSTFIELDS => $data,
            );
           
            //if (param('logErrorAll')) error_log("[feature2016] -- b4 curl $ch $url @ ".date('Y-m-d h:i:s'), 0);
            curl_setopt_array($ch, ($options));
            if( ! $result = curl_exec($ch))
            {
                echo 'curl error';
                er('curl error occurs: '.curl_error($ch));
            }
            curl_close($ch);
            //if (param('logErrorAll')) error_log("[feature2016] -- after curl $ch @ ".date('Y-m-d h:i:s'), 0);
            
            $articles=json_decode($result, true);
            //$articles=$result;
            //if(count($articles) > 0){
           
            if ($articles) {    
                $cache->set($cacheKey, $article, 300);
            }
        }

        if ($articles) {
                return $this->renderAjax('embed_features', [
                'articles' => $articles,
            ]);
        } else {
            echo '<!-- features widget no articles -->';
        }

    }

	public function actionEvent()
	{
	
		$sectionId = Yii::$app->params['section2id']['features-event'];
		$limit=50;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		//$range=14;
		$range=1095;

		$list = Article::findAllBySection($sectionId, $limit, $page, $total, $range);

         	//echo 'abc';

 		
           	//group result by years
			$arr_output = array();
			foreach($list as $key=>$arr)
			{
				$date = $arr['publishDateLite'];
				$arr_dates = explode("-", $date);
				$year = $arr_dates[0];
				$arr_output[$year][] = $arr;

			}

           	$cat_label='活動專輯';

           	$this->view->params['trackEvent']=array(
				'category'=> '專題',
				'action'=> 'Features Listing Mobile',
				'label'=> 'FE:'.$cat_label.'|PG:1',
			);

           	return $this->render('category_events_combine', ['specials'=>$arr_output]);
    }
	public function actionEvent2()
	{
		$page=1;
		$specials=FeaturesArticle::getCatLandingSpecials($cat=10, $limit=9, $page);	//活動專輯 dropdown menu
		$limit=2;
		$new=FeaturesArticle::getCatLandingSpecials($cat, $limit, $page); //活動專輯-最新活動
		$specials1=FeaturesArticle::getCatLandingSpecials($cat=6, $limit, $page);	//活動專輯-投資理財
		$specials2=FeaturesArticle::getCatLandingSpecials($cat=7, $limit, $page); //活動專輯-生活健康
		$specials3=FeaturesArticle::getCatLandingSpecials($cat=8, $limit, $page); //活動專輯-社會時事
		$specials4=FeaturesArticle::getCatLandingSpecials($cat=9, $limit, $page); //活動專輯-商業經
		$cat_label='活動專輯';

		$this->view->params['trackEvent']=array(
				'category'=> '專題',
				'action'=> 'Features Listing Mobile',
				'label'=> 'FE:'.$cat_label.'|PG:'.$page,
		);

		//print_r($specials4);
		return $this->render('category_events', ['cat'=>$cat, 'new'=>$new, 'specials'=>$specials, 'specials1'=>$specials1, 'specials2'=>$specials2, 'specials3'=>$specials3, 'specials4'=>$specials4]);

	}
	public function actionIndex()
	{

		$page=1;
		//新聞專題
		$topics1=FeaturesArticle::getCatLandingSpecials($cat=4, $limit=4, $page);
		//人物訪問
		$topics2=FeaturesArticle::getCatLandingSpecials($cat=2, $limit=4, $page);
		//生活休閒
		$topics3=FeaturesArticle::getCatLandingSpecials($cat=1, $limit=4, $page);
		//信報教育
		$topics4=FeaturesArticle::getCatLandingSpecials($cat=3, $limit=4, $page);

		$this->view->params['trackEvent']=array(
				'category'=> '專題',
				'action'=> 'LandingPageMobile',
				'label'=> 'FE:最新|PG:'.$page,
		);
		return $this->render('index', ['topics1'=>$topics1, 'topics2'=>$topics2 , 'topics3'=>$topics3, 'topics4'=>$topics4]);
	}

	public function actionTopic($tag)
	{
		$cookie = isset($_COOKIE['HKEJ004'])? $_COOKIE['HKEJ004']: ''; 
		
		if ($this->previewAllow($cookie, $tag)===true || EjHelper::isBDCode()) {

		$tag=isset($tag)? $tag: '';
		$this->title=$tag.' '.$this->title;
		$this->meta_description =$tag.' '.$this->meta_description;
		$this->meta_keywords = $tag.' '.$this->meta_keywords;
		$hashTag='#'.$tag.'#';
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$maxrows=isset($_REQUEST['maxrows'])? $_REQUEST['maxrows']: 140;		
		$getPagination=FeaturesArticle::getPagination($hashTag, $page, $maxrows);

		$topicmeta=FeaturesArticle::getTopicMetaInfo($hashTag);
		$topicmeta2=FeaturesArticle::getTopicMeta($hashTag, $page);
		$stickies=FeaturesArticle::getStickies($hashTag, $page);
		$articles=FeaturesArticle::getArticles($hashTag, $page, $maxrows);

		if ($getPagination) {
			$pagination = new Pagination([
				'defaultPageSize' => 20,
				'totalCount' => $getPagination->matches,
			]);
		}
		
		//$pagination=$this->getPagination($hashTag, $page);
		$this->view->params['trackEvent']=array(
				'category'=> '專題',
				'action'=> 'Features Listing Mobile',
				'label'=> 'FE:'.$tag.'|PG:'.$page,
		);
		//og tags
		foreach  ($topicmeta as $t) {
			//override meta_description, meta_keywords in article page
			$fb_thumb=$t->thumbnail; //replace with 620 size for fb share
				
			$this->title =$t->subjectline;
			$this->meta_description=strip_tags($t->content);
				
			$this->meta_keywords .= $t->tag.' ';
			$this->meta_keywords .='信報專題 '.' '.$t->subjectline.' 信報 信報網站 Hkej hkej.com';
			$this->og='
					<meta property="og:title" content="信報專題 -- '.$t->subjectline.'"/>
					<meta property="og:type" content="article"/>
					<meta property="og:url" content="'.Yii::$app->params['www1Url'].FeaturesArticle::genTopicUrl($t->tag).'"/>
					<meta property="og:image" content="'.$fb_thumb .'"/>
					<meta property="og:image:width" content="620" />
					<meta property="og:image:height" content="320" />
					<meta property="og:site_name" content="信報專題"/>
					<meta property="fb:admins" content="writerprogram"/>
					<meta property="fb:app_id" content="160465764053571"/>
					<meta property="og:description"
					content="'.strip_tags($t->content).'"/>
					';
		
		}

		foreach  ($topicmeta2 as $v) {
		
			if (strlen($v->abstract2)>20) { //$v->abstract2 is properly input
				//throw new CHttpException(404,'The requested page does not exist.'); //redirect to topicsp
				$this->redirect(Yii::$app->params['mobilewebUrl'].'/featuresmob/topicsp/tag/'.urlencode($tag));
			} else {	
				return $this->render('topic',
						compact('special_all','topicmeta', 'stickies','articles', 'pagination', 'tag')
				);
			}
		
		}

		} else {
			echo 'no access';
		}
	}

	public function _actionTopicresults()
	{
		if (isset($_POST["pageNum"])) 
		{
		    $page = $_POST["pageNum"];
		}
	}

	public function actionTopicresults()
	{
		//$page=$_POST["pageNum"];
		if (isset($_POST["pageNum"])) 
		{
		    $page = $_POST["pageNum"];
		}
		$maxRows=200;

		if (isset($_POST["q"])) 
		{
		    $q = $_POST["q"];
		}
		$hashTag='#'.$q.'#';
		$articles=FeaturesArticle::getArticles($hashTag, $page, $maxRows);
		
		foreach ($articles as $k=>$v){
		?>
		<div class="widget-row">
		<?php if($v->thumbnail) {
			$thumb=str_replace('_620', '_320', $v->thumbnail);
				
			?>
		
				    <a href="<?=FeaturesArticle::genArticleUrl($v) ?>">
				    <span class="img-thumb">
				    <?php if($v->video) {?>
					<img  style="position: absolute; z-index: 1; width: 23%; left: 38%; top:
		29%;" class="edcplaybtn" src="<?php echo Yii::$app->params['mobilewebUrl'].'/mobileweb/images/icon_play.png'?>">
					<?php } ?>		    
				    <img src="<?=$thumb?>" class="img-thumb-row"/></span>
				    </a>
				<?php }?>
			    <div class="row-content">
			    <a href="<?=FeaturesArticle::genArticleUrl($v) ?>"><span class="row-title"><?=$v->subjectline?></span></a>
			    
			    
			    <span class="row-author">
			    <?php if ($v->authorId!=0) {
		 			$authorUrl=FeaturesArticle::genAuthorUrl($v->catUrl, $v->authorName, $v->id)
		 		?> 		
		 			<?php echo $v->authorName; ?> |
		 		<?php }?> 
			    <span class="listing-date"><?php echo EjHelper::toChineseDate($v->publishDate); ?></span></span>
			    </div>
			    </div><!--widget-row-->
	<?php }	
	}

	public function actionTopicsp($tag)
	{
		//meta tag
		$this->title =$tag.' '.$this->title;
		$this->meta_description =$tag.' '.$this->meta_description;
		$this->meta_keywords = $tag.' '.$this->meta_keywords;
	
		//$page=($_REQUEST['page'])? $_REQUEST['page']: 1;
		$page=1;
		$hashTag='#'.$tag.'#';
		//$maxrows=($_REQUEST['maxrows'])? $_REQUEST['maxrows']: 20;
		$maxrows=20;
		
		$topicmeta=FeaturesArticle::getTopicMeta($hashTag, $page);
		foreach ($topicmeta as $t) {
			$topic=$t->subjectline;
			$label=FeaturesArticle::getCatLabel($t->sectionId)[1];
			$code=FeaturesArticle::getCatLabel($t->sectionId)[0];
		}

		
		$this->view->params['trackEvent']=array(
				'category'=> '專題',
				'action'=> 'Features Special Listing',
				'label'=> 'FE:'.$tag.'|PG:'.$page,
		);

		//og tags
		foreach  ($topicmeta as $t) {
			//override meta_description, meta_keywords in article page
			$fb_thumb=$t->thumbnail; //replace with 620 size for fb share
				
			$this->title =$t->subjectline;
			$this->meta_description=strip_tags($t->content);
				
			$this->meta_keywords .= $t->tag.' ';
			$this->meta_keywords .='信報專題 '.' '.$t->subjectline.' 信報 信報網站 Hkej hkej.com';
			$this->og='
					<meta property="og:title" content="信報專題 -- '.$t->subjectline.'"/>
					<meta property="og:type" content="article"/>
					<meta property="og:url" content="'.Yii::$app->params['www1Url'].FeaturesArticle::genTopicUrl($t->tag).'"/>
					<meta property="og:image" content="'.$fb_thumb .'"/>
					<meta property="og:image:width" content="620" />
					<meta property="og:image:height" content="320" />
					<meta property="og:site_name" content="信報專題"/>
					<meta property="fb:admins" content="writerprogram"/>
					<meta property="fb:app_id" content="160465764053571"/>
					<meta property="og:description"
					content="'.strip_tags($t->content).'"/>
					';
		
		}	

		foreach  ($topicmeta as $v) {
			//echo $v->smAbstract;
/*			if ($v->abstract2=='') {
				throw new CHttpException(404,'The requested page does not exist.');
			}*/
			if (strlen($v->abstract2)<20) { //$v->abstract2 is empty or only a few characters
				//throw new CHttpException(404,'The requested page does not exist.');
				$this->redirect(Yii::$app->params['mobilewebUrl'].'/featuresmob/topic/tag/'.urlencode($tag));
			} else {
				$rows = explode("\n", $v->abstract2);
		
				for ($x = 1; $x <= count($rows)-1; $x++) {
					$widgets[$x]=$rows[$x];
		
					$ar= preg_split("/[\t]/", $widgets[$x]);
		
					$widgetArray[$x] = array('widgetName'=> $ar[0],
							'displayTitle'=>isset($ar[1]) ? $ar[1] : null,
							'groupName'=>isset($ar[2]) ? $ar[2] : null,
							'OrderDesktop'=>isset($ar[3]) ? $ar[3] : null,
							'OrderMobile'=>isset($ar[4]) ? $ar[4] : null,
							'desc'=>isset($ar[5]) ? $ar[5] : null,
							'tag'=>isset($ar[6]) ? $ar[6] : null,
							'url'=>isset($ar[7]) ? $ar[7] : null,
							'items'=>isset($ar[8]) ? $ar[8] : null,
							'display'=>isset($ar[9]) ? $ar[9] : null,
							'displayMore'=>isset($ar[10]) ? $ar[10] : null,
					);
				}
		
				function sortByGroup($a, $b) {
					return $a['groupName'] - $b['groupName'];
				}
					
				function sortByOrder($a, $b) {
					return $a['OrderMobile'] - $b['OrderMobile'];
				}

				//usort($widgetArray, 'sortByOrder');

				usort($widgetArray, function($a, $b) {
				    return $a['OrderMobile'] <=> $b['OrderMobile'];
				});
				
				for ($y = 0; $y <= count($widgetArray); $y++) {
					if ($widgetArray[$y]['OrderMobile']==0){
						unset($widgetArray[$y]);
					}
				}
					
				foreach ($widgetArray as $value) {
					$arrayByGroup[$value['groupName']][] = $value;
				}
					
				//sort $arrayByGroup in ascending order, according to the key.
				ksort($arrayByGroup);
						
				$arrayByGroup=array_values($arrayByGroup);
				$bannerArr=$arrayByGroup[0];

				return $this->render('topic_sp',
						compact('bannerArr','arrayByGroup',
								'topic','label','code'
					)
				);
				
			}
		}
	}
	
   	public function beforeAction($action)
	{
		$detect = Yii::$app->mobileDetect;
		$action_id = Yii::$app->controller->action->id;

		if ($action_id=='embedevent' || $action_id=='embedfeatures') { //no redirect for emebed widgets
			return parent::beforeAction($action);
		} else {
			
			if ($detect->isMobile() && !$detect->isTablet()) {		
				// define meta tag
		    
				$this->view->title=Yii::$app->params['fea_meta_title'];
				$this->meta_description=Yii::$app->params['fea_meta_desc'];				
				$this->meta_keywords=Yii::$app->params['fea_meta_keywords'];
				//$this->meta_eng_keywords=Yii::$app->params['hkej_meta_eng_keywords'];
				if(empty($this->title)) //default
					$this->title='專題 - 信報專題特輯 薈粹信報精華  hkej.com - 信報網站 hkej.com';


		        $fbarticleUrl = Yii::$app->params['mobilewebUrl'].'/'.Yii::$app->controller->id.'/'.$action_id;
		        $imgUrl = Yii::$app->params['staticUrl'].'backup_img/generic_social.png';
		        $fb_appid = '160465764053571';

		        if(empty($this->meta_description))
		        Yii::$app->view->registerMetaTag([
		                'name' => 'description',
		                'content' => $this->meta_description,
		        ]);

		    	if(empty($this->meta_keywords))
		        Yii::$app->view->registerMetaTag([
		                'name' => 'keywords',
		                'content' => $this->meta_keywords,
		        ]);



		        Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->view->title], 'og_title');
		        Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'article'], 'og_type');
	//echo "********".$fbarticleUrl."*******\n";
		        Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => $fbarticleUrl], 'og_url');

		        Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $imgUrl], 'og_image');
		        Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => '620'], 'og:image:width');
		        Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => '320'], 'og:image:height');
		        Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => '信報網站 hkej.com'], 'og:site_name');
		        Yii::$app->view->registerMetaTag(['property' => 'fb:admins', 'content' => 'writerprogram'], 'fb:admins');
		        Yii::$app->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '160465764053571'], 'fb:app_id');
		        Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $this->meta_description], 'og_description');
			
		        if ((Yii::$app->controller->action->id == 'article') || (Yii::$app->controller->action->id == 'topic'))  {
		        	$this->layout = 'mobArticleLayout';
		        } else {
		    		$this->layout = 'mobLayout';
				}
				return parent::beforeAction($action);


       		 } else {

        	
        	
                //$forwardURL = urlencode(app()->createAbsoluteUrl().$_SERVER["REQUEST_URI"]);
                $desktopURL = Yii::$app->params['www1UrlDesktop'].$_SERVER["REQUEST_URI"];
                $desktopURL = preg_replace("%//featuresmob%", '/features', $desktopURL);
                $desktopURL = preg_replace("%//featuresMob%", '/features', $desktopURL);
                //echo $desktopURL;
                $this->redirect($desktopURL);

            
        	}
    	}
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



}
