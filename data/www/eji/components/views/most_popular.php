<?php
use yii\helpers\EjiHelper;
use app\models\Author;
?>

                            <div class="item_list">
                            <h2>MOST POPULAR</h2>
							
                             <ul>
                             <?php 

                             foreach ($articles as $a) {
                             	# code...
                             	$author = Author::findOne($a->authorId); 
                             	if ($author){
                                	$authorName = html_entity_decode($author->authorName);
                                	$au_url = '/eji/author/id/'.$author->id;
                                } else {
                                	$authorName = '';
                                	$au_url = '';
                                }
                             ?>
                                  <li><div class="pic_l">
                                  <div class="pic">
                                     <a href="<?=EjiHelper::getArticleUrl($a)?>"><img src="<?=$a->imgUrl($size=300);?>" alt="<?=$a->subjectline;?>"/></a>
                                      
                                      </div>
                                  </div>
                                    
                                    <a href="<?=EjiHelper::getArticleUrl($a)?>"><h4><?=$a->subjectline?></h4></a>
                                    <div class="doctor"><a href="<?=$au_url?>"><?=$authorName?></a></div>
                                    
                                 </li>
                             <?php }?>
                            </ul>
                            </div>