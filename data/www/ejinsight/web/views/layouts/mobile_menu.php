<?php $dir_path='/'.Yii::$app->params['dir_path'].'/';?>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- css3-mediaqueries.js for IE less than 9 -->
	<!--[if lt IE 9]>
	    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"> </script>
	<![endif]-->
    
    
<!-- mobile-menu -->
 <div class="sliding-menu" off-canvas="slidebar-1 left reveal">
        <div class="topnav">  
       <div class="social_media_icon">
           <span class="exit left-exit js-close-left-slidebar">&#215</span>
           <p>Follow us on</p>
                     <span class="fb"><a href="https://www.facebook.com/ejinsight" target="_blank"><img src="//<?=$_SERVER['SERVER_NAME']?>/eji/img/social_media01.png" alt=""/></a></span>
                     <span class="ig"><a href="https://www.instagram.com/hkejinsight" target="_blank"><img src="//<?=$_SERVER['SERVER_NAME']?>/eji/img/social_media02.png" alt=""/></a></span>
                    
                     
                     <span class="minisite_logo"></span>
                   </div>
     </div>
     
     <div class="minisite_logo"><img src="https://tpc.googlesyndication.com/simgad/676481708881612381" class="img_ad" width="180" border="0" height="118"></div>
     
     
         
      <div id="navbar2" class="navbar navbar-mobile">
        <ul class="align-items-center justify-content-between">
          <li class="logo"><a href="#" title="Home"><img src="//<?=$_SERVER['SERVER_NAME']?>/eji/img/eji_icon.png" alt="" /></a></li>
          
          
          <?php
          foreach (Yii::$app->params['mainmenu_nav'] as $m) {
                if($m['show']==1) {


                        print " 
                        <li class='dropdown'>
                        <a class='nav-link' href='{$dir_path}{$m['id']}'><span>{$m['label']}</span></a>
                        ";
                   
                        if(!empty($m['sub_nav'])) {
                            print "<a class='dropdown_icon' ><i class='bi bi-chevron-down'></i></a>";
                            print "<ul>";
                            foreach ($m['sub_nav'] as $nav=>$label) {
                                print "
                                <li><a href='{$dir_path}{$nav}'>{$label}</a></li>

                                ";
                            }
                            print "</ul>";
                        }
                        
                        print "</li>";


                    }
                }
          
          ?>

          <li class="search"><a href="#inlinesearch" data-lity ><img src="//<?=$_SERVER['SERVER_NAME']?>/images/searchicon.jpg" alt="" /></a></li>	
            
        </ul>
      </div>
      <!-- .navbar -->
     
     
     <div class="menulist">
      <ul>        

        <?php foreach (Yii::$app->params['top_right_nav'] as $k=>$v) { ?>
                <li class="subitem"><a href="<?=$dir_path.$k?>"><?=$v?></a></li>
        <?php } ?>          
                <li class="subitem"><a href="<?=$dir_path.'experts'?>" title="EXPERTS">EXPERTS</a></li>    

            <!--<li class="subitem itemline"><a href="features_all.html" title="Features">Features</a></li>	
            <li class="subitem" class="subitem"><a href="#" title="Video" >Video</a></li>	      
            <li class="subitem"><a href="columnist_all.html" title="COLUMNISTS">COLUMNISTS</a></li>
          <li class="subitem"><a href="#" target="_blank" title="Shop">Shop</a></li>
          <li class="subitem"><a href="experts_all.html" title="EXPERTS">EXPERTS</a></li>-->
           <li class="ejlink"><a href="http://www.hkej.com" target="_blank" title="信報 hkej.com"><img src="//<?=$_SERVER['SERVER_NAME']?>/eji/img/hkej.png" alt="HKEJ" /></a></li>
            
         </ul>
         
              
     
         
         </div>
   
</div> <!-- mobile-menu -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>    
    
<script src="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/mobile_slidemenu/slidebars.js"></script>
<script src="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/mobile_slidemenu/scripts.js"></script>
<!-- mobile-menu-end -->
