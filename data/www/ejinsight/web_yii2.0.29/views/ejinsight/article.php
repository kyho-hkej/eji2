 <?php 
use app\models\Article;
$dir_path='/'.Yii::$app->params['dir_path'].'/';
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
                      
                      
                 <h1 class="title"><?=$article->subjectline?>
                      </h1>
                     <div class="date"><span>Peter Chan</span> | <span><?=$article->publishDateLite?></span></div>
                      <div class="icons"><!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div></div>
                   
                      <div class="icons2">
                            
                          
                       <!-- ShareThis  -->
                       <div class="sharethis-inline-share-buttons"></div>
                         
                          
                      
                      </div>
                      
                      <!-- embed feature window-->
                   	<?php //echo $this->render('embed_feature_window')?>
                    
                      <!-- content_text --> 
                    <div class="content_text">
                     
                     
                       
                        
                        
                        
                        <div class="toppic"><img src="images/articleimg7.jpg" alt=""/></div>
                        
                        <?php echo $article->content?>
                        
                           <blockquote class="sidekick">
                             品牌便積極開拓國際市場品牌，繼在2015年於紐約麥迪森大道開設了美國專門店後，早前又於2016年9月在倫敦的舊邦德街開設了專門店。 <cite> Thor in Endgame</cite>
                          </blockquote>
                        
                        
                      
                    <div class="tags">
                      <div class="tags_inner">
                        <!--Slider--->
                        <ul><li><a href="#">#crystal</a></li>
                            <li><a href="#">#jewelrydesign</a></li>     
                            <li><a href="#">#happythanksgiving</a></li>
                            <li><a href="#">#luxury</a></li>     
                            <li><a href="#">#original</a></li> 
                            
                        </ul>
                    </div>
                    </div>  
                     
                        
                     
                        
                    <!-- content_text end --> 
                    </div>  
                      
                      
                  
                  <div class="section_list">
                      <h2>Related article</h2>
                   <ul class="related">
                                
                           
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
                                
                                
                                
                                
                               
                    </ul>
                    
                      
                  </div>
                      
             
                      
                        <div class="section_list">
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
                  </div>
                      
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