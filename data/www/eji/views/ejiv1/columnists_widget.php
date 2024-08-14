<?php
//use yii\helpers\EjiHelper;
use app\models\Author;
?>
  
                            <div class="item_list">
                            <h2>COLUMNISTS</h2>
							
                             <ul>
                             <?php
                                $ary=Yii::$app->params['author_widget_order'];
                                foreach($ary as $k=>$v){
                                    $author = Author::findOne($k); 
                                    $authorName = html_entity_decode($author->authorName);
                                    $author_pic = $author->pic();
                             ?>   
                                  <li><div class="pic_l">
                                    
                                       <div class="pic"><a href="author?id=<?=$author->id?>"><img src="<?=$author_pic?>" alt="" /></a></div>
                                      
                                      </div>
                                    <a href="/eji/author/id=<?=$author->id?>">
                                    <h4><?=$authorName?></h4>
                                    <div class="doctor"></div>
                                    </a>
                                 </li>
                            <?php } ?>
                            </ul>
                            </div>