<!doctype html>
<html>
<head>
		<title>EJ INSIGHT - ejinsight.com</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="Pragma" content="no-cache" />
        <link rel="stylesheet" type="text/css" href="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/css/main.css" />
        <link rel="stylesheet" type="text/css" href="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/gallery/slick-theme.css" />
        <link rel="stylesheet" type="text/css" href="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/mobile_slidemenu/slidebars.css">
        <link rel="stylesheet" type="text/css" href="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/css/style2.css" />
        
       	<script src="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/js/jquery.min.js"></script>
        <script src="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/js/sticky-kit.js"></script>
        <script src="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/js/stickyhere.js"></script>

        <script>
           $(function() {
               
               $(".topmenu").stick_in_parent({
             parent: "#wrapper"
             }); 

            $(".mobile_menu").stick_in_parent({
             parent: "#wrapper"
             }); 

            
              
    
               
            });
	
            
          function resize() {
            if ($(window).width() > 970) {
            $('body').removeClass('mobileview');
            $('body').addClass('desktopview');
             
            $(".sticklist").stick_in_parent({
             parent: ".row1", 
             offset_top: 65
             });   
                
                
            }
                else {
             $('body').addClass('mobileview');
             $('body').removeClass('desktopview');
             $(".sticklist").trigger("sticky_kit:detach")
                }
          }

     
    
    $(document).ready( function() {
     $(window).resize(resize);
     resize();
      });
            
            
     
            $(window).scroll(function() {

            if ($(window).scrollTop() > 0) {
                $('.mobile_menu2').addClass('sticky');
            } else {
                $('.mobile_menu2').removeClass('sticky');
            }
        });

            

                  
            $(document).ready( function() {
                  
                               
                $("#wrapper .feature_window").css( "opacity", 0 );
                $("#wrapper .feature_window").delay(1500).fadeTo( "slow", 1 );
                  
              
            });
            
            
        </script>
    <!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/lightbox/lity.js"></script>
	<link rel="stylesheet" type="text/css" href="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/lightbox/lity.css" media="screen" />

     <link rel="stylesheet" type="text/css" href="//<?=$_SERVER['SERVER_NAME']?>/assets/eji/css/32.css" />
    
     <!-- eji -->
    <link href="//<?=$_SERVER['SERVER_NAME']?>/eji/img/favicon.png" rel="icon">
    <link href="//<?=$_SERVER['SERVER_NAME']?>/eji/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="//<?=$_SERVER['SERVER_NAME']?>/eji/eji.css" type="text/css" rel="stylesheet">
    
</head> 
       
<body>

             
        <div canvas="container">
		<!-- Wrapper -->
		<div id="wrapper" class="ljpage" >

        <?php 

        if (Yii::$app->controller->action->id=='index') {
            print("<div class='home' >");
        } else if (Yii::$app->controller->action->id=='article') {
            print("<div class='section article' >");
        } else {
            print("<div class='section' >");
        }

        ?>
       
        
        <header class="main_width width1200">
        	<div class="topnav animate__animated animate__fadeInDown ">
                <div class="hkej_link"><a href="https://www.hkej.com" target="_blank"><img src="//<?=$_SERVER['SERVER_NAME']?>/eji/img/hkej.png" alt="HKEJ" />
                   
                    </a></div>
              
          </div>  
                 
                 <div class="topinfo animate__animated animate__fadeInDown">
                 <div class="social_media_icon">
                     <span class="fb"><a href="http://www.facebook.com/ejinsight" target="_blank"></a></span>
                     <span class="ig"><a href="https://www.instagram.com/hkejinsight" target="_blank"></a></span>
                    
                     
                      <div class="minisite_logo logo1"><a href="#"><img src="//<?=$_SERVER['SERVER_NAME']?>/images/minisite_logo.jpg" alt="" /></a></div>
                      <div class="minisite_logo"><a href="#"><img src="//<?=$_SERVER['SERVER_NAME']?>/images/minisite_logo.jpg" alt="" /></a></div>
                   </div>

                
                 <div class="info_right">
                     <div class="eshop_icon">
                         
                <span class="search"><a  href="#inlinesearch" data-lity><img src="//<?=$_SERVER['SERVER_NAME']?>/images/searchicon.jpg" alt="" /></a></span>
                         
                         
                         
                <div id="inlinesearch" class="lity-hide searchbox">
                <input type="text" name="search" 
onfocus="if(this.value==this.defaultValue)this.value=''"    
onblur="if(this.value=='')this.value=this.defaultValue" 
value="SEARCH"  /><input class="btn" type="submit" value="" />
                <h3>HOT SEARCH</h3>
                     
                      <div class="tags">
                        <ul><li><a href="#">#crystal</a></li>
                            <li><a href="#">#jewelrydesign</a></li>     
                            <li><a href="#">#happythanksgiving</a></li>
                            <li><a href="#">#luxury</a></li>     
                            <li><a href="#">#original</a></li> 
                            
                        </ul>
                    </div>
                    
                </div>
                
                         
                        </div>
                     
                     
                 
                 <div class="menu_list">
                    <ul> 
                    <?php foreach (Yii::$app->params['top_right_nav'] as $k=>$v) { ?>
                        <li><a href="<?='/'.Yii::$app->params['dir_path'].'/'.$k?>"><?=$v?></a></li>
                    <?php } ?>
                    </ul>
                 </div>
                </div>     
                  
             <div class="ejilogo"><a href="<?='/'.Yii::$app->params['dir_path']?>"><img src="//<?=$_SERVER['SERVER_NAME']?>/eji/img/eji_logo.png" alt="" /></a></div>   
   
                 
             
        </div>
        </header>

<?php
echo $this->render('nav_menu');
?>

<?php
echo $content;
?>

         <!-- Footer -->     
          <div id="footer" class="animate__animated animate__fadeIn animate__delay-1s" >
            <div class="info width1200 ">
                <div class="totop"><a href="#">BACK TO TOP</a></div>
                
                 <div class="footerlogo"><a href="#"><img src="//<?=$_SERVER['SERVER_NAME']?>/eji/img/hkeji_logo.png" alt=""/></a></div>
                <div class="footerlist">
                    
                  <a href="about_us.html" >About us</a>
                    |
                    <a href="contact_us.html">Contact us</a>
                    |
                    <a href="https://www.hkej.com/ad/html/eji_rate.html" target="_blank">Advertise</a>
                    |
                    <a href="https://www2.hkej.com/info/privacy" target="_blank">Privacy Policy</a>
                    |
                    <a href="https://www2.hkej.com/info/disclaimer" target="_blank">Disclaimer</a>
                    |
                    <a href="https://www.hkej.com/" target="_blank">HKEJ</a>

              </div>
           <p>信報財經新聞有限公司版權所有，不得轉載。<br>
Copyright © <?= date('Y') ?> Hong Kong Economic Journal Company Limited. All rights reserved.</p>
                </div>
              
              
                <div class="footer_links">
                 <div class="social_media_icon  width1200">   
                     <span class="fb"><a href="https://www.facebook.com/ejinsight" target="_blank"></a></span>
                     <span class="ig"><a href="https://www.instagram.com/hkejinsight" target="_blank"></a></span>
                   
                     
                   </div>
                    </div>
             
          <!-- Footer end--> 
          </div>

		</div>
		<!-- Wrapper-end -->
        </div>
		</div>

<?php
echo $this->render('mobile_menu');
?>

<!-- eji js  --> 
<script src="//<?=$_SERVER['SERVER_NAME']?>/eji/aos/aos.js"></script>
<script>
 AOS.init({
  duration: 1200,
  once: true,
})
</script>
<script src="//<?=$_SERVER['SERVER_NAME']?>/eji/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
 <!-- wow js  -->
<script src="//<?=$_SERVER['SERVER_NAME']?>/eji/js/wow.min.js"></script>

</body>
</html>
