<?php
use yii\helpers\EjHelper;
use app\models\Article;
use app\models\Author;
?>
<div id="hkej_right_column_top_news_2014">   <!--Most popular start-->
        <li  id="hkej_hi_news_tab_2014" class="hkej_onewsCat_2014_on"><img src="<?=Yii::$app->params['staticUrl']?>css/ui/sectiontitle_20.png" class="hkej_landing_title_cat_img" alt="今日熱門新聞" title="今日熱門新聞"/> </li>
<ul class="hkej_sc-top_news_right_container_2014">
<?php if($articles !==false){
	foreach($articles as $article){
		 											//author
                          $author = Author::findOne($article->authorId);
                          if ($author){
                              $authorName=$author->authorName;
                              /*if ($article->storyProgName) {
                                  $authorName=$author->authorName.' | '.$article->storyProgName;
                              } else {
                                  $authorName=$author->authorName;
                              }*/
                          } else {
                              $authorName='';
                              /*if ($article->storyProgName) {
                                  $authorName=$article->storyProgName;
                              }*/
                          }
		//find section name
		$i=$article->getSection()->m_cat_Id;		
		$s=Yii::$app->params['dailynews_cate_name'][$i];
		
		//$articleUrl=$article->absUrl();		
		$articleUrl='/dailynews/'.$s.'/article/'.$article->id.'/'.urlencode( $article->subjectline);
		$URLs=array();
		if ($article->authorId) {
			//$authorName=$article->author->authorName;
			$URLs[] ='<p class="silder_editor_choice_author"><a href="'.Yii::$app->params['searchUrl'].'?typeSearch=author&q='.$authorName.'" class="silder_editor_choice_author_inside"> '.$authorName.'</a>' ;
		}
		if ($article->storyProgName) {
			$URLs[]='<a href="'.Yii::$app->params['searchUrl'].'?typeSearch=column&q='.$article->storyProgName.'" >'.$article->storyProgName.'</a>';
		}
?>
  <li  class="hkej_sc-top_news_right_container_2014">
      <p class="top_news_right_detail"><a href="<?php echo $articleUrl;?>"><a href="<?php echo $articleUrl; ?>"><?php echo $article->subjectline; ?><?php echo $article->subhead; ?></a></p>
      <p class="silder_editor_choice_author">
      <?php echo implode(' | ', $URLs) ?>
      </p>
      </li>
<?php 
	}
}
?>
</ul>
</div>