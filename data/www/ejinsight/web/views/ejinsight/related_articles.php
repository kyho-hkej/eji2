<?php 
use app\models\Article;
if($relatedArticles) {?>
<div class="section_list">
<h2>Related article</h2>
<ul class="related">
<?php 
foreach ($relatedArticles as $r) { 
	
	$section = $r->getSection();

	if ($section->nav=='blog') {
		$sectionLabel='blog';
	} else {
		$sectionLabel=$section->sectionLabel;
	}
	
	//$articleUrl=Yii::$app->params['hostUrl'].'/lj/'.$section->sectionCode.'/article/id/'. $r->id.'/'.urlencode($r->subjectline);
	//$articleUrl=Yii::$app->params['hostUrl'].'/ejinsight/article/id/'. $r->id.'/'.urlencode(str_replace('/', ' ', $r->subjectline));
	$articleUrl=Article::formatURL($r->subjectline,$r->id);
	$sectionUrl=Yii::$app->params['hostUrl'].'/ejinsight/'.$section->sectionCode;

	//$sectionLabel='label';

		if($r->firstPhoto != ''){
			$imgUrl=$r->imgUrl($size=940);
		}else{
			$imgUrl=Yii::$app->params['ejistaticUrl'].'/web/images/generic_image_620.jpg';
		}

?>
	<li>
	<div class="pic"><a href="<?=$articleUrl?>"><img src="<?=$imgUrl?>" alt=""/></a></div>
	<div class="cat"><a href="<?=$sectionUrl?>"><?=$sectionLabel?></a></div>
	<div class="title"><a href="<?=$articleUrl?>"><?=$r->subjectline?></a></div>
	</li>
	<li>
<?php 
	}
?>
</ul>                     
</div>
<?php }?>