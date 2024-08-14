<?php 
if($articleTags){
	if (strpos($articleTags, ',') !== false) {
		$hashtag=explode(",", $articleTags);
	} else {
		$hashtag=explode(" ", $articleTags);
	}
?>
<div class="tags">
                      <div class="tags_inner">
                        
                        <ul>
                        
                        <?php for ($i=0;$i<count($hashtag);$i++){
                        //foreach($articleTags as $t){
							?>
                        	<li><a href="/ejinsight/search?q=<?=urlencode($hashtag[$i])?>"><?=$hashtag[$i]?></a></li>	
						<?php }?>                            
                        </ul>
                    </div>
</div>
<?php }?>  
<?php 
if($seoTags){
	if (strpos($seoTags, ',') !== false) {
		$hashtag=explode(",", $seoTags);
	} else {
		$hashtag=explode(" ", $seoTags);
	}
?>
<div class="tags">
                      <div class="tags_inner">
                        
                        <ul>
                        
                        <?php for ($i=0;$i<count($hashtag);$i++){
                        //foreach($articleTags as $t){
							?>
                        	<li><a href="/ejinsight/search?q=<?=urlencode($hashtag[$i])?>"><?=$hashtag[$i]?></a></li>	
						<?php }?>                            
                        </ul>
                    </div>
</div>
<?php }?>  

