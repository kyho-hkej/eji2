<div class="feature16-right-widget">
<div class="feature16-right-widget-header">熱門主題</div>
<div class="feature16-right-listing-banner">
	
<?php

foreach ($stickies as $k=>$v) {	
	if (strpos($v->sectionId,'19002')=== false){ //exclude native (Sticky,hkej主頁,系列Banner)
		if ($v->thumbnail) {
			$thumb=$v->thumbnail;
		} else {
			$thumb=$thumb=Yii::$app->params['staticUrl'].'backup_img/300x100.jpg';
		}
			//check if not marketing promotion features or redirect content
			if ((strpos($v->sectionId,'19006') === false) &&
				(strpos($v->sectionId,'19016') === false) && 
				(strpos($v->sectionId,'19017') === false) && 
				(strpos($v->sectionId,'19018') === false) && 
				(strpos($v->sectionId,'19024') === false) &&
				(strpos($v->sectionId,'19015') === false) &&
				(strpos($v->sectionId,'19028') === false)) //redirect content
			{
				$TopicUrl='/features/topic/tag/'.str_replace('#', '', $v->tag);
			?> 
				<a href="<?php echo $TopicUrl;?>">
			<?php					
				} else {
			?>
					<a href="<?php echo $v->extUrl;?>" target="_blank">
			<?php 
			}
		?>
			<img src="<?php echo $thumb;?>" alt=""/></a>
<?php 		

		
	}
}?>
</div>
<div class="feature-listing-article-more"><a href="/features/all">更多內容</a></div>
</div>