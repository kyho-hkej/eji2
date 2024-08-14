 <?php 
use app\models\Author;
use app\models\Article;
use app\models\Photo;

$dir_path='/'.Yii::$app->params['dir_path'].'/';
$photos = Photo::find()->where(['articleId'=>$article->id, 'attachmentType' => 'PHOTO', 'status'=> '1'])->orderBy(['photoOrder'=>SORT_ASC])->all();
$videos = Photo::find()->where(['articleId'=>$article->id, 'attachmentType' => 'VIDEO', 'status'=> '1'])->orderBy(['photoOrder'=>SORT_ASC])->all();

$photocount = count($photos);

$videocount = count($videos);

?>
<!-------------- Section Start -------------->
           
<div class="width1200 animate__animated animate__fadeIn animate__slow">  
                   <!-- Content Start -->
                  <div class="section_content main_width mobile_content">
                      
                    
                      
                  <div class="col_left ">
                      
                        <div class="section_link">
                           <span><a href="lifestyle.html">Lifestyle</a></span>
                            <i class="bi bi-three-dots-vertical"></i>
                            <span><a href="<?=$dir_path.$section->nav?>"><?=$section->sectionLabel?></a></span>
                    </div>
                      
                      
                 <h1 class="title"><h1><?=$article->subjectline?><?=$article->subhead?></h1>
                      </h1>
						<div class="date">
						<?php 
					        $author = Author::findOne($article->authorId);

					        if($author) {
					            $authorName = html_entity_decode($author->authorName);
					        } else {
					            $authorName = '';
					        }

					        if ($author){?><span><a href="/ejinsight/author/id/<?=$author->id?>"><?=$authorName;?></a></span> | <?php }?> <span><?=$article->publishDateLite?></span>
					    </div>
						<?php if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false)) { 
						} else {?>
						<div class="icons">
						<!-- sharethis plugin-->
						<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=64755bbd7cccdc001910bbfb&product=inline-share-buttons' async='async'></script>
						<!-- sharethis buttons -->
						<div class="sharethis-inline-share-buttons"></div>
						</div>
						<?php } ?>
                      
                      <!-- embed feature window-->
                   	<?php //echo $this->render('embed_feature_window')?>
                    
                      <!-- content_text --> 
                    <div class="content_text">

                    <?php 
                   
                    $url =  Yii::$app->params['hostUrl'].'/ejinsight/codeconvert?id='.$article->id;
                    
                    //echo $url;
                    $content = file_get_contents($url);
                    $content = str_replace("http:", "https:", $content);
                    //$content = str_replace("hkej.com", "hkej.net", $content);
                    //echo $content;

					// no image
					if ($photocount == 0) {
						echo $content;
					} else { // image >= 1	
						//show first photo above content if it's not inserted in content
						if ($photocount >= 1) {
							//$firstImage=$article->imgUrl();
							$size='620';
							$firstPhoto = str_replace('.', '_'.$size.'.', $article->firstPhoto);
							if (preg_match('#'.$firstPhoto.'#', $content) ) { // to avoid an image shows twice
								
								//echo $article->firstPhoto;
								 //$content = preg_replace('/_620.jpg/i', '.jpg', $content); 	
								 //$content = preg_replace('/_620.png/i', '.png', $content); 				
								echo $content;
							} else { //no inline photo
								//print first photo on top
								foreach ($photos as $p) {
									if (($p->publishType == '3') && ($p->status == '1')) { 
											if ($article->firstPhoto == $p->filename) {
											?>
											<div class="toppic"><img src="<?=$p->imgUrl($size=620);?>" alt="<?=$p->caption?>" title="<?=$p->caption?>" />
											</div>
									<?php 
											} 
									}
								}
								echo $content;
								//print rest of the photos
					
									foreach ($photos as $p) {
									
										if (($p->publishType == '3') && ($p->status == '1')) { 
												if ($article->firstPhoto != $p->filename) {
													if (!preg_match('#'.$p->filename.'#', $article->content) ) {
												?>
												 <p style="text-align: center;"><img src="<?=$p->imgUrl($size=620);?>" alt="<?=$p->caption?>" title="<?=$p->caption?>" />
												</p>
										<?php 
													}
												} 
										}
									}
								}

						} 	
					}


                    ?>                     

                    <?php

                    //echo $article->seoTags;
                    //print_r($article);
                   
                    if (($article->tag) || ($article->seoTags)) {
                        echo $this->render('article_tags', array('articleTags'=>$article->tag, 'seoTags'=>$article->seoTags));
                    }
                    ?>                                             

                    <!--
                    	<blockquote class="sidekick">
                             品牌便積極開拓國際市場品牌，繼在2015年於紐約麥迪森大道開設了美國專門店後，早前又於2016年9月在倫敦的舊邦德街開設了專門店。 <cite> Thor in Endgame</cite>
                        </blockquote>
                    -->
                      
                    <!-- content_text end --> 
                    </div>  
                      
                    <?php 
                    if ($relatedArticles) {
                        echo $this->render('related_articles', array('relatedArticles'=>$relatedArticles));
                    }
                    ?>
  
             
                      
                        <!--<div class="section_list">
                  <h2>you may also like</h2>
                  
                        <ul class="whatsnew youlike ">
                                <li>
                                <div class="pic"><a href="#"><img src="images/articleimg7.jpg" alt=""/></a></div>
                                <div class="cat"><a href="#">Watch & Jewelry </a></div>
                                <div class="title"><a href="#">【專訪李安】談電影：120fps令我興奮 談美國：恐懼跟暴力常常連接在一起 常連接在一起</a></div>
                                </li>
                            <li>
                                <div class="pic"><a href="#"><img src="images/articleimg1.jpg" alt=""/></a></div>
                                <div class="cat"><a href="#">Watch &amp; Jewelry </a></div>
                                <div class="title"><a href="#">每日奢艷：章子怡再與NIRAV MODI結緣 為品牌尖沙咀旗艦店揭幕</a></div>
                                </li>
                            <li>
                                <div class="pic"><a href="#"><img src="images/articleimg2.jpg" alt=""/></a></div>
                                <div class="cat"><a href="#">Watch &amp; Jewelry </a></div>
                                <div class="title"><a href="#">【專訪李安】談電影：120fps令我興奮 談美國：恐懼跟暴力常常連接在一起</a></div>
                                </li>
                                <li>
                                <div class="pic"><a href="#"><img src="images/articleimg3.jpg" alt=""/></a></div>
                                <div class="cat"><a href="#">Fashion</a></div>
                                <div class="title"><a href="#">高圓圓、劉雯等出席Chaumet 高級珠寶發佈會</a></div>
                                </li>
                                <li>
                                <div class="pic"><a href="#"><img src="images/articleimg4.jpg" alt=""/></a></div>
                                <div class="cat"><a href="#">TRAVEL &amp; LIVING </a></div>
                                <div class="title"><a href="#">新加坡豪宅新指標 The Ritz-Carlton Residences</a></div>
                                </li>
                                <li>
                                <div class="pic"><a href="#"><img src="images/articleimg5.jpg" alt=""/></a></div>
                                <div class="cat"><a href="#">
Health &amp; Beauty</a></div>
                                <div class="title"><a href="#">極致水療養生﹗</a></div>
                                </li>
                                
                               
                                
                               
                    </ul>
                  </div>-->

 <?php echo \app\components\YouMayAlsoLikeWidget::widget(['articleId'=>$article->id, 'cur_section'=>$section->nav]);?> 
                     
                  <!-- col_left end -->
                  </div>
                 
                      
                  <div class="col_right" >
                  			<div class="ad300"><img src="eji/img/LREC.gif" alt=""/></div>
                   
                      
            
                        
                         
                     
                      <div class="section_list hotlist" >
                     <div class="sticklist">
                       <h2>POPULAR</h2>
                         <div class="popu blog">
                        
                    <div class="item">
                    	<div class="pic"><a href="#"><img src="images/articleimg7.jpg" alt=""/></a></div>
                        <div class="cat"><a href="#">TRAVEL &amp; LIVING</a></div>
                        <div class="title"><a href="#">【專訪李安】談電影：120fps令我興奮 談美國：恐懼跟暴力常常連接在一起 常連接在一起</a></div>
                    </div> 
                     <div class="item">
                    	<div class="pic"><a href="#"><span class="playicon"></span><img src="images/articleimg1.jpg" alt=""/></a></div>
                        <div class="cat"><a href="#">FASHION</a></div>
                        <div class="title"><a href="#">巴黎打開404 走進巨盒裝置藝術內的旗艦店</a></div>
                    </div> 
                    <div class="item">
                    	<div class="pic"><a href="#"><img src="images/articleimg5.jpg" alt=""/></a></div>
                        <div class="cat"><a href="#">FOOD &amp; WINE</a></div>
                        <div class="title"><a href="#">巴黎打開404 走進巨盒裝置藝術內的旗艦店</a></div>
                    </div> 
                      <div class="item">
                    	<div class="pic"><a href="#"><img src="images/articleimg2.jpg" alt=""/></a></div>
                        <div class="cat"><a href="#">FOOD &amp; WINE</a></div>
                        <div class="title"><a href="#">巴黎打開404 走進巨盒裝置藝術內的旗艦店</a></div>
                    </div> 
                               
                    </div>
                    </div>  
                   </div>
                        
                        
                            
  
                  
                   </div>
                  
                  
                  
                  </div>
                   <!-- row1 End -->
</div>
<!-------------- Section End -------------->                 