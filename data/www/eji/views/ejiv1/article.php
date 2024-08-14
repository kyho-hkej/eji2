<?php
use yii\helpers\Html;
use yii\helpers\EjiHelper;
use app\models\Article;
use app\models\Author;
use app\models\Photo;
use app\models\Section;

$section=Section::findOne($article->firstSection);
//print_r($section);
$sectionName=$section->sectionLabel;
$nav=$section->nav;
$article->subjectline = html_entity_decode($article->subjectline);
$this->title = $article->subjectline. ' EJINSIGHT - ejinsight.com ';

Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->title], 'og_title');
Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'article'], 'og_type');
Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->params['ejiUrl'].EjiHelper::getArticleUrl($article)], 'og_url');

if ($article->firstPhoto == '') {
	$imgUrl = '/images/eji_backup.jpg'; 
} else {
	$imgUrl = $article->imgUrl();
}

Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $imgUrl], 'og_image');
Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => '620'], 'og:image:width');
Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => '320'], 'og:image:height');
Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => 'EJINSIGHT'], 'og:site_name');
Yii::$app->view->registerMetaTag(['property' => 'fb:admins', 'content' => 'writerprogram'], 'fb:admins');
Yii::$app->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '160465764053571'], 'fb:app_id');
Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => EjiHelper::recap($article->content, $len=200)], 'og_description');

?>

<section id="content" class="innerpage" >
<!-- column_left start --> 
<div class="column_left" >


    <div class="box list_box">

    <!--<div class="btn_set"><a href="javascript:history.back()"> &lt; Back</a></div>-->
	<div class="btn_set"><a href="/eji/category/<?=$nav?>"> &lt; <?=$sectionName?></a></div>

    <div class="content_text">
	<h1><?=$article->subjectline?></h1>
	<div class="date">
	<?php 
	if ($article->authorId != 0) {
		$author = Author::findOne($article->authorId);
		$authorName = html_entity_decode($author->authorName.' | ');
	} else {
		$authorName = '';
	}
	
	$photos = Photo::find()->where(['articleId'=>$article->id])->orderBy(['photoOrder'=>SORT_ASC])->all();

	/*
	$photos = Photo::findAll([
    		'articleId' => $article->id,
    		'status' => '1',
		]

	);
	*/

	//print_r($photos);

	$photocount = count($photos);


	?>
	<span class="doctor">
	<?php if ($article->authorId != 0) { ?><a href="author?id=<?=$author->id?>"><?=$authorName?></a><?php } ?>
	<?php echo $this->context->formatDate($article->publishDate);
	?>
	</span></div>

	<!-- Go to www.addthis.com/dashboard to customize your tools --> 
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5def6bebbb474e94"></script>
	
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <div class="addthis_inline_share_toolbox"></div>
            
	<?php 
		// no image
		if ($photocount == 0) {
			echo $article->content;
		} else { // image >= 1	
			//show first photo above content if it's not inserted in content
			if ($photocount >= 1) {
				//$firstImage=$article->imgUrl();
				if (preg_match('#'.$article->firstPhoto.'#', $article->content) ) { // to avoid an image shows twice	
					echo $article->content;
				} else { //no inline photo
					//print first photo on top
					foreach ($photos as $p) {
						if (($p->publishType == '3') && ($p->status == '1')) { 
								if ($article->firstPhoto == $p->filename) {?>
								<div class="pic pictop"><img src="<?=$p->imgUrl();?>" alt="<?=$p->caption?>" title="<?=$p->caption?>" />
								</div>
						<?php 
								} 
						}
					}
					echo $article->content;
					//print rest of the photos
					foreach ($photos as $p) {
						if (($p->publishType == '3') && ($p->status == '1')) { 
								if ($article->firstPhoto != $p->filename) {?>
								<div class="pic pictop"><img src="<?=$p->imgUrl();?>" alt="<?=$p->caption?>" title="<?=$p->caption?>" />
								</div>
						<?php 
								} 
						}
					}
				}
			} 	
		}

	/*$this->params['trackEvent'] = array(
				'category'=> 'EJINSIGHT',
				'action'=> 'Article Full',
				'label'=> 'EJI:Article|DT:'.$article->publishDate.'|TID:'.$article->id.'|AN:'.$authorName.'CN:'.$article->storyProgName.'|TTL:'.$article->subjectline,
    );*/	

	if ($article->authorId != 0) {?>		
		<div class="related_article">
		<a href="author?id=<?=$author->id?>">
		<img src="<?=$author->pic()?>" height="96" width="96">
        <h3><?=html_entity_decode($author->authorName)?></a></h3>
        <span><?=$author->intro?></span>
        </div>
	<?php
	}

	?>
	</div> <!-- end content-text -->
	</div>
	<!-- box list_box end -->
</div>
<!-- column_left end --> 
<?php include(dirname(__FILE__).'/../banner/ad_MobLargeRec1_setting.php'); ?>	
<!-- column_right start --> 
<div class="column_right" >
<div class="right_col">

<?php include(dirname(__FILE__).'/../banner/ad_LargeRec1_setting.php'); ?>	

<?php echo \app\components\MostPopularWidget::widget() ?>
<?php echo $this->render('columnists_rhb_widget');?>  
<?php //echo $this->render('columnists_widget');?>
</div>
</div>
              
</section>
<!-- section end -->
<?php 
if ($article->authorId != 0) { 
	$authorName=$author->authorName;
} else {
	$authorName='';
}


echo $this->render('ejcounter', array(
	'article'=>$article, 
	'authorName'=>html_entity_decode($authorName),
	'sectionName'=>$sectionName
	));

?>