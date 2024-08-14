<div class="feature16-right-widget">
<div class="feature16-right-widget-header">活動專輯</div>
<div class="feature16-right-listing-banner">
	
	 
	<!-- Native ad banners on top -->
	<!-- /79812692/HKEJ_HomePage_Features_RightBanner -->	
	<!-- /79812692/HKEJ_HomePage_Features_RightBanner2 -->	
	<!-- /79812692/HKEJ_HomePage_Features_RightBanner3 -->
	<!-- End Native ad banners -->
	 
<?php
$path='/'.app()->controller->id.'/Category/code/';
foreach ($stickies as $k=>$v) {
		/*if (strpos($v->sectionId,'19002')=== false){*/		
		if ($v->thumbnail) {
			$thumb=$v->thumbnail;
		} else {
			$thumb=$thumb=param('staticUrl').'/backup_img/300x100.jpg';
		}?>
				<a href="<?php echo $v->extUrl;?>" target="_blank">

				<img src="<?php echo $thumb;?>" alt=""/></a>
<?php 		

		
		//}
}?>

</div>
<div class="feature-listing-article-more"><a href="/<?=app()->controller->id?>/Event">更多內容</a></div>
</div>