<?php

use yii\helpers\EjHelper;
use uii\web\UrlManager;
?>

<div id="hkej_landing_editor_choice_2014">
<?php //EditorChoice1A, 1 article
$count = 10;
foreach ($articles_bysection_1A as $article) {
	$count++;
	
	//thumbnail
	if ($article->firstPhoto != '') {
		$imgUrl=$article->imgUrl($size=320);
	}else{
		$imgUrl=Yii::$app->params['staticUrl'].Yii::$app->params['generic_thumb'];
	}
	$my_VIDEOEXIST = $article->hasVideo();

	if ($article->freeUntil != '0000-00-00 00:00:00') {
		$today = date("Y-m-d H:i:s");
		if ($article->freeUntil > $today ) {
			$freeUntil=$article->freeUntil;
		} else {
			$freeUntil='';
		}
	} else {
		$freeUntil='';
	}
	
	//cate
	$my_CATENAME = $article->cat->catNameTc;
	if ($article->catId == '1009') {
		$my_CATEURL	 = Yii::$app->params['www1Urlnoslash'] . $article->cat->url;
	} else {
		$my_CATEURL	 = Yii::$app->params['www2Urlnoslash'] . $article->cat->url;
	}
	//topic
	$my_TOPIC = $article->subjectline;
	IF(mb_strlen($my_TOPIC,'utf8')> 20)
		$my_TOPIC = mb_substr($my_TOPIC,0,20,"UTF-8").'…';
	
	//desc
	if ($article->author) {
		if (($article->catId == '1009') || ($article->catId == '1021')){
			$authorUrl='http://search.hkej.com/template/fulltextsearch/php/search.php?typeSearch=author&txtSearch='.$article->author->authorName;
		} else {
			$authorUrl=$my_CATEURL.'AuthorDetail/id/'.$article->author->id;
		}	
		$authorName = $article->author->authorName;
		
		$my_DESC = '<a href="'.$authorUrl.'">'.$article->author->authorName.'</a>';
	} else {
		$authorName = '';
		$authorUrl= '';
		$my_DESC = '';
	}

	$my_URL = $article->absUrl();
	$my_URL = str_replace(".com//", ".com/", $my_URL);
	
	$merge_article[$article->publishDate.$count] = array('HAS_VDO'=>$my_VIDEOEXIST,'HAS_TIME_REMAIN'=>$freeUntil,'THUMB'=>$imgUrl,'TOPIC'=>$my_TOPIC,'DESC'=>$my_DESC,'URL'=>$my_URL,'CATE_NAME'=>$my_CATENAME,'CATE_URL'=>$my_CATEURL,'AUTHOR_URL'=>$authorUrl,'AUTHOR_NAME'=>$authorName);
}

foreach ($articles_bycate_1A as $article) {
	$count++;
	
	//thumbnail
	if ($article->firstPhoto != '') {
		$imgUrl=$article->imgUrl($size=320);
	}else{
		$imgUrl=Yii::$app->params['staticUrl'].Yii::$app->params['generic_thumb'];
	}
	$my_VIDEOEXIST = $article->hasVideo();
	
	if ($article->freeUntil != '0000-00-00 00:00:00') {
		$today = date("Y-m-d H:i:s");
		if ($article->freeUntil > $today ) {
			$freeUntil=$article->freeUntil;
		} else {
			$freeUntil='';
		}
	} else {
		$freeUntil='';
	}

	//cate
	$my_CATENAME = '';
	$my_CATEURL	 = '';
	$authorUrl = '';
	//topic
	$my_TOPIC = $article->subjectline;
	//desc
	$my_DESC = $article->content;
	//article_URL
	$my_URL = $article->URL;
	
	$merge_article[$article->publishDate.$count] = array('IS_FREETEXT'=>true,'HAS_VDO'=>$my_VIDEOEXIST,'HAS_TIME_REMAIN'=>$freeUntil,'THUMB'=>$imgUrl,'TOPIC'=>$my_TOPIC,'DESC'=>$my_DESC,'URL'=>$my_URL,'CATE_NAME'=>$my_CATENAME,'CATE_URL'=>$my_CATEURL,'AUTHOR_URL'=>$authorUrl,'AUTHOR_NAME'=>$authorName);
}

krsort($merge_article);
?>

    
    <ul class="hkej_online-news-menu_2014">
    <li  id="hkej_hi_news_tab_2014" class="hkej_onewsCat_2014_on"><img src="<?php echo Yii::$app->params['staticUrl']?>css/ui/sectiontitle_04.png" class="hkej_landing_title_cat_img" alt="編輯推介" title="編輯推介"/></li>
    </ul>
    
    <ul class="hkej_sc-editor_choice_lv_container_2014">

<?php
	$count = 1; 
	foreach ($merge_article as $myDATE => $article) {
	?>
    <li class="hkej_sc-editor_choice_big_container_2014">
    	<?php	if($article['URL']!='' && $article['URL']!='#'){	?><a href="<?php echo $article['URL'];?>"><?php	}	?>
    <?php	
			if ($article['HAS_VDO'] ) {
    		?><img src="<?php echo Yii::$app->params['staticUrl']?>css/ui/vfin_playbtn.png" class="edcplaybtn"><?php
    		}
    		if ($article['HAS_TIME_REMAIN']) { ?>
		    <div class="timer_highlight"><!--剩餘時間:--> <?php echo EjHelper::show_time_remain($article['HAS_TIME_REMAIN']);?><span  class="editor_ch_freeicon" /></span ></div>
    		<?php }
    ?>		
		<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="table-layout:fixed;">
    	<tr>
    		<td align="center" valign="middle"><img src="<?php echo $article['THUMB'];?>" class="editor_choice_pic_big"/>
    		</td>
    	</tr>
    	</table>
    	<?php if ($article['HAS_TIME_REMAIN']) { ?>
    	<?php }?>	 			
    	<?php	if($article['URL']!='' && $article['URL']!='#'){	?></a><?php	}	?>
    	<?php	if(isset($article['IS_FREETEXT'])){	?>
    		<?php echo $article['DESC'];?>
      <?php	}else{	?>
     	 <p class="editor_choice_detail"><a href="<?php echo $article['URL'];?>"><?php echo $article['TOPIC'];?></a></p>
     	 <p class="editor_choice_author"><a href="<?php echo $article['AUTHOR_URL'];?>" class="editor_choice_author_inside"><?php echo $article['AUTHOR_NAME'];?></a>
      		<?php	if(($article['AUTHOR_NAME']!='') && ($article['CATE_NAME']!='')){	?>
      	 ｜ 
     			<?php	}	?>
       		<?php	if($article['CATE_NAME']!=''){	?>
      	 	<a href="<?php echo $article['CATE_URL'];?>" ><?php echo $article['CATE_NAME'];?></a>
	  		 	<?php	}	?>
	   </p>
		<?php	}	?>
	</li>
<?php
	$count++;
	if($count>1)
	break;
	}
?>  
<!-- //EditorChoice1A End--> 
<?php //EditorChoice1B, 1 article
$count_1B = 10;
foreach ($articles_bysection_1B as $article) {
	$count_1B++;
	
	//thumbnail
	if ($article->firstPhoto != '') {
		$imgUrl_1B=$article->imgUrl($size=320);
	}else{
		$imgUrl_1B=Yii::$app->params['staticUrl'].Yii::$app->params['generic_thumb'];
	}
	$my_VIDEOEXIST_1B = $article->hasVideo();

	if ($article->freeUntil != '0000-00-00 00:00:00') {
		$today_1B = date("Y-m-d H:i:s");
		if ($article->freeUntil > $today_1B ) {
			$freeUntil_1B=$article->freeUntil;
		} else {
			$freeUntil_1B='';
		}
	} else {
		$freeUntil_1B='';
	}
	
	//cate
	$my_CATENAME_1B = $article->cat->catNameTc;
	if ($article->catId == '1009') {
		$my_CATEURL_1B	 = Yii::$app->params['www1Urlnoslash'] . $article->cat->url;
		
	} else {
		$my_CATEURL_1B	 = Yii::$app->params['www2Urlnoslash'] . $article->cat->url;
	}
	//topic
	$my_TOPIC_1B = $article->subjectline;
	IF(mb_strlen($my_TOPIC_1B,'utf8')> 20)
		$my_TOPIC_1B = mb_substr($my_TOPIC_1B,0,20,"UTF-8").'…';
	
	//desc
	if (($article->catId == '1009') || ($article->catId == '1021')){
		$authorUrl_1B='http://search.hkej.com/template/fulltextsearch/php/search.php?typeSearch=author&txtSearch='.$article->author->authorName;
	} else {
		$authorUrl_1B=$my_CATEURL_1B.'AuthorDetail/id/'.$article->author->id;
	}	
	$authorName_1B = $article->author->authorName;
	
	$my_DESC_1B = '<a href="'.$authorUrl_1B.'">'.$article->author->authorName.'</a>';

	$my_URL_1B = $article->absUrl();
	$my_URL_1B = str_replace(".com//", ".com/", $my_URL_1B);
	
	
	$merge_article_1B[$article->publishDate.$count_1B] = array('HAS_VDO_1B'=>$my_VIDEOEXIST_1B,'HAS_TIME_REMAIN_1B'=>$freeUntil_1B,'THUMB_1B'=>$imgUrl_1B,'TOPIC_1B'=>$my_TOPIC_1B,'DESC_1B'=>$my_DESC_1B,'URL_1B'=>$my_URL_1B,'CATE_NAME_1B'=>$my_CATENAME_1B,'CATE_URL_1B'=>$my_CATEURL_1B,'AUTHOR_URL_1B'=>$authorUrl_1B,'AUTHOR_NAME_1B'=>$authorName_1B);
}
foreach ($articles_bycate_1B as $article) {
	$count_1B++;
	
	//thumbnail
	if ($article->firstPhoto != '') {
		$imgUrl_1B=$article->imgUrl($size=320);
	}else{
		$imgUrl_1B=Yii::$app->params['staticUrl'].Yii::$app->params['generic_thumb'];
	}
	$my_VIDEOEXIST_1B = $article->hasVideo();
	
	if ($article->freeUntil != '0000-00-00 00:00:00') {
		$today_1B = date("Y-m-d H:i:s");
		if ($article->freeUntil > $today_1B ) {
			$freeUntil_1B=$article->freeUntil;
		} else {
			$freeUntil_1B='';
		}
	} else {
		$freeUntil_1B='';
	}

	//cate
	$my_CATENAME_1B = '';
	$my_CATEURL_1B	 = '';
	$authorUrl_1B = '';

	//topic
	$my_TOPIC_1B = $article->subjectline;
	//desc
	$my_DESC_1B = $article->content;
	//article_URL
	$my_URL_1B = $article->URL;
	
	$merge_article_1B[$article->publishDate.$count_1B] = array('IS_FREETEXT_1B'=>true,'HAS_VDO_1B'=>$my_VIDEOEXIST_1B,'HAS_TIME_REMAIN_1B'=>$freeUntil_1B,'THUMB_1B'=>$imgUrl_1B,'TOPIC_1B'=>$my_TOPIC_1B,'DESC_1B'=>$my_DESC_1B,'URL_1B'=>$my_URL_1B,'CATE_NAME_1B'=>$my_CATENAME_1B,'CATE_URL_1B'=>$my_CATEURL_1B,'AUTHOR_URL_1B'=>$authorUrl_1B,'AUTHOR_NAME_1B'=>$authorName_1B);
}

krsort($merge_article_1B);
?>    
    

<?php
	$count_1B = 1; 
	foreach ($merge_article_1B as $myDATE_1B => $article) {
	?>
    <li class="hkej_sc-editor_choice_big_container_2014">
    	<?php	if($article['URL_1B']!='' && $article['URL_1B']!='#'){	?><a href="<?php echo $article['URL_1B'];?>"><?php	}	?>
    <?php	
			if ($article['HAS_VDO_1B'] ) {
    		?><img src="<?php echo app()->params['staticUrl']?>css/ui/vfin_playbtn.png" class="edcplaybtn"><?php
    		}
    		if ($article['HAS_TIME_REMAIN_1B']) { ?>
		    <div class="timer_highlight"><!--剩餘時間:--> <?php echo EjHelper::show_time_remain($article['HAS_TIME_REMAIN_1B']);?><span  class="editor_ch_freeicon" /></span ></div>
    		<?php }
    ?>		
		<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="table-layout:fixed;">
    	<tr>
    		<td align="center" valign="middle"><img src="<?php echo $article['THUMB_1B'];?>" class="editor_choice_pic_big"/>
    		</td>
    	</tr>
    	</table>
    	<?php if ($article['HAS_TIME_REMAIN_1B']) { ?>
    	<?php }?>	 			
    	<?php	if($article['URL_1B']!='' && $article['URL_1B']!='#'){	?></a><?php	}	?>
    	<?php	if(isset($article['IS_FREETEXT_1B'])){	?>
    		<?php echo $article['DESC_1B'];?>
      <?php	}else{	?>
     	 <p class="editor_choice_detail"><a href="<?php echo $article['URL_1B'];?>"><?php echo $article['TOPIC_1B'];?></a></p>
     	 <p class="editor_choice_author"><a href="<?php echo $article['AUTHOR_URL_1B'];?>" class="editor_choice_author_inside"><?php echo $article['AUTHOR_NAME_1B'];?></a>
      		<?php	if(($article['AUTHOR_NAME_1B']!='') && ($article['CATE_NAME_1B']!='')){	?>
      	 ｜ 
     			<?php	}	?>
       		<?php	if($article['CATE_NAME_1B']!=''){	?>
      	 	<a href="<?php echo $article['CATE_URL_1B'];?>" ><?php echo $article['CATE_NAME_1B'];?></a>
	  		 	<?php	}	?>
	   </p>
		<?php	}	?>
	</li>
<?php
	$count_1B++;
	if($count_1B>1)
	break;
	}
?>  


<!-- //EditorChoice1B End--> 


    
<?php //EditorChoice2, 3 articles
$count2 = 10;
foreach ($articles_bysection2 as $article) {
	$count2++;
	
	//thumbnail
	if ($article->firstPhoto != '') {
		$imgUrl2=$article->imgUrl($size=200);
	}else{
		$imgUrl2=Yii::$app->params['staticUrl'].Yii::$app->params['generic_thumb'];
	}
	$my_VIDEOEXIST2 = $article->hasVideo();
	if ($article->freeUntil != '0000-00-00 00:00:00') {
		$today2 = date("Y-m-d H:i:s");
		if ($article->freeUntil > $today2 ) {
			$freeUntil2=$article->freeUntil;
		} else {
		$freeUntil2='';
	}
	} else {
		$freeUntil2='';
	}
	//cate
	$my_CATENAME2 = $article->cat->catNameTc;
	
	if ($article->catId == '1009')  {
		$my_CATEURL2	 = Yii::$app->params['www1Urlnoslash'] . $article->cat->url;
	} else {
		$my_CATEURL2	 = Yii::$app->params['www2Url'] . $article->cat->url;
	}	
	//topic
	$my_TOPIC2 = $article->subjectline;
	IF(mb_strlen($my_TOPIC2,'utf8')> 20)
		$my_TOPIC2 = mb_substr($my_TOPIC2,0,20,"UTF-8").'…';
	
	//desc
	if ($article->author) {
		if (($article->catId == '1009') || ($article->catId == '1021')){
			$authorUrl2='https://search.hkej.com/template/fulltextsearch/php/search.php?typeSearch=author&txtSearch='.$article->author->authorName;
		} else {
			$authorUrl2=$my_CATEURL2.'AuthorDetail/id/'.$article->author->id;
		}	
		$authorName2 = $article->author->authorName;
		
		$my_DESC2 = '<a href="'.$authorUrl2.'">'.$article->author->authorName.'</a>';

	} else {
		$my_DESC2 = '';
		$authorName2='';
		$authorUrl2='';
	}
	
	//article_URL
	$my_URL2 = $article->absUrl();
	$my_URL2 = str_replace(".com//", ".com/", $my_URL2);

	$merge_article2[$article->publishDate.$count2] = array('HAS_VDO2'=>$my_VIDEOEXIST2,'HAS_TIME_REMAIN2'=>$freeUntil2,'THUMB2'=>$imgUrl2,'TOPIC2'=>$my_TOPIC2,'DESC2'=>$my_DESC2,'URL2'=>$my_URL2,'CATE_NAME2'=>$my_CATENAME2,'CATE_URL2'=>$my_CATEURL2,'AUTHOR_URL2'=>$authorUrl2,'AUTHOR_NAME2'=>$authorName2);
}
foreach ($articles_bycate2 as $article) {
	$count2++;
	
	//thumbnail
	if ($article->firstPhoto != '') {
		$imgUrl2=$article->imgUrl($size=200);
	}else{
		$imgUrl2=Yii::$app->params['staticUrl'].Yii::$app->params['generic_thumb'];
	}
	$my_VIDEOEXIST2 = $article->hasVideo();
	if ($article->freeUntil != '0000-00-00 00:00:00') {
		$today2 = date("Y-m-d H:i:s");
		if ($article->freeUntil > $today2 ) {
			$freeUntil2=$article->freeUntil;
		} else {
		$freeUntil2='';
		}
	} else {
		$freeUntil2='';
	}
	//cate
	$my_CATENAME2 = '';
	$my_CATEURL2	 = '';
	$authorUrl2 = '';
	//topic
	$my_TOPIC2 = $article->subjectline;
	//desc
	$my_DESC2 = $article->content;
	//article_URL
	$my_URL2 = $article->URL;
	
	$merge_article2[$article->publishDate.$count2] = array('IS_FREETEXT2'=>true,'HAS_VDO2'=>$my_VIDEOEXIST2,'HAS_TIME_REMAIN2'=>$freeUntil2,'THUMB2'=>$imgUrl2,'TOPIC2'=>$my_TOPIC2,'DESC2'=>$my_DESC2,'URL2'=>$my_URL2,'CATE_NAME2'=>$my_CATENAME2,'CATE_URL2'=>$my_CATEURL2,'AUTHOR_URL2'=>$authorUrl2,'AUTHOR_NAME2'=>$authorName2);
}

krsort($merge_article2);

	$count2 = 1; 
	foreach ($merge_article2 as $myDATE2 => $article) {
?>
    <li class="hkej_sc-editor_choice_container_2014">
   	<?php	if($article['URL2']!='' && $article['URL2']!='#'){	?><a href="<?php echo $article['URL2'];?>"><?php	}	?>
    <?php	
			if ($article['HAS_VDO2'] ) {
    		?><img src="<?php echo app()->params['staticUrl']?>css/ui/vfin_playbtn.png" class="edcplaybtn"><?php
    		}
    		if ($article['HAS_TIME_REMAIN2']) { ?>
		    <div class="timer_highlight_s"><!--剩餘時間:--><?php echo EjHelper::show_time_remain($article['HAS_TIME_REMAIN2']);?><span  class="editor_ch_freeicon" /></span ></div>
    		<?php } ?>
    		<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="table-layout:fixed;">
    		<tr>
    			<td align="center" valign="middle"><img src="<?php echo $article['THUMB2'];?>" class="editor_choice_pic"/></td>
    		</tr>
    		</table>
    	<?php if ($article['HAS_TIME_REMAIN2']) { ?>    			
    	<?php }?>
    	<?php	if($article['URL2']!='' && $article['URL2']!='#'){	?></a><?php	}	?>
    	<?php	if(isset($article['IS_FREETEXT2'])){	?>
    		<?php echo $article['DESC2'];?>
      <?php	}else{	?>
     	 <p class="editor_choice_detail"><a href="<?php echo $article['URL2'];?>"><?php echo $article['TOPIC2'];?></a></p>
     	 <p class="editor_choice_author"><a href="<?php echo $article['AUTHOR_URL2'];?>" class="editor_choice_author_inside"><?php echo $article['AUTHOR_NAME2'];?></a>
      		<?php	if(($article['AUTHOR_NAME2']!='') && ($article['CATE_NAME2']!='')) {	?>
      	 ｜ 
     			<?php	}	?>
       		<?php	if($article['CATE_NAME2']!=''){	?>
      	 	<a href="<?php echo $article['CATE_URL2'];?>" ><?php echo $article['CATE_NAME2'];?></a>
	  		 	<?php	}	?>
	   </p>
		<?php	}	?>
	</li>
<?php 
	$count2++;
	if($count2>3)
	break;
	}
?>  
<!-- //EditorChoice2 End-->
    
<?php //EditorChoice3, 3 articles
$count3 = 10;
foreach ($articles_bysection3 as $article) {
	$count3++;
	
	//thumbnail
	if ($article->firstPhoto != '') {
		$imgUrl3=$article->imgUrl($size=200);
	}else{
		$imgUrl3=Yii::$app->params['staticUrl'].Yii::$app->params['generic_thumb'];
	}
	$my_VIDEOEXIST3 = $article->hasVideo();
	if ($article->freeUntil != '0000-00-00 00:00:00') {
		$today3 = date("Y-m-d H:i:s");
		if ($article->freeUntil > $today3 ) {
			$freeUntil3=$article->freeUntil;
		} else {
		$freeUntil3='';
		}
	} else {
		$freeUntil3='';
	}
	//cate
	$my_CATENAME3 = $article->cat->catNameTc;
	
	if ($article->catId == '1009') {
		$my_CATEURL3	 = Yii::$app->params['www1Urlnoslash'] . $article->cat->url;
	} else {
		//$my_CATEURL3	 = app()->createAbsoluteUrl() . $article->cat->url;
		$my_CATEURL3	 = Yii::$app->params['www2Urlnoslash'] . $article->cat->url;
	}
	//topic
	$my_TOPIC3 = $article->subjectline;
	IF(mb_strlen($my_TOPIC3,'utf8')> 20)
		$my_TOPIC3 = mb_substr($my_TOPIC3,0,20,"UTF-8").'…';
	
	//desc
	if (($article->catId == '1009') || ($article->catId == '1021')){
		$authorUrl3='http://search.hkej.com/template/fulltextsearch/php/search.php?typeSearch=author&txtSearch='.$article->author->authorName;
	} else {
		$authorUrl3=$my_CATEURL3.'AuthorDetail/id/'.$article->author->id;
	}		
	$authorName3 = $article->author->authorName;
	//echo $authorName.'?';
	
	$my_DESC3 = '<a href="'.$authorUrl3.'">'.$article->author->authorName.'</a>';
	//article_URL
	$my_URL3 = $article->absUrl();
	$my_URL3 = str_replace(".com//", ".com/", $my_URL3);
	
	$merge_article3[$article->publishDate.$count3] = array('HAS_VDO3'=>$my_VIDEOEXIST3,'HAS_TIME_REMAIN3'=>$freeUntil3,'THUMB3'=>$imgUrl3,'TOPIC3'=>$my_TOPIC3,'DESC3'=>$my_DESC3,'URL3'=>$my_URL3,'CATE_NAME3'=>$my_CATENAME3,'CATE_URL3'=>$my_CATEURL3,'AUTHOR_URL3'=>$authorUrl3,'AUTHOR_NAME3'=>$authorName3);
}
foreach ($articles_bycate3 as $article) {
	$count3++;
	
	//thumbnail
	if ($article->firstPhoto != '') {
		$imgUrl3=$article->imgUrl($size=200);
	}else{
		$imgUrl3=Yii::$app->params['staticUrl'].Yii::$app->params['generic_thumb'];
	}
	$my_VIDEOEXIST3 = $article->hasVideo();
	if ($article->freeUntil != '0000-00-00 00:00:00') {
		$today3 = date("Y-m-d H:i:s");
		if ($article->freeUntil > $today3 ) {
			$freeUntil3=$article->freeUntil;
		} else {
		$freeUntil3='';
		}
	} else {
		$freeUntil3='';
	}
	//cate
	$my_CATENAME3 = '';
	$my_CATEURL3	 = '';
	$authorUrl3 = '';
	//topic
	$my_TOPIC3 = $article->subjectline;
	//desc
	$my_DESC3 = $article->content;
	//article_URL
	$my_URL3 = $article->URL;
	
	$merge_article3[$article->publishDate.$count3] = array('IS_FREETEXT3'=>true,'HAS_VDO3'=>$my_VIDEOEXIST3,'HAS_TIME_REMAIN3'=>$freeUntil3,'THUMB3'=>$imgUrl3,'TOPIC3'=>$my_TOPIC3,'DESC3'=>$my_DESC3,'URL3'=>$my_URL3,'CATE_NAME3'=>$my_CATENAME3,'CATE_URL3'=>$my_CATEURL3,'AUTHOR_URL3'=>$authorUrl3,'AUTHOR_NAME3'=>$authorName3);
}

krsort($merge_article3);

	$count3 = 1; 
	foreach ($merge_article3 as $myDATE3 => $article) {
	?>
    <li class="hkej_sc-editor_choice_container_2014">
    <?php	if($article['URL3']!='' && $article['URL3']!='#'){	?><a href="<?php echo $article['URL3'];?>"><?php	}	?>
    <?php	
			if ($article['HAS_VDO3'] ) {
    		?><img src="<?php echo Yii::$app->params['staticUrl']?>css/ui/vfin_playbtn.png" class="edcplaybtn"><?php
    		}
    		if ($article['HAS_TIME_REMAIN3']) { ?>
		    <div class="timer_highlight_s"><!--剩餘時間:--><?php echo EjHelper::show_time_remain($article['HAS_TIME_REMAIN3']);?><span  class="editor_ch_freeicon" /></span ></div>
    		<?php } ?>
    		<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="table-layout:fixed;">
    		<tr>
    			<td align="center" valign="middle"><img src="<?php echo $article['THUMB3'];?>" class="editor_choice_pic"/></td>
    		</tr>
    		</table>
    		<?php if (isset($article['HAS_TIME_REMAIN3'])) {?>    		
    		<?php }?>
    	<?php	if($article['URL3']!='' && $article['URL3']!='#'){	?></a><?php	}	?>
    	<?php	if(isset($article['IS_FREETEXT3'])){	?>
    		<?php echo $article['DESC3'];?>
      <?php	}else{	?>
     	 <p class="editor_choice_detail"><a href="<?php echo $article['URL3'];?>"><?php echo $article['TOPIC3'];?></a></p>
     	 <p class="editor_choice_author"><a href="<?php echo $article['AUTHOR_URL3'];?>" class="editor_choice_author_inside"><?php echo $article['AUTHOR_NAME3'];?></a>
      		<?php	if(($article['AUTHOR_NAME3']!='') && ($article['CATE_NAME3']!='')){	?>
      	 ｜ 
     			<?php	}	?>
       		<?php	if($article['CATE_NAME3']!=''){	?>
      	 	<a href="<?php echo $article['CATE_URL3'];?>" ><?php echo $article['CATE_NAME3'];?></a>
	  		 	<?php	}	?>
	   </p>
		<?php	}	?>
	</li>

<?php
	$count3++;
		if($count3>3)
			break;
		
	}

?>  
<!-- //EditorChoice3 End-->
</ul>
</div>               
