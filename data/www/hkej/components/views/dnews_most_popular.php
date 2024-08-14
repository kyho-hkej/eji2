<?php
use yii\helpers\EjHelper;
use app\models\Article;
use app\models\Author;
?>

<!-- hot_articles  -->

                   <div class="margin_area article_list related_articles">
                       <h3>今日熱門文章</h3>
                       
                       <ul>

                      <?php 
                      foreach ($articles as $a) {
                          //author
                          $author = Author::findOne($a->authorId);
                          if ($author){
                              $authorName=$author->authorName;
                              if ($a->storyProgName) {
                                  $authorName=$author->authorName.' | '.$a->storyProgName;
                              } else {
                                  $authorName=$author->authorName;
                              }
                          } else {
                              $authorName='';
                              if ($a->storyProgName) {
                                  $authorName=$a->storyProgName;
                              }
                          }


                      ?>
                         <li> 
                            <?php if ($a->firstPhoto) {?>
                              <div class="article_pic"> 
                                <span  class="pic32" >
                                    <a href="<?=Ejhelper::getMobArticleUrl($a)?>">
                                    <?php if ($a->hasVideo()) {?>
                                        <span class="article_list_playicon"></span>
                                    <?php } ?>
                                    <img src="<?=$a->imgUrl(620)?>" alt="" /></a></span></div>

                            <?php } ?>
                             <div class="article_text">
                                 <h4><a href="<?=Ejhelper::getMobArticleUrl($a)?>"><?=$a->subjectline?><?=$a->subhead?></a></h4>
                                <div class="info"><?=$authorName?></div>
                            </div>
                        </li>
                      <?php } ?>

                       </ul>
                       
                      
                       
                   </div>
                   <!-- hot_articles end -->