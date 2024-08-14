 <?php 
use app\models\Article;
$dir_path='/'.Yii::$app->params['dir_path'].'/';
?>

                <!-------------- Section Start -------------->
                    
                <div class="section_banner mobile_content animate__animated animate__fadeIn ">
                    
                    <div class="bg_img">
                    <h1><a href="<?=$dir_path.$category?>"><?=$sectionLabel?></a></h1>
                    </div>
                    
                     <div class="section_content">
                        <div class="tags sub_menulist lifestyle_color">
                      <div class="tags_submenu">
                        <!--Slider--->
                        <ul>   
                        <?php foreach (Yii::$app->params['mainmenu_nav'] as $m) {
                            if ($m['id']==$category) { 
                                foreach ($m['sub_nav'] as $nav=>$label) {
                                    print "<li><a class='' href='{$dir_path}{$nav}'>{$label}</a></li>";
                                }
                            }
                         }
                        ?>
                            
                        </ul>
                    </div>
                    </div>
                    </div>
                </div>


                  <div class="width1200 animate__animated animate__fadeIn ">  
                   <!-- Content Start -->
                  <div class="section_content main_width">
                                          
                      
                  <div class="col_left ">
                  
                  
                  
                  <div class="section_list">
                
                  

                  <?php 
                                $count=1;
                                foreach ($articles as $a) {


                                $url = Article::formatURL($a->subjectline,$a->id);

                                if ($a->firstPhoto == '') {
                                    $imgUrl = '/images/eji_backup.jpg'; 
                                } else {
                                    $imgUrl = $a->imgUrl($size=620);
                                }


                                if ($count==1) {
                                    $imgUrl = $a->imgUrl();

                                
                               // '/ejinsight/article/id/'.$a->id.'/'.urlencode(Article::formatSubjectline($a->subjectline));
                      
                  ?>   
                                                <div class="new">
                                                    <div class="pic32"><a href="<?=$url?>"><img src="<?=$imgUrl?>" alt=""/></a></div>
                                                    <div class="title"><a href="<?=$url?>"><?=$a->subjectline?><?=$a->subhead?>
                                                    </a></div>
                                                    <div class="dec"><a href="<?=$url?>"><?=Article::recap($a->content, $lens=100)?>......</a></div>
                                                </div>
                                                <ul class="whatsnew latest">
                                <?php } else {?> 
                                                
                                                
                                                <li>
                                                <div class="pic">
                                                    <a href="<?=$url?>"><!--<span class="playicon"></span>--><img src="<?=$imgUrl?>" alt=""/></a>
                                                </div>
                                                <div class="title"><a href="<?=$url?>"><?=$a->subjectline?><?=$a->subhead?></a></div>
                                                </li>
                                               
                                                

                <?php 
                                    }
                                $count++;
                                } 
                ?>
                        
                        
                        
                                                </ul>
                      <div class="loadmore"><a href="#">LOAD<br>MORE</a></div>
                  </div>
                  
                  </div>
                 
                  
                  
                  <div class="col_right" >
                  		<div class="ad300"><img src="images/lrec.jpg" alt=""/></div>
                   
                      
                      
                      <div class="section_list hotlist banner_list event_list" >
                        
                        <h2>Events</h2>
                    
                      <div class="bannerpic">
                        <p><a href="#">
                            <img src="https://static.hkej.com/hkej/images/2024/03/12/3704735_916f2856855f09a972766d89b66d2dc3.png"></a></p>
                          
                        <p><a href="#">
                            <img src="https://static.hkej.com/hkej/images/2023/06/06/3476322_d17b411bfe95f38da09e8ec16a769a3e.jpg"></a></p>
                          
                        <p><a href="#">
                            <img src="	https://static.hkej.com/hkej/images/2023/08/17/3537696_681f4232ffc6e33edf30cca0952f85fe.png"></a></p>
                        
                         <p><a href="#">
                            <img src="https://static.hkej.com/hkej/images/2023/09/20/3567780_09fcffaf54a39ea992a506f86e95855e.jpg"></a></p>
                    
                        </div>
                      
                      </div>
                      
                      
                     		<div class="section_list hotlist banner_list colu_list" >
                        
                        <h2>COLUMNISTS</h2>
                                
                    <div class="bannerpic">
                        <p><a href="#">
                            <img src="https://static.hkej.com/eji/rh_banner/Michael_Chugani.png"></a></p>
                          
                        <p><a href="#">
                            <img src="https://static.hkej.com/eji/rh_banner/frankChing_338x80.png"></a></p>
                          
                        <p><a href="#">
                            <img src="https://static.hkej.com/eji/rh_banner/markonell_338x80.png"></a></p>
                        
                        <p><a href="#">
                            <img src="https://static.hkej.com/eji/rh_banner/NeilleSarony_338x80.png"></a></p>
                          
                      <p><a href="#">
                            <img src="https://static.hkej.com/eji/rh_banner/StephenVines_338x80.png"></a></p>
                        
                       <p><a href="#">
                            <img src="https://static.hkej.com/eji/rh_banner/brian_ys_wong.png"></a></p>
                          
                    
                        </div>
                            
                             <div class="btnall"><a href="#">All COLUMNISTS >></a></div>
                      
                      </div>
                    
                         
                     
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