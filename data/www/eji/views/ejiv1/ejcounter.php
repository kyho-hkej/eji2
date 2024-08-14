<script type="text/javascript">

  var ejValue={};
  
  ejValue['currentGMT']="<?php echo gmdate('c'); ?>";     
  ejValue['locationIp']="<?php echo (isset($_SERVER['HTTP_CF_CONNECTING_IP'])?$_SERVER['HTTP_CF_CONNECTING_IP']:$_SERVER['REMOTE_ADDR']); ?>";
  <?php if (isset($_SERVER['HTTP_CF_IPCOUNTRY'])) {?>
  ejValue['locationCountry']="<?php echo $_SERVER['HTTP_CF_IPCOUNTRY']; ?>"; 
  <?php } ?>   
  ejValue['categoryId']="1002";      
  ejValue['categoryName']="EJINSIGHT";  

  ejValue['firstSectionId']="<?php echo $article->firstSection;?>";    
  ejValue['firstSectionName']="<?php echo $sectionName; ?>"; 
  
  ejValue['sectionIdArray']="<?php echo $article->sectionId; ?>";
 
  ejValue['articleCmsId']="<?php echo $article->id; ?>";  
  ejValue['authorName']="<?php echo $authorName; ?>";      
  ejValue['articleCatId']="<?php //echo substr($this->article->getSection()->m_cat_Id, 1)?>"; 
  ejValue['articleCatName']="<?php //echo $this->getArticleCatName()?>"; 
  ejValue['articleTitile']="<?php echo $article->subjectline; ?>";
  ejValue['articleSubTitle']="<?php echo $article->subhead; ?>";  
  ejValue['columnName']="<?php //echo $article->storyProgName; ?>"; 
  ejValue['keywords']="<?php echo $article->tag; ?>";      
  ejValue['publishDateTime']="<?php echo $article->publishDate; ?>";
  ejValue['dnews_id']="<?php //echo $this->article->dnews_id; ?>";      
  ejValue['stockNumbers']="<?php echo $article->stockCode; ?>";   
  ejValue['newspaperPageNumber']="<?php echo $article->pageNum; ?>";
  ejValue['isFullArticle']="Y";
  ejValue['isTimeOpen']="N";			
  ejValue['isFreeOpen']="N";			
  
  <?php 

  $isMobilePage='';

  echo \Yii::$app->mobileDetect->isMobile();
  echo \Yii::$app->mobileDetect->isTablet();
  echo \Yii::$app->mobileDetect->isDesctop();

  // $detect = Yii::$app->mobileDetect;
    //if device is mobile, redirect to mobile version
    if (Yii::$app->mobileDetect->isMobile() && !Yii::$app->mobileDetect->isTablet()) {
        $isMobilePage='Y';
    } else {
        $isMobilePage='N';
    }


  ?>

  ejValue['isMobilePage']="<?php echo $isMobilePage; ?>";  	
  ejValue['typeOfPage']="Article";		
  ejValue['num']="<?php //echo $this->getUserId()*73; ?>";  
  ejValue['Forumname']="<?php //echo urlencode($this->getForumname()); ?>"; 

(function() {
		  var eja = document.createElement('script'); eja.type = 'text/javascript'; eja.async = true;
		  eja.src = ('https:' == document.location.protocol ? 'https://static' : 'http://static') + '.hkej.com/hkej/js/ejcounter.js?v='+Math.random();
		  var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(eja, x);
})();


</script>
