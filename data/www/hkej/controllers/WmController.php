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
use app\models\Photo;
use app\models\InstantNews;
use yii\data\Pagination;

class WmController extends Controller
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
                    $mobileURL = preg_replace("%wm/$s/article/%", 'landing/mobarticle2/id/', $mobileURL);
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

                    $this->view->title = '信報財富管理 -- ' . $TTL_full;

                    Yii::$app->view->registerMetaTag([
                            'name' => 'keywords',
                            'content' => '信報財富管理'.$article->getSection()->sectionLabel.$TTL_full . ' - 信報 信報網站 Hkej hkej.com',
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
                    Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => '信報財富管理 hkej.com'], 'og:site_name');
                    Yii::$app->view->registerMetaTag(['property' => 'fb:admins', 'content' => 'writerprogram'], 'fb:admins');
                    Yii::$app->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '160465764053571'], 'fb:app_id');
                    Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => EjHelper::recap($article->content, $len=200)], 'og_description');
                
                    /*
                    * for GA event tracking
                    */
                    $label='DT:'.$article->publishDateLite.'|TID:'.$article->id.'|PID:|PSN:'.$article->getSection()->sectionLabel.'|AN:|CN:'.$article->storyProgName.'|TTL:'.$TTL_full;         
                    $d=date('Y-m-d', strtotime($article->publishDate));
                    
                    $this->view->params['trackEvent']=array(
                            'category'=> 'Wm',
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

    public function actionArticlelist()
    {
        Yii::$app->session->set('primarySection', '');
        $sectionId = Yii::$app->params['section2id']['wm-all'];
        if(isset($_REQUEST['sectionCode']) && !empty($_REQUEST['sectionCode'])){
            if (($_REQUEST['sectionCode'] == 'general-china') |
            ($_REQUEST['sectionCode'] == 'general-asia') |
            ($_REQUEST['sectionCode'] == 'general-japan') |
            ($_REQUEST['sectionCode'] == 'general-us') |
            ($_REQUEST['sectionCode'] == 'general-eu') |
            ($_REQUEST['sectionCode'] == 'general-new'))
            {           
                $sectionId=Yii::$app->params['section2id'][$_REQUEST['sectionCode']];
            } else {
                throw new \yii\web\HttpException(404,'The requested page does not exist.');
            }
        }else if(isset($_REQUEST['section']) && !empty($_REQUEST['section'])){
            $sectionId=Yii::$app->params['section2id'][$_REQUEST['section']];
        }

        $limit=10;
        $page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $total='';
        $range=1826;

        $articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
        
        
        $pagination = new Pagination([
                'defaultPageSize' => $limit,
                'totalCount' => $total,
        ]);


        $this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing',
                'label'=> 'PSN:財富管理文章|PG:'.$page,
        );
        

        if ($articles) {
            return $this->render('article_list', [
            'label' => '全部',
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
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
        $author->updateViewCnt();
        //app()->ejLog->logAuthor($author);

        $pagination = new Pagination([
                'defaultPageSize' => $limit,
                'totalCount' => $total,
        ]);
        

        $this->view->params['trackEvent']=array(
                'category'=> 'Wm news',
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

    public function actionAuthorlist(){

        Yii::$app->session->set('primarySection', '');

        if(isset($_REQUEST['section'])){
            if ($_REQUEST['section']=='all') {
                $sectionId = Yii::$app->params['section2id']['wm-all'];
            } else {
                $sectionId=Yii::$app->params['section2id'][$_REQUEST['section']];
            }
        } else {
            $sectionId = Yii::$app->params['section2id']['wm-all'];
        }

        $section=isset($_REQUEST['section'])? $_REQUEST['section']: '';

        
        $limit=10;
        $page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $total='';
        $range='';
        
        $authors=Author::findAllBySection($sectionId, $limit, $page, $total);

               $pagination = new Pagination([
                'defaultPageSize' => $limit,
                'totalCount' => $total,
        ]);
        

        $this->view->params['trackEvent']=array(
                'category'=> 'Wm news',
                'action'=> 'Listing',
                'label'=> 'CID:Author list|PG:'.$page
        );
        
        return $this->render('author_list', array(
                'section'=>$section,
                'authors'=>$authors,
                'page'=>$page,
                'total'=>$total,
                'pagination'=>$pagination
        )
        );
    }

	public function actionCurrency() 
	{
		$sectionId = Yii::$app->params['section2id']['currency'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);

        $riz_sectionId = Yii::$app->params['section2id']['currency-riz'];
        $riz_limit=3;
        $riz_page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $riz_total=3;
        $riz_range='';
        $articlesRiz=Article::findAllBySection($riz_sectionId, $riz_limit, $riz_page, $riz_total, $riz_range);

        $au_limit = 5;
        $au_page = 1;
        $au_total = 5;
        $au_range =90;

        $authors=Author::findRandomBySection($sectionId, $au_limit, $au_range, $au_page, $au_total);
		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing',
                'label'=> 'PSN:人民幣 / 外匯先機|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '人民幣 / 外匯先機',
            'sticky' => $sticky,
            'articles' => $articles,
            'articlesRiz' => $articlesRiz,
            'authors'=> $authors,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}
	public function actionEtf() 
	{
		$sectionId = Yii::$app->params['section2id']['etf'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);

        $riz_sectionId = Yii::$app->params['section2id']['etf-riz'];
        $riz_limit=3;
        $riz_page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $riz_total=3;
        $riz_range='';
        $articlesRiz=Article::findAllBySection($riz_sectionId, $riz_limit, $riz_page, $riz_total, $riz_range);

        $au_limit = 5;
        $au_page = 1;
        $au_total = 5;
        $au_range =90;

        $authors=Author::findRandomBySection($sectionId, $au_limit, $au_range, $au_page, $au_total);
		
        $k_sectionId = Yii::$app->params['section2id']['etf-knowledge'];
        $k_limit=5;
        $k_page=1;
        $k_total=5;
        $articlesKnowledge=Article::findRandomBySection($k_sectionId, $k_limit, $k_page, $k_total);
        
		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing',
                'label'=> 'PSN:ETF透視|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => 'ETF透視',
            'sticky' => $sticky,
            'articlesRiz' => $articlesRiz,
            'articles' => $articles,
            'authors' => $authors,
            'articlesKnowledge' => $articlesKnowledge,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}
	public function actionFund() 
	{
		$sectionId = Yii::$app->params['section2id']['fund'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
        $riz_sectionId = Yii::$app->params['section2id']['fund-riz'];
        $riz_limit=3;
        $riz_page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $riz_total=3;
        $riz_range='';
        $articlesRiz=Article::findAllBySection($riz_sectionId, $riz_limit, $riz_page, $riz_total, $riz_range);

        $au_limit = 5;
        $au_page = 1;
        $au_total = 5;
        $au_range =90;

        $authors=Author::findRandomBySection($sectionId, $au_limit, $au_range, $au_page, $au_total);

		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing',
                'label'=> 'PSN:基金縱橫|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '基金縱橫',
            'sticky' => $sticky,
            'articles' => $articles,
            'articlesRiz' => $articlesRiz,
            'authors' => $authors,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}
	public function actionGeneral() 
	{
		$sectionId = Yii::$app->params['section2id']['general'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		
        $riz_sectionId = Yii::$app->params['section2id']['general-riz'];
        $riz_limit=3;
        $riz_page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $riz_total=3;
        $riz_range='';
        $articlesRiz=Article::findAllBySection($riz_sectionId, $riz_limit, $riz_page, $riz_total, $riz_range);

        $au_limit = 5;
        $au_page = 1;
        $au_total = 5;
        $au_range =90;

        $authors=Author::findRandomBySection($sectionId, $au_limit, $au_range, $au_page, $au_total);

        $k_limit=5;
        $k_page=1;
        $k_total=5;
        $articlesKnowledge=Article::findRandomBySection($sectionId, $k_limit, $k_page, $k_total);
        

		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing',
                'label'=> 'PSN:宏觀方略|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '宏觀方略',
            'sticky' => $sticky,
            'articles' => $articles,
            'articlesRiz' => $articlesRiz,
            'authors' => $authors,
            'articlesKnowledge' => $articlesKnowledge,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}

	public function actionMpf() 
	{
        
		$sectionId = Yii::$app->params['section2id']['mpf'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=10;
		$range=90;

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);

        $riz_sectionId = Yii::$app->params['section2id']['mpf-riz'];
        $riz_limit=3;
        $riz_page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $riz_total=3;
        $riz_range='';
        $articlesRiz=Article::findAllBySection($riz_sectionId, $riz_limit, $riz_page, $riz_total, $riz_range);

        $au_limit = 5;
        $au_page = 1;
        $au_total = 5;
        $au_range =90;

        $authors=Author::findRandomBySection($sectionId, $au_limit, $au_range, $au_page, $au_total);

        $k_sectionId = 40;
        $k_sectionId2 = 41;
        $k_limit=5;
        $k_page=1;
        $k_total=5;
        $k_range='';

       // $articlesKnowledgeMpf=Article::findAllBySection($k_sectionId, $k_limit, $k_page, $k_total, $k_range);
       // $articlesKnowledgeIns=Article::findAllBySection($k_sectionId2, $k_limit, $k_page, $k_total, $k_range);

        $articlesKnowledgeMpf=[];
        $articlesKnowledgeIns=[];
		$this->view->params['trackEvent'] = array(
                    'category'=> 'WM news ',
                    'action'=> 'Listing',
                    'label'=> 'PSN:智醒退休   |PG:'.$page
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '智醒退休',
            'articles' => $articles,
            'articlesRiz' => $articlesRiz,
            'authors' => $authors,
            'articlesKnowledgeMpf' => $articlesKnowledgeMpf,
            'articlesKnowledgeIns' => $articlesKnowledgeIns,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}

	public function actionSmart() 
	{
		$sectionId = Yii::$app->params['section2id']['smart'];
		$limit=10;
		$page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
		$total=50;
		$range='';

		$articles =Article::findAllBySection($sectionId, $limit, $page, $total, $range);

        $riz_sectionId = Yii::$app->params['section2id']['smart-riz'];
        $riz_limit=3;
        $riz_page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        $riz_total=3;
        $riz_range='';
        $articlesRiz=Article::findAllBySection($riz_sectionId, $riz_limit, $riz_page, $riz_total, $riz_range);

        $au_limit = 5;
        $au_page = 1;
        $au_total = 5;
        $au_range =90;

        $authors=Author::findRandomBySection($sectionId, $au_limit, $au_range, $au_page, $au_total);

        $k_sectionId = Yii::$app->params['section2id']['all-knowledge'];
        $k_limit=5;
        $k_page=1;
        $k_total=5;
        $articlesKnowledge=Article::findRandomBySection($k_sectionId, $k_limit, $k_page, $k_total);

		$sticky = array(); // no sticky just pass an empty array

		$this->view->params['trackEvent'] = array(
                'category'=> 'WM news',
                'action'=> 'Listing',
                'label'=> 'PSN:精明移民 / 理財|PG:'.$page,
        );
        

		if ($articles) {
            return $this->render('list', [
            'label' => '精明移民 / 理財',
            'sticky' => $sticky,
            'articles' => $articles,
            'articlesRiz' => $articlesRiz,
            'authors' => $authors,
            'articlesKnowledge' => $articlesKnowledge,
        ]);
        } else {
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }
		
	}

	public function actionIndex() 
	{

        $aryRoster=array(
                '0'=>'/wm/smart',
                '1'=>'/wm/general',
                '2'=>'/wm/etf',
                '3'=>'/wm/fund',
                '4'=>'/wm/currency',
                '5'=>'/wm/mpf',
                '6'=>'/wm/smart',
        );
        $weekday= date('w');
        $this->redirect($aryRoster["$weekday"]);
		
	}
    public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessContro
        $detect = Yii::$app->mobileDetect;

        if ($detect->isMobile() && !$detect->isTablet()) {

            $mobileURL = Yii::$app->params['mobilewebUrl'].$_SERVER["REQUEST_URI"];
            $mobileURL = preg_replace("%wm%", 'wmmob', $mobileURL);
            $mobileURL = strtolower($mobileURL);
            $this->redirect($mobileURL);

        } else {
            //define meta data
            $action_id = preg_replace('/embed/i', '', Yii::$app->controller->action->id);
            $this->view->title=Yii::$app->params['wm_meta_title'];
            $this->meta_description=Yii::$app->params['wm_meta_desc'];              
            $this->meta_keywords=Yii::$app->params['wm_meta_keywords'];
            if(empty($this->title)) //default
                $this->title='財富管理 - 信報網站 hkej.com';


            $fbarticleUrl = Yii::$app->params['www2Urlnoslash'].'/'.Yii::$app->controller->id.'/'.$action_id;
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

