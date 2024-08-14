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
Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->params['ejiUrl'].EjiHelper::getArticleUrlV2($article)], 'og_url');

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


    <div class="list_box">

    <!--<div class="btn_set"><a href="javascript:history.back()"> &lt; Back</a></div>-->
	<div class="btn_set"><a href="/eji/category/<?=$nav?>"> &lt; <?=$sectionName?></a></div>

    <div class="content_text">
	<h1><?=$article->subjectline?></h1>
	<div class="date">
	<?php 
              if ($article->authorId != 0) {
                      $author = Author::findOne($article->authorId);
                      if (isset($author)) {
                      $authorName = html_entity_decode($author->authorName);
                      } else {
                      $authorName = '';
                      }
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

    <span class="post-page-date">
	<?php if (($article->authorId != 0) && isset($author)) { ?>
		<div class="bypostauthorimage"><img src="<?=$author->pic()?>" class="avatar avatar-96 photo avatar-default" height="96" width="96"></div>
    <?php } ?> 
    <div class="bypostauthor-container"> 
   	<?php if (($article->authorId != 0) && isset($author)) { ?>	
    	<span class="bypostauthor"><a href="/eji/author/id/<?=$author->id?>" title="<?=html_entity_decode($author->authorName)?>" rel="author"><?=$authorName?></a></span>
    <?php } ?> 	
    <span class="doctor"><?php echo $this->context->formatDate($article->publishDate);?></span>
	</div>
    </span>


	</div>

							<!-- sharethis plugin-->
							<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=64755bbd7cccdc001910bbfb&product=inline-share-buttons' async='async'></script>
							<!-- sharethis buttons -->
							<div class="sharethis-inline-share-buttons"></div>
            
	<?php 
		$article->content = preg_replace('/http:/i', '', $article->content);

		// no image
		if ($photocount == 0) {
			echo $article->content;
		} else { // image >= 1	
			//show first photo above content if it's not inserted in content
			if ($photocount >= 1) {
				//$firstImage=$article->imgUrl();
				if (preg_match('#'.$article->firstPhoto.'#', $article->content) ) { // to avoid an image shows twice
					 //$article->content = preg_replace('/_620.jpg/i', '.jpg', $article->content); 	
					 //$article->content = preg_replace('/_620.png/i', '.png', $article->content); 				
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
									if ($article->firstPhoto != $p->filename) {
										if (!preg_match('#'.$p->filename.'#', $article->content) ) {
									?>
									<div class="pic pictop"><img src="<?=$p->imgUrl();?>" alt="<?=$p->caption?>" title="<?=$p->caption?>" />
									</div>
							<?php 
										}
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

	if  (($article->authorId != 0) && isset($author)) {?>

		<div id="author-info">
				<div id="author-image">
				<img src="<?=$author->pic()?>" class="avatar avatar-96 photo avatar-default" height="96" width="96">
				</div><!--author-image-->
				<div id="author-desc">
					<h3>
						<a href="/eji/author/id/<?=$author->id?>" title="Posts by <?=html_entity_decode($author->authorName)?>" rel="author"><?=html_entity_decode($author->authorName)?></a>
                    </h3>
					<div class="description-author">
						<?=$author->intro?>	</div>
                    
                    <!--description-author-->
					<ul class="author-social">
				</div><!--author-desc-->
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
<?php include(dirname(__FILE__).'/../banner/ad_LargeRec2_setting.php'); ?>

<?php //echo $this->render('hk_widget');?>  
<?php echo \app\components\HongKongWidget::widget() ?>
<?php echo \app\components\MostPopularWidgetV2::widget() ?>

<?php //echo $this->render('columnists_widget');?>
</div>
</div>
              
</section>
<!-- section end -->
<!-- /79812692/HKEJ_EJInsight_ArticlePage_InRead -->
<div id='div-gpt-ad-1479691260767-0'>
		<script>
		desktopviewad('/79812692/HKEJ_EJInsight_ArticlePage_InRead',[[6, 6]], 'div-gpt-ad-1479691260767-0');
		</script>
</div>



<?php 
              if ($article->authorId != 0) {
                      $author = Author::findOne($article->authorId);
                      if (isset($author)) {
                      $authorName = html_entity_decode($author->authorName);
                      } else {
                      $authorName = '';
                      }
              } else {
                      $authorName = '';
              }



echo $this->render('ejcounter', array(
	'article'=>$article, 
	'authorName'=>html_entity_decode($authorName),
	'sectionName'=>$sectionName
	));

?>
