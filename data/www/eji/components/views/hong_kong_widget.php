 <?php 
 use yii\helpers\EjiHelper; 
 use app\models\Author;
 ?>
 <div class="featured-category">
 <h3><span class="line-title"></span><span class="widget-title"><div class="image-featured-category-title"><a href="/eji/category/hongkong">Hong Kong</a></div></span></h3>
 <?php foreach ($articles as $a) { 
 if ($a->authorId != 0) {
	$author = Author::findOne($a->authorId);
	if (isset($author)) {
		$authorName = html_entity_decode($author->authorName);
	} else {
        $authorName = '';
    }
 } else {
	$authorName = '';
 }

 ?>                               
	<ul class="mosaic" id="mosaic">
		<li>
			<div class="mosaic-posts-image">
							<a href="<?=EjiHelper::getArticleUrlV2($a)?>" title="<?=$a->storySlug?>">
				<img width="338" height="172" src="<?=$a->imgUrl($size=300);?>" class="attachment-medium-thumb wp-post-image" alt="<?=$a->storySlug?>">				</a>
								<div class="mosaic-text">
					<div class="mosaic-title">
						<h2>
						<a href="<?=EjiHelper::getArticleUrlV2($a)?>" class="big-featured-posts-title"><?=$a->subjectline?>
						 <a href="/eji/author/id/<?php echo $a->authorId?>"><span> <?=$authorName?> </span>	</a>
						</a>
						</h2>
                        <div class="mosaic-excerpt">
							<?=EjiHelper::recap($a->content, $len=200)?></div>
					</div><!--mosaic-title-->
				</div><!--mosaic-text-->
			</div><!--mosaic-posts-image-->
		</li>

	</ul>
<?php } ?>

</div>