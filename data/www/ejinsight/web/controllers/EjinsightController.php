<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use app\models\Article;
use app\models\Section;
use polucorus\simplehtmldom\SimpleHTMLDom as SHD;


class EjinsightController extends Controller
{
    public $title='';

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
        $this->layout = 'main';
        return parent::beforeAction($action);

    }


    public function actionArticle($id)
    {


        $article=Article::findById($id);

        if ($article) {
            //Article::updateViewCnt($id);
        } else {
            //$this->redirect('/lj');
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        }

        $tags=$article->tag;

        if($tags) {
            $relatedArticles=Article::findRelatedByHashtags($id, $tags, $limit=4);
            //$relatedArticles=array();
        } else {
            $relatedArticles=array();
        }

        $section = $article->getSection();

        //$seotags = $article->seoTags;

        
        return $this->render('article', [
 
                    'article'=>$article,
                    'relatedArticles'=>$relatedArticles,
                    'section'=>$section

        ]);
    }

    //for mobile article page ad insert after 1st paragraph 
    public function actionCodeconvert(){
        $id = $_GET["id"];
        //$article=DailyNews::findById($id);
        $article=Article::findById($id);    

        $article->content = str_replace("<blockquote>\n<p>", "<p class=\"quote\">", $article->content);
        $article->content = str_replace("</p>\n</blockquote>", "<span class=\"quote-close\"></span></p>", $article->content);
        //new size 940px
        /*$article->content = str_replace("_620.jpg", "_940.jpg", $article->content);
        $article->content = str_replace("_620.png", "_940.png", $article->content);
        $article->content = str_replace("_620.jpeg", "_940.jpeg", $article->content);*/

        //start manipulate article content
        // Create DOM from string

        $html = SHD::str_get_html($article->content); 

        if ((strlen($html)>0 )) {

            foreach($html->find('div p') as $div){
                //find 1st <a>
                $a = $div->find('a',0);
                $img_org = $a->href;
                $title = $a->title;
                //find 1st <img>
                
                $img = $div->find('img',0);
                $img_src = $img->src;
                if($a && $img)
                    $div->outertext = $this->getCodeTemplate($img_org, $img_src, $title);
            }
            
            //save result
            $result = $html->save();    
            $article->content = $result;
        }
        return $article->content;
        
    }
 
    public function actionCategory($category)
    {

        $section=Yii::$app->params['section2id'][$category];
        $limit = 49;
        $page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        //$total = 1000;
        $range = 180;

        if (($category == 'hongkong') || ($category == 'world') || ($category == 'currentaffairs')) {
            $sticky=[];
        } else {
            $sticky=Article::findBySection(Yii::$app->params['section2id']['sticky-'.$category], $range);
        }

        $tmp = Article::findAllBySection($section, $limit, $page, $total, $range);

        $articles=$this->takeOutDuplicated($tmp, $sticky, 50);

        $articles=array_merge($sticky, $articles);

        $section=Section::findByNav($category);

        if ($section) {
            $sectionLabel = $section['sectionLabel'];
        } else {
           foreach (Yii::$app->params['mainmenu_nav'] as $m) {
            if ($m['id']==$category) {
                $sectionLabel = $m['label'];
            }
           }
        }
        //$sectionLabel = $section->sectionLabel;

        return $this->render('listing', [
 
            'articles' => $articles,
            /*'pagination' => $pagination,
            'page' => $page,*/
            'category' => $category,
            'sectionLabel' => $sectionLabel,

        ]);

    }
 
    /*public function actionHongkong()
    {
        $section=Yii::$app->params['section2id']['hongkong'];
        $limit = 9;
        $page=isset($_REQUEST['page'])? $_REQUEST['page']: 1;
        //$total = 1000;
        $range = 180;

        $sticky=[];

        $tmp = Article::findAllBySection($section, $limit, $page, $total, $range);

        $articles=$this->takeOutDuplicated($tmp, $sticky, 10);

        $articles=array_merge($sticky, $articles);

        foreach($articles as $article){
            echo $article->subjectline;
            echo '<p>';
        }
    }*/


    public function actionIndex()
    {
        
        $this->view->title = '信報網站-EJINSIGHT';
        
        //$this->redirect('index');
        return $this->render('index');
        //echo 'hello abc';
    }


    public function actionMobdetect() {
        $detect =Yii::$app->mobileDetect;
        //$detect = new MobileDetect();
        var_dump($detect->getUserAgent());
    }

    public function getCodeTemplate($img_org, $img_src, $desc){
        $template = '<p style="text-align: center;"><img src="'.$img_src.'" alt="Image description"/>'."\n";
        $template  .=  '<span class="caption">'.$desc.'</span></p>';
        return $template;
    }

    public function getMainNavLabel($category){
        foreach (Yii::$app->params['mainmenu_nav'] as $m) {
            if ($category== $m['id']) {
                $label = $m['label'];
            }
        }
        return $label;
    }


    public function takeOutDuplicated($a1, $a2, $length){
    $ret=array();
    foreach ($a1 as $y){
        if(is_array($a2)){
            foreach ($a2 as $x){
                if ($x->id == $y->id) { // found exist
                    continue 2;
                }
            }
        }else{
            if ($a2->id == $y->id) { // found exist
                continue;
            }
        }
        $ret[]=$y;
    }
        $ret=array_slice ($ret, $offset=0, $length);
        return $ret;
    }

}

?>
