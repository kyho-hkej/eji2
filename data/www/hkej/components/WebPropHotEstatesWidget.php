<?php
namespace app\components;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Estate;

class WebPropHotEstatesWidget extends Widget {


    public $estates=null;

    public function init()
    {
        $this->estates=Estate::getHotEstates();

    }
    
    public function run()
    {
        /*echo $sectionIds;
        return $sectionIds;*/
        return $this->render('web_prop_hot_estate', ['estates' => $this->estates]);
    }
}
?>