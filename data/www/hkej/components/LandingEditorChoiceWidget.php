<?php
namespace app\components;
use Yii;
use yii\base\Widget;
use yii\helpers\EjHelper;
use yii\helpers\Html;
use app\models\Article;
use app\models\DailyNews;

class LandingEditorChoiceWidget extends Widget {

    public $articles_bysection=null;
    public $articles_bycate=null;
    public $articles_bysection_1A=null;
    public $articles_bycate_1A=null;
    public $articles_bysection_1B=null;
    public $articles_bycate_1B=null;    
    public $articles_bysection2=null;
    public $articles_bycate2=null;
    public $articles_bysection3=null;
    public $articles_bycate3=null;

    public function init()
    {
        parent::init();

        //Editor Choice1A

        $this->articles_bysection_1A = Article::findBySection2(Yii::$app->params['section2id']["sticky-ec1A"], $range=31);

        $this->articles_bycate_1A = Article::findBySection2(Yii::$app->params['section2id']["sticky-ec1B"], $range=31);
        //Editor Choice1B
        $limit=2; 
        $page=1; 
        $total=2;
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec1A2'], $limit, $page, $total, $range=31);     
        $this->articles_bysection_1B=EjHelper::takeOutDuplicated($tmp, $this->articles_bysection_1A, 1);
        
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec1B2'], $limit, $page, $total, $range=31);  
        $this->articles_bycate_1B=Ejhelper::takeOutDuplicated($tmp, $this->articles_bycate_1A, 1);
                                
        $this->articles_bysection=array_merge($this->articles_bysection_1A, $this->articles_bysection_1B);
        $this->articles_bycate=array_merge($this->articles_bycate_1A, $this->articles_bycate_1B);               
        

        //Editor Choice2
        $limit=5; 
        $page=1; 
        $total=5;
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec2A'], $limit, $page, $total, $range=31);  
        $this->articles_bysection2=Ejhelper::takeOutDuplicated($tmp, $this->articles_bysection, 3);       

        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec2B'], $limit, $page, $total, $range=31);   
        $this->articles_bycate2=Ejhelper::takeOutDuplicated($tmp, $this->articles_bycate, 3);     


        //Editor Choice3
        $limit=8; 
        $page=1; 
        $total=8;
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec3A'], $limit, $page, $total, $range=31);
        $tmp2=Ejhelper::takeOutDuplicated($tmp, $this->articles_bysection, 6);
        $this->articles_bysection3  = Ejhelper::takeOutDuplicated($tmp2, $this->articles_bysection2, 3);      
        $tmp=Article::findAllBySection2(Yii::$app->params['section2id']['sticky-ec3B'], $limit, $page, $total, $range=31);
        $tmp2=Ejhelper::takeOutDuplicated($tmp, $this->articles_bycate, 6);
        $this->articles_bycate3  = Ejhelper::takeOutDuplicated($tmp2, $this->articles_bycate2, 3);


        //$ec_articles = array_merge($this->articles_bysection,$this->articles_bycate,$this->articles_bysection2,$this->articles_bycate2);
        

    }

    public function run()

    {


        return $this->render('landing_editor_choice', [
                'articles_bysection_1A'=>$this->articles_bysection_1A,
                'articles_bycate_1A'=>$this->articles_bycate_1A,
                'articles_bysection_1B'=>$this->articles_bysection_1B,
                'articles_bycate_1B'=>$this->articles_bycate_1B,
                'articles_bysection2'=>$this->articles_bysection2,
                'articles_bycate2'=>$this->articles_bycate2,
                'articles_bysection3'=>$this->articles_bysection3,
                'articles_bycate3'=>$this->articles_bycate3
                ]);

    }
}
?>