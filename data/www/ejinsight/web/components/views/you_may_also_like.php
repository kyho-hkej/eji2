<?php 

use yii\helpers\LjHelper;
use app\models\Article;
use app\models\Author;

$staticUrl = Yii::$app->params['staticUrl'].'/web/';

?>
<div class="section_list">
<h2>you may also like</h2>
                  
                   <ul class="whatsnew youlike">
                   
                   <?php
					$i=1;
					foreach($articles as $article){
					if ($article->id !=$articleId){ //if matched current article, skip it 
					if ($i<=6) {

					        $section = $article->getSection();
					    	if ($section->nav=='travelliving') {
					    		$sectionNav='travelsports';
					    	} else if  ($section->nav=='mobileluxury') {
					    		$sectionNav='designmachines';
					    	} else {
					    		$sectionNav=$section->nav;
					    	}
					    	//$articleUrl = '/lj/'.$sectionNav.'/article/id/'. $article->id.'/'. urlencode(str_replace('%', ' ', $article->subjectline));
					    	$articleUrl = Article::formatURL($article->subjectline,$article->id);

					        $section = $article->getSection();
					    	if ($section->nav=='blog') {
					    		$sectionUrl = '/ejinsight/blog/list/cate/'.$section->sectionCode;
					    	} else {
					    		if ($section->nav=='travelliving') {
					    			$sectionNav='travelsports';
					    		} else if  ($section->nav=='mobileluxury') {
					    			$sectionNav='designmachines';
					    		} else {
					    			$sectionNav=$section->nav;
					    		}
					    		$sectionUrl = '/ejinsight/'.$sectionNav;
					    	}

					        $section = $article->getSection();
					    	$sectionLabel = $section->sectionLabel;

							$imgUrl='';
							if($article->firstPhoto != ''){
						    	$imgUrl=$article->imgUrl($size=620);
						    }else{
						    	$imgUrl=$staticUrl.'images/generic_image_620.jpg';
						    } 
						
						?>    
                                <li>
                                <div class="pic"><a href="<?=$articleUrl?>">
                                <?php if ($article->hasVideo()==true) {?>
	                    		<span class="playicon"></span>
	                    		<?php }?>
                                <img src="<?=$imgUrl?>" alt=""/></a></div>
                                <div class="cat"><a href="<?=$sectionUrl?>"><?=$sectionLabel?></a></div>
                                <div class="title"><a href="<?=$articleUrl?>"><?=$article->subjectline?></a></div>
                                </li>
	                   <?php 
						}
					$i++;
					}
					}?>                             
                    </ul>
</div>