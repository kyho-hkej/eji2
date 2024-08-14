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

$this->title=EjiHelper::getSectionLabel($category). ' EJINSIGHT - ejinsight.com '; 
?>

<section id="content" class="innerpage" >
<h1 class="title"><?=EjiHelper::getSectionLabel($category)?></h1>
<!-- column_left start --> 
<div class="column_left" >
	<div class="box list_box listingpage">
	<ul>
	<?php
	//sticky article
	if ($page==1) {
		foreach ($sticky as $s): 
		if ($s->firstPhoto == '') {
			$imgUrl = '/images/eji_backup.jpg'; 
		} else {
			$imgUrl = $s->imgUrl($size=300);
		}

		if ($s->authorId != 0) {
			$author = Author::findOne($s->authorId);
			$authorName = html_entity_decode($author->authorName).' | ';
		} else {
			$authorName = '';
		}
	?>
		<li class="list">

	    	<div class="pic2">
				<a href="<?=EjiHelper::getArticleUrl($s)?>"><img src="<?=$imgUrl?>" alt="<?=$s->subjectline?>" /></a></div>													
				<a href="<?=EjiHelper::getArticleUrl($s)?>"><h4><?=$s->subjectline?></h4></a>
	            <div class="doctor"><?php if ($s->authorId != 0) { ?> <a href="/eji/author/id/<?=$author->id?>"><?=$authorName?></a><?php } ?><?=$this->context->formatDate($s->publishDate);?></div>
	            <a href="<?=EjiHelper::getArticleUrl($s)?>"><div class="info"><?=EjiHelper::recap($s->content, $len=200)?>...</div></a>
	    </li>
	<?php
		endforeach;
	}
	?>

	<?php 
	$c=1;
	foreach ($articles as $a): 
		if ($a->firstPhoto == '') {
			$imgUrl = '/images/eji_backup.jpg'; 
		} else {
			$imgUrl = $a->imgUrl($size=300);
		}

		if ($a->authorId != 0) {
			$author = Author::findOne($a->authorId);
			$authorName = html_entity_decode($author->authorName).' | ';
		} else {
			$authorName = '';
		}
	?>
	    <li class="list">

	    	<div class="pic2">
				<a href="<?=EjiHelper::getArticleUrl($a)?>"><img src="<?=$imgUrl?>" alt="<?=$a->subjectline?>" /></a></div>
																											
	            
	            <a href="<?=EjiHelper::getArticleUrl($a)?>"><h4><?=$a->subjectline?></h4></a>
	            <div class="doctor"><?php if ($a->authorId != 0) { ?> <a href="/eji/author/id/<?=$author->id?>"><?=$authorName?></a><?php } ?><?=$this->context->formatDate($a->publishDate)?></div>
	            <a href="<?=EjiHelper::getArticleUrl($a)?>"><div class="info"><?=EjiHelper::recap($a->content, $len=200)?>...</div></a>
	    </li>
	    <?php
                                if ($c==1) {
                                	//echo 'inbanner1';
                                	include(dirname(__FILE__).'/../banner/ad_MobLargeRec1_setting.php');
                                } 
        ?>

	<?php
	$c++; 
	endforeach; ?>
	</ul>
	</div>
<!--box list_box listingpage end -->
</div>
<!-- column_left end --> 
<!-- column_right start --> 
<div class="column_right" >
<div class="right_col">
<?php include(dirname(__FILE__).'/../banner/ad_LargeRec1_setting.php'); ?>
<?php echo \app\components\MostPopularWidget::widget() ?>
<?php echo $this->render('columnists_rhb_widget');?>  
<?php //echo $this->render('columnists_widget');?>
</div>
</div>
<!-- column_right end --> 

</section>
<?= LinkPager::widget(['pagination' => $pagination]) ?>