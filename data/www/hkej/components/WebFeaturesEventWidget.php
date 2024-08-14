<?php
namespace app\components;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\FeaturesArticle;

class WebFeaturesEventWidget extends Widget
{	
	//private $topicsUrl='http://192.168.1.114/template/fulltextsearch/php/search_json_sp.php';
	private $hash='ksEjh8Gs3HG73sld';
	public $stickies;
	
	
	public function fetchTopics($tag, $page)
	{
		$articles=[];
		$cacheKey='features_widget_event_'.$tag.'_'.$page;
		$cache=Yii::$app->cache;
		$articles=$cache->get($cacheKey);

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


			curl_setopt_array($ch, ($options));
			if( ! $result = curl_exec($ch))
			{
				er('curl error occurs: '.curl_error($ch));
			}
			curl_close($ch);
			$articles=json_decode(FeaturesArticle::decryptStr(Yii::$app->params['featuresHash'], $result));
			//if(isset($articles)){
			if(count($articles) > 0){
				$cache->set($cacheKey, $articles, 300);
			}
		}
		//pr($articles);
		return $articles;
	}

	public function getStickies($tag='', $page=1)
	{
		$articles=[];
		$topics=$this->fetchTopics($tag, $page);
		//$topics=FeaturesArticle::fetchListing($tag, $page, $maxrows);		
		foreach($topics as $t){
			foreach($t as $k=>$v){
				if($k=='stickies'){
					$articles=$v;
					goto end;
				}
			}
		}
		end:
		return $articles;
	}

    public function init()
    {
		$this->stickies=$this->getStickies();
    }
    
    public function run()
    {
        return $this->render('web_feature_event_widget', ['stickies'=>$this->stickies]);
    }
}

?>