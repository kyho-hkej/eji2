<?php
use yii\helpers\EjHelper;
use app\models\Article;
use app\models\Author;

?>


<div id="hkej_right_column_author_news_2014">   <!-- author->articles start-->
<?php //echo count($author->articles);?>
<?php //if(count($author->articles) >0){ 
if ($articles) {?>
<ul class="hkej_inside_side_title_2014">
    <li  id="hkej_hi_news_tab_2014" class="hkej_onewsCat_2014_on"><img src="<?= Yii::$app->params['staticUrl']?>css/ui/sectiontitle_16.png" class="hkej_landing_title_cat_img" alt="作者文章" title="作者文章"/>    
    <span class="hkej_silderbar_title_author">— <a href="http://search.hkej.com/template/fulltextsearch/php/search.php?typeSearch=author&txtSearch=<?php echo $authorName?>"><?= $authorName ?></a></span></li>
</ul>
<ul class="hkej_sc-top_news_right_container_2014">

<?php
	//$i=0;
	$all=$articles;
	foreach($all as $article){
		//find section name
		if ($article->catId=='1027') {
				$articleUrl='/hkejwriter/article/id/'.$article->id.'/'.urlencode( $article->subjectline);
		} else {
			$j=$article->getSection()->m_cat_Id;
			$s=Yii::$app->params['dailynews_cate_name'][$j];
			//$articleUrl=$article->absUrl();
			if ((isset($s)) && (isset($j))) {
			$articleUrl='/dailynews/'.$s.'/article/'.$article->id.'/'.urlencode( $article->subjectline);
			} 

			/*else {
				$articleUrl='/hkejwriter/article/id/'.$article->id.'/'.urlencode( $article->subjectline);
			}*/
		}
?>
	  
   <li  class="hkej_sc-top_news_right_container_2014">
      <p class="top_news_right_detail"><a href="<?php echo $articleUrl ?>"><?php echo Ejhelper::recap($article->subjectline, 36);  ?></a></p>
      <p class="silder_editor_choice_author"><a href="http://search.hkej.com/template/fulltextsearch/php/search.php?typeSearch=author&txtSearch=<?php echo  $article->storyProgName ?>" class="silder_editor_choice_author_inside_2"><?php echo $article->storyProgName;  ?></a>  ｜  <?php echo EjHelper::short_relative_date_notime(strtotime($article->publishDate)) ?></p>
      </li>     

<?php
	//$i++;
	//if($i == 10){
		//break;
	//}
	}
?>
<p class="silder_editor_choice_author">
<a href="http://search.hkej.com/template/fulltextsearch/php/search.php?typeSearch=author&txtSearch=<?php echo $authorName ?>" target="_self">更多...</a>
</p>      
</ul>
<?php }?>
</div>
