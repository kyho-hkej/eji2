<?php
use yii\helpers\EjiHelper;
use app\models\Author;
?>

                            <div class="item_list">
                            <h3>
                                <span class="line-title"></span>
                                <span class="widget-title">Most Popular 24 Hrs</span>
							</h3>
                             <ul>
                             <?php 

                             foreach ($articles as $a) {
                             	# code...
                             	$author = Author::findOne($a->authorId); 
                             	if ($author){
                                	$authorName = html_entity_decode($author->authorName);
                                	$au_url = 'author?id='.$author->id;
                                } else {
                                	$authorName = '';
                                	$au_url = '';
                                }
                             ?>
                                  <li><div class="pic_l">
                                  <div class="pic">
                                     <a href="<?=EjiHelper::getArticleUrlV2($a)?>"><img src="<?=$a->imgUrl($size=300);?>" alt="<?=$a->subjectline;?>"/></a>
                                      
                                      </div>
                                  </div>
                                    
                                    <a href="<?=EjiHelper::getArticleUrlV2($a)?>"><h4><?=$a->subjectline?></h4></a>
                                    <!--<div class="doctor"><a href="<?=$au_url?>"><?=$authorName?></a></div>-->
                                    
                                 </li>
                             <?php }?>
                            </ul>
                            </div>