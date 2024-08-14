<div class="feature16-right-widget">
<div class="feature16-right-widget-header">活動專輯</div>
<div class="feature16-right-listing-banner">
	
<?php
$path='/features/category/code/';
foreach ($stickies as $k=>$v) {
		/*if (strpos($v->sectionId,'19002')=== false){*/		
		if ($v->thumbnail) {
			$thumb=$v->thumbnail;
		} else {
			$thumb=$thumb=Yii::$app->params['staticUrl'].'/backup_img/300x100.jpg';
		}?>
				<a href="<?php echo $v->extUrl;?>" target="_blank">

				<img src="<?php echo $thumb;?>" alt=""/></a>
<?php 		

		
		//}
}?>

</div>
<div class="feature-listing-article-more"><a href="/features/event">更多內容</a></div>
</div>