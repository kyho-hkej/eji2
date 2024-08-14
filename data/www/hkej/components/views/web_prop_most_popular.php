<?php
use yii\helpers\EjHelper;
use app\models\Author;
use app\models\Section;
?>

<!-- hot_articles  -->

<div class="hkej_right_column_top_news_2014"><!--Most popular start-->
<li  id="hkej_hi_news_tab_2014" class="hkej_onewsCat_2014_on"><img src="<?=Yii::$app->params['staticUrl']?>css/ui/sectiontitle_20.png" class="hkej_landing_title_cat_img" alt="熱門新聞" title="熱門新聞"/></li>

<ul class="hkej_sc-top_news_right_container_2014">
 <?php 
foreach ($articles as $a) {
$section = Section::findById($a->firstSection);

$articleUrl='/property/'.$section->nav.'/article/'.$a->id.'/'.urlencode( $a->subjectline);
?>
      <li  class="hkej_sc-top_news_right_container_2014">
        <p class="top_news_right_detail"><a href="<?=$articleUrl?>"><?=$a->subjectline?></a></p>
        <p class="silder_editor_choice_author"><a href="/instantnews/<?=$section->nav?>" class="silder_editor_choice_author_inside_2"><?=$section->sectionLabel?></a>  ｜  <?=Ejhelper::short_relative_date(strtotime($a->publishDate))?></p>
      </li>
<?php } ?>

</ul>
</div>   <!--Most popular end-->    
