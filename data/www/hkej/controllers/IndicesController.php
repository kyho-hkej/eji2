<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class IndicesController extends Controller
{
	public $indices;

    public function actionIndex() 

    { 

    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$json = array();

    	$indicesLabel=array(
    			'.HSI'=>'恒生指數',
    			'.HSCE'=>'國企指數',
    			'.HSCC'=>'紅籌指數',
    			'.VHSI'=>'恒指波幅指數',
    			'.SSEC'=>'上證指數',
					'.CSI300'=>'滬深300指數',
					'.SZSC1'=>'深證成指',
					'.GDAXI'=>'法蘭克福DAX指數',
					'.FCHI'=>'巴黎CAC40指數',
					'.DJI'=>'道瓊斯工業指數',
					'.IXIC'=>'納斯達克綜合指數',
					'.SPX'=>'標準普爾500指數',
					'HSIF1'=>'恒指期貨日市(即月)',
					'HHIF1'=>'國指期貨日市(即月)',
					'HSIF1T1'=>'恒指期貨夜市(即月)',
					'HHIF1T1'=>'國指期貨夜市(即月)',
    	);
    	$url='https://dev2-stock360.hkej.com/data/getWorldIndices';
			//$url='http://uat-stock360.hkej.com/data/getWorldIndices';
    	$indicesCache=array();
    	$text=file_get_contents($url);
    	if($text){
    		$this->indices=json_decode($text);
    		foreach($indicesLabel as $k=>$v){
    			$indice=array();
	    		if($i=$this->getIndice($k)){
	    			$indice['Symbol']=$k;
	    			$indice['ChiName']=$i->ChiName;
	    			$indice['Last']=number_format ( $i->Last, 2);
	    			$indice['PctChange']=$i->PctChange;
	    			if (isset($i->Premium)) {
						$indice['Premium']=$i->Premium;
					} else {
						$indice['Premium']='';
					}
	    			$indice['lastupdate_vendor']=substr($i->lastupdate_vendor, 0, 16);
	    			if ($i->Change1 < 0) {
	    				$indice['arrowClass']='down';
	    				$indice['arrow']='/common/images/2011/data-dn-arrow.png';
	    			}else{
	    				$indice['arrowClass']='up';
	    				$indice['arrow']='/common/images/2011/data-up-arrow.png';
	    			}
	    			$indice['Change1']=number_format ( abs($i->Change1), 2);
	    			$indicesCache[$k]=$indice;
	    		}
    		}

			$json['indices'] = $indicesCache;
			$json['timestamp'] = date('Y-m-d H:i:s');
			$json['copyright_tc'] = '信報財經新聞有限公司版權所有，不得轉載。';
			$json['copyright_en'] = 'Hong Kong Economic Journal Co. Ltd. © All Rights Reserved.';


			if (isset($json['error']))
			{
					error_log('Error generating indices feed ' . $json['error']);

			}
			else if (isset($json['indices']) && count($json['indices']))
			{
					return $json;
			}



    	/* if (count($indicesCache) >= 10) {

  			Yii::$app->cache->set($cacheKey="indices", $indicesCache, 0);
    			//return $indicesCache;
    			print_r($indicesCache);
    	}else{
    			er( "failed to fetch all indices, only got ".count($indicesCache));
    			erpr($indicesCache);
    	} */
    		
    	}else{
    		er( "failed to fetch indices from stock360	.hkej.com\n");
    	}

    }

    private function getIndice($symbol){
    	foreach($this->indices->wdata as $i){
    		if ($i->Symbol == $symbol) {
    			return $i;
    		}
    	}
    	return null;
    }


}
?>
