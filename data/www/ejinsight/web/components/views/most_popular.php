<?php 
use app\models\Article;
$staticUrl = Yii::$app->params['ljstaticUrl'].'/web/';
?>
<div class="section_list hotlist" >
	<div class="sticklist">
    	<h2>POPULAR</h2>
        <div class="popu blog">
        <?php
			$i=0;
			foreach($articles as $article){
				//$article->initPhotos();
				//$p=$article->images[0];	
				$section=$article->getSection();
				$sectionUrl='/lj/'.$section->sectionCode;
				//$articleUrl='/home/article/id/'. $article->id;
				//$articleUrl=$this->articleUrl($article);
				$articleUrl=$article->getArticleUrl($article);
				$imgUrl='';
			    if($article->firstPhoto != ''){
			    	$imgUrl=$article->imgUrl($size=620);
			    }else{
			    	$imgUrl=$staticUrl.'images/generic_image_620.jpg';
			    }  
			?>                
                    <div class="item">
                    	<div class="pic"><a href="<?=$articleUrl?>">
                    	<?php if ($article->hasVideo()==true) {?>
                    	<span class="playicon"></span>
                    	<?php }?>
                    	<img src="<?=$imgUrl;?>" alt=""/></a></div>
                        <div class="cat"><a href="<?=$sectionUrl?>"><?=$section->sectionLabel?></a></div>
                        <div class="title"><a href="<?=$articleUrl?>"><?=$article->subjectline?></a></div>
                    </div> 
				<?php
				$i++;
				if($i==4)
					break;
			}
			?>                         
		</div>
	</div>  
</div>
<!--Most popular end-->