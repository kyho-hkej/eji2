<?php
use yii\helpers\EjiHelper;
use app\models\Author;
use app\components\MostPopularWidget;

$this->title='EJINSIGHT - ejinsight.com';

?>
          <section id="content" class="home" >
                    <!-- row start --> 
			   <div class="row desktop_display">
			   <div class="w1200 topmenu">
			   <?php                             
                            $aryNav=Yii::$app->params['top_nav'];
                            foreach($aryNav as $k=>$v){?>
                            		 <h4><a href="/eji/category/<?=$k?>"><?=$v?></a></h4>
                            <?php }
                ?>				 
				</div>
			    </div>
               
               
                    <div class="row">
 
                        
							 <div class="w1200">	
							  
						
                                 
            <div class="left_col feature_window" >
                                <?php //print_r($slider_widget); ?> 
					  <!-- Swiper -->
					  <div class="swiper-container" >
						<div class="swiper-wrapper">
							<?php foreach ($slider_widget as $sa) {?>                          
                            <div class="swiper-slide">
							 <div class="text2">
							<a href="<?=EjiHelper::getArticleUrlV2($sa)?>"> 
                                <img src="<?=$sa->imgUrl();?>" alt="<?=$sa->subjectline;?>" /> 
                            <div class="title">
                                <h2><?=$sa->subjectline?></h2>
							</div>
                            </a> 	
							</div> 
							</div>
                           <?php }?> 
					       
							
						</div>
						
						 <!-- Add Navigation -->
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
						
						  
						<!-- Add Pagination -->
						<div class="swiper-pagination"></div>
					  </div> <!-- Swiper END -->
						
						
		        </div><!--end left_col feature_window-->
								 
							 
						<div class="right_col">
                                   
									   <!--sidebar_member-->                              
                              <!--<div class="sidebar_member" style="display: none">
                                  <h3>成為《信健康》會員</h3>
                                  <label for="mce-EMAIL">最新資訊</label>
                                  <div class="inputemail"><input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required=""></div>
                                <input type="submit" value="成為會員" name="成為會員" id="mc-embedded-subscribe" class="btn_member">

                                </div>--><!--End sidebar_member-->

                <div class="fbbox" style="display: block;">

                <div class="fb-page" data-href="https://www.facebook.com/ejinsight" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/ejinsight" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ejinsight">EJINSIGHT</a></blockquote></div>
                                      
                <div id="fb-root"></div>
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v4.0"></script>
               </div>

                <div class="sidebar_member">
                <center><a href="/ejiv2/category/startups"><img src="<?php echo Yii::$app->params['staticUrl'];?>rh_banner/startups_338x80.png"></a></center>
                </div>
                            
                <div class="r_lrec"><?php include(dirname(__FILE__).'/../banner/ad_LargeRec1_setting.php'); ?></div>            

						</div>
                                
                   
            </div><!-- w1200 end-->
          </div><!-- row end --> 
                    
           
          <?php include(dirname(__FILE__).'/../banner/ad_MobLargeRec1_setting.php'); ?>
                    
                    <!-- row start --> 
          <div class="w1200" >
              <div class="left_col" >
                             
						<?php   
						echo $this->render('home_left_widgets',array('label'=>'BUSINESS','link'=>'category/business','widget'=>$widget1));
						echo $this->render('home_left_widgets',array('label'=>'STARTUPS','link'=>'category/startups','widget'=>$widget2));
						echo $this->render('home_left_widgets',array('label'=>'HONG KONG','link'=>'category/hongkong','widget'=>$widget3));
						echo $this->render('home_left_widgets',array('label'=>'WORLD','link'=>'category/world','widget'=>$widget4));
						echo $this->render('home_left_widgets',array('label'=>'LIVING','link'=>'category/living','widget'=>$widget5));
						?>   
                
                        </div><!-- left_col end -->  
                        
                        
                        
                        
						  <div class="right_col">
                               
                              
                              <!--sidebar_member-->                              
                              <!--<div class="sidebar_member" style="display: block">
                                  <h3>成為《信健康》會員</h3>
                                  <label for="mce-EMAIL">最新資訊</label>
                                  <div class="inputemail"><input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required=""></div>
                                <input type="submit" value="成為會員" name="成為會員" id="mc-embedded-subscribe" class="btn_member">

                                </div>--><!--End sidebar_member-->
                              
                               <div class="fbbox" style="display:none">
                                

                                      <div class="fb-page" data-href="https://www.facebook.com/ejinsight" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/ejinsight" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ejinsight">EJINSIGHT</a></blockquote></div>
                                      
                                    <div id="fb-root"></div>
                                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v4.0"></script>
							 </div>
                              
                              
						        <div class="r_lrec"></div>
                              
                            <?php //echo $this->render('mostpopular_widget');?>  
                            <?php echo \app\components\MostPopularWidget::widget() ?>
                           
 
                              
                            <div class="r_lrec"></div>
                              
                            <?php echo $this->render('columnists_rhb_widget');?>  
                              
                            <?php //echo $this->render('columnists_widget');?>
                              
              </div>  <!-- right_col end -->  
			   		</div>
                    <!-- row end --> 

</section>
<script type="text/javascript">
 
    
                                 $(document).on('ready', function() {
									 
                                    $(".videolist").slick({
                                    autoplay: false,
									arrows: false,
                                    dots: true,
                                    infinite: false,
                                    slidesToShow: 4,
                                    slidesToScroll: 4,
                                      responsive: [
                                        {
                                          breakpoint: 640,
                                          settings: {
                                            slidesToShow: 2.5,
                                            slidesToScroll: 2,
                                            infinite: false,
                                            dots: true
                                          }
                                        }
                                      ] 
                                  }); 
                                                                    
                                      $(".imagelist").slick({
                                    autoplay: false,
									arrows: false,
                                    dots: true,
                                    infinite: false,
                                    slidesToShow: 4,
                                    slidesToScroll: 4,
                                      responsive: [
                                        {
                                          breakpoint: 640,
                                          settings: {
                                            slidesToShow: 2.5,
                                            slidesToScroll: 2,
                                            infinite: false,
                                            dots: true
                                          }
                                        }
                                      ] 
                                  }); 
									 
									 
                                     
                                });
                                  
                                  
     
                                  
                                  
 </script>