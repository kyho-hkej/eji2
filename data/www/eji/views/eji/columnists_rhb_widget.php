<?php
//use yii\helpers\EjiHelper;
use app\models\Author;
?>
  
                            <div class="item_list">
                            <h3><span class="line-title"></span><span class="widget-title">COLUMNISTS</span></h3>
							
                             <ul>
                             <?php
                                $ary=Yii::$app->params['author_rhb_order'];
                                foreach($ary as $k=>$v){
                                    echo $k;
                                    $author = Author::findOne($k); 
                                    //var_dump($author);
                                    //exit;
                                    //$authorName = html_entity_decode($author->authorName);
                                    $author_pic = Yii::$app->params['staticUrl'].'rh_banner/'.$v;
                                    //echo $v;
                             ?>   

                            <a href="/eji/author/id/<?=$author->id?>"><center><img src="<?=$author_pic?>"></center></a><p>
                            <?php } ?>
                            </ul>
                            </div>