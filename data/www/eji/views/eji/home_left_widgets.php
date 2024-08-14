<?php 
use yii\helpers\EjiHelper;
use app\models\Author;
?>

<div class="h_info" >
<h3><span class="line-title"></span><span class="widget-title"><a href="/eji/<?=$link?>"><?=$label?></a></span></h3>
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
	if (isset($author)) {
		$authorName = html_entity_decode($author->authorName).' | ';
	} else {
        $authorName = '';
    }
} else {
	$authorName = '';
}
?>

<li>
<div class="list_r">
<div class="l_img">
<span class="pic videocover">
<a href="<?=EjiHelper::getArticleUrlV2($w)?>">
<img src="<?=$img?>" alt="<?=$w->subjectline?>"></span></div>
<a href="<?=EjiHelper::getArticleUrlV2($w)?>">
<h4><?=$w->subjectline?></h4></a>
<span class="doctor"><a href="/eji/author/id/<?php echo $w->authorId?>"><?=$authorName?></a><?=$this->context->formatDate($w->publishDate)?></span>

</div>
</li>

<?php }?>
</ul>
<div class="more-link"><a href="/eji/<?=$link?>">More &gt;</a></div>
</div><!-- h_info end -->
