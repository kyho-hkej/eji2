<style>
.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color: #2bb78c;
    border-color: #2bb78c;
}
.pagination > li > a, .pagination > li > span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #2bb78c;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
}
</style>

<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\EjiHelper;
use app\models\Author;
//pagination 
use app\assets\AppAsset;
AppAsset::register($this);

$author = Author::findOne($id);
$authorName = html_entity_decode($author->authorName).' | ';

$this->title = $authorName. ' EJINSIGHT - ejinsight.com ';
?>


<section id="content" class="innerpage" >
<!-- column_left start --> 
<div class="column_left" >
<div class="list_box listingpage">

<div class="btn_set"><a href="javascript:history.back()"> &lt; Back</a></div>	
<div class="related_article">
<img src="<?=$author->pic()?>" height="96" width="96">
<h3><?=html_entity_decode($author->authorName)?></h3>
<span><?=$author->intro?></span>
</div>
	
	<ul>
	<?php foreach ($articles as $a): 
		if ($a->firstPhoto == '') {
			$imgUrl = '/images/eji_backup.jpg'; 
		} else {
			$imgUrl = $a->imgUrl($size=300);
		}
	?>
	    <li class="list">

	    	<div class="pic2">
				<a href="<?=EjiHelper::getArticleUrlV2($a)?>"><img src="<?=$imgUrl?>" alt="<?=$a->subjectline?>" /></a></div>
																											
	            <a href="<?=EjiHelper::getArticleUrlV2($a)?>">
	            <h4><?=$a->subjectline?></h4>
	            <div class="doctor"><?=$this->context->formatDate($a->publishDate)?></div>
	            <!--<div class="info"><?=EjiHelper::recap($a->content, $len=200)?>...</a></div>-->
	    </li>
	<?php endforeach; ?>
	</ul>
	</div>
<!--box list_box listingpage end -->
</div>
<!-- column_left end --> 
<?php include(dirname(__FILE__).'/../banner/ad_MobLargeRec1_setting.php'); ?>	
<!-- column_right start --> 
<div class="column_right" >
<div class="right_col">
<?php include(dirname(__FILE__).'/../banner/ad_LargeRec1_setting.php'); ?>
<?php echo \app\components\MostPopularWidgetV2::widget() ?>
<?php echo $this->render('columnists_rhb_widget');?>  
<?php //echo $this->render('columnists_widget');?>
</div>
</div>

</section>
<?= LinkPager::widget(['pagination' => $pagination]) ?>