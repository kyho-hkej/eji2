<?php 
use yii\helpers\EjiHelper;
use app\models\Author;
?>

<div class="h_info" >
<h2><a href="/eji/<?=$link?>"><?=$label?></a></h2>
<ul>
<?php 
$cnt=1;
foreach ($widget as $w) {
if ($w->firstPhoto) {
	$img=$w->imgUrl($size=300);
} else {
	$img='/images/eji_backup.jpg';
}

if ($w->authorId != 0) {
	$author = Author::findOne($w->authorId);
	$authorName = html_entity_decode($author->authorName).' | ';
} else {
	$authorName = '';
}

if ($cnt==1) {?>
<li class="new">
<a href="<?=EjiHelper::getArticleUrl($w)?>">
<div class="pic videocover"><img src="<?=$img?>" alt="<?=$w->subjectline?>"/></div>                                 
<span class="title"><?=$w->subjectline?></span></a>
<span class="doctor"><a href="/eji/author/id/<?php echo $w->authorId?>"><?=$authorName?></a><?=$this->context->formatDate($w->publishDate)?></span>
<span class="dec"></span>

</li>
<?php } else if ($cnt<5) {?>
<li>
<div class="list_r">
<div class="l_img">
<span class="pic videocover">
<a href="<?=EjiHelper::getArticleUrl($w)?>">
<img src="<?=$img?>" alt="<?=$w->subjectline?>"></span></div>
<h4><?=$w->subjectline?></h4></a>
<span class="doctor"><a href="/eji/author/id/<?php echo $w->authorId?>"><?=$authorName?></a><?=$this->context->formatDate($w->publishDate)?></span>

</div>
</li>
<?php
	} 
	$cnt++;
}?>
</ul>
</div><!-- h_info end -->
