<?php 
class WebFeaturesEventWidget extends CWidget
{	
	//private $topicsUrl='http://192.168.1.114/template/fulltextsearch/php/search_json_sp.php';
	private $hash='ksEjh8Gs3HG73sld';
	public $stickies;
	
	
	public function fetchTopics($tag, $page)
	{
		$articles=[];
		$cacheKey='features_widget_event_'.$tag.'_'.$page;
		$articles=app()->cache->get($cacheKey);
		if($articles == false){
			$data=[];
			$url= param('featuresEventWidgetUrl') ;
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
			if (param('logErrorAll')) error_log("[feature2016] -- b4 curl $ch $url @ ".date('Y-m-d h:i:s'), 0);
			curl_setopt_array($ch, ($options));
			if( ! $result = curl_exec($ch))
			{
				er('curl error occurs: '.curl_error($ch));
			}
			curl_close($ch);
			if (param('logErrorAll')) error_log("[feature2016] -- after curl $ch @ ".date('Y-m-d h:i:s'), 0);
			$articles=json_decode(HKEJArticle::decryptStr($this->hash, $result));
			if(count($articles) > 0){
				app()->cache->set($cacheKey, $articles, 300);
			}
		}
		//pr($articles);
		return $articles;
	}
	/*
	public function getSpecials($page)
	{
		$specials=[];
		$topics=$this->fetchTopics($tag='', $page);
		foreach($topics as $t){
			foreach($t as $k=>$v){
				if($k=='specials'){
					$specials=$v;
					goto end;
				}
			}
	
		}
	
		end:
		return $specials;
	}*/
	
	public function getStickies($tag='', $page=1)
	{
		$articles=[];
		$topics=$this->fetchTopics($tag, $page);
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
	
	public function init() {
		//$specials=$this->getSpecials($page);
		$this->stickies=$this->getStickies();
		//$this->special_all = array_merge((array)$stickies,(array)$specials);
	}
	public function run(){		
		$this->render('feature_event_widget', array('stickies'=>$this->stickies));
	}
}

?>