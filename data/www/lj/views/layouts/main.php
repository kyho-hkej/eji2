<?php
use yii\helpers\Html;
$staticUrl = Yii::$app->params['ljstaticUrl'].'/web/';
$ejstaticUrl = Yii::$app->params['ejstaticUrl'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=8, IE=9, IE=10, IE=edge" />

<title><?= Html::encode($this->title) ?></title>

<?PHP
  $this->head();
?>

<link href="<?=$staticUrl?>css/main.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticUrl?>css/slick-theme.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticUrl?>css/slidebars.css" rel="stylesheet" type="text/css" >
<link href="<?=$staticUrl?>css/style2.css" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  
<script src="<?=$staticUrl?>js/jquery.min.js"></script>  
<script src="<?=$staticUrl?>js/sticky-kit.js"></script>
<script src="<?=$staticUrl?>js/stickyhere.js"></script>

<?php 
    if (strpos(Yii::$app->controller->action->id, 'blog') !== false 
      /*|| $this->article->section->nav=='blog'*/) { // for blog, blogger, blogger profile, blog articletemplate

?>
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
            if ($(window).width() > 960) {
            $('body').removeClass('mobileview');
            $('body').addClass('desktopview');
             
            $(".sticklist").stick_in_parent({
             parent: ".section_content", 
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
            
        </script>
<?php } else {?>
<script>
      $(function() {
          
          $(".mobile_menu").stick_in_parent({
           parent: "#wrapper"
           }); 
      
          });
        
           $(function() {
               
               $(".topmenu").stick_in_parent({
             parent: "#wrapper"
             }); 
  
    
               
            });
  
            
          function resize() {
            if ($(window).width() > 799) {
            $('body').removeClass('mobileview');
             
            $(".sticklist").stick_in_parent({
             parent: ".section_content", 
             offset_top: 65
             });   
                
                
  }
     else {
         $('body').addClass('mobileview');
         $(".sticklist").trigger("sticky_kit:detach")
     }
    }

     
    
    $(document).ready( function() {
     $(window).resize(resize);
     resize();
      });
            
</script>
<?php }?>
<link href="<?=$staticUrl?>css/ad_style.css" rel="stylesheet" type="text/css" media="screen">     
<script type="text/javascript" src="<?=$staticUrl?>js/skinner.js"></script>
<script type="text/javascript" src="<?=$staticUrl?>js/lightbox.js"></script>
<script type="text/javascript" src="<?=$staticUrl?>js/fullpagead.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?=$staticUrl?>js/lity.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$staticUrl?>css/lity.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=$staticUrl?>css/lity2.css" media="screen" />
<link href="<?=$staticUrl?>css/32.css" rel="stylesheet" type="text/css" />
<!-- DFP header files -->
<!-- Async AD   -->
<script src="<?=$staticUrl?>js/asyncad.js"></script>
<!-- Async AD  -->
<!-- DFP header files end -->
<!-- getclicky script -->
<script>var clicky_site_ids = clicky_site_ids || []; clicky_site_ids.push(101167962);</script>
<script async src="//static.getclicky.com/js"></script>


<!-- cookie consent -->
<link rel="stylesheet" type="text/css" href="<?=$ejstaticUrl?>/css/cookieconsent.min.css" />
<script src="<?=$ejstaticUrl?>/js/cookieconsent.min.js"></script>
<script src="<?=$ejstaticUrl?>/js/consent_setting.js?20180524a"></script>

</head>
<body>
<div canvas="container" id="upper_lv_container">
<!-- Wrapper -->
<div id="wrapper" class="ljpage" >
<?php if (Yii::$app->controller->action->id=='index') {?>
<div class="home" >
<?php 
    } else if (strpos(Yii::$app->controller->action->id, 'blog') !== false) {?>
<div class="section blog" >
<?php } else if (Yii::$app->controller->action->id=='article' && $this->article->section->nav=='blog') {?>
<div class="section blog article" >
<?php } else if (Yii::$app->controller->action->id=='article' && !$this->article->section->nav!='blog'){?>
<div class="section article" >
<?php } else {?>
<div class="section" >
<?php }?>

<header class="main_width width1200">
<?php //$this->renderPartial('topnav')?>
<div class="topinfo">
                 <div class="social_media_icon">
                     <span class="fb"><a href="http://www.facebook.com/lifestylejournal" target="_blank"></a></span>
                     <span class="ig"><a href="http://instagram.com/lifestylejournal" target="_blank"></a></span>
                     <span class="email"><a href="mailto:lj@hkej.com"></a></span>
           <!-- MiniSite Logo -->
           <?php
            if(preg_match("/\/article/i", $_SERVER['REQUEST_URI'])){ 
              //include(dirname(__FILE__).'/../banner/ad_async_miniSiteLogo_setting.php');
            } else {
              //include(dirname(__FILE__).'/../banner/ad_sync_miniSiteLogo_setting.php');
            } 
           ?>
                   </div>

                
                 <div class="info_right">
                 <div class="menu_list">
                    <ul> 
                    <?php
          /*
          $aryNav=Yii::$app->params['nav2017Top'];
          
          foreach($aryNav as $k=>$v){
            if ($this->section->nav <> NULL ) {
              $on = strpos($this->section->nav, $k) !== false? 'class="active"': ''; ?>
              <li class="<?php echo $k ?>"><a href="/<?=$this->id?>/<?php echo $k ?>" <?php echo $on ?>><?php echo $v ?></a></li> 
            <?php 
            } else {
              $on = strpos($this->id, $k) !== false? 'class="active"': ''; ?>
              <li class="<?php echo $k ?>"><a href="/<?=$this->id?>/<?php echo $k ?>" <?php echo $on ?>><?php echo $v ?></a></li>
            <?php
              }
            }     */    
          ?>           
                    </ul>
                 </div>
                </div>     
                  
                 <div class="lj_logo"><a href=""><img src="<?=$staticUrl?>images/ljlogo.gif" alt="" /></a></div>         
        </div>
</header>

<?php echo $content; ?>

<!-- Footer -->     

<div id="footer" >
            <div class="info  width1200">
                <div class="totop">
                <a title="BACK TO TOP" data-scroll="" href="#top">BACK TO TOP</a>
                
                </div>
                
                 <div class="footerlogo"><a href="#"><img src="<?=$staticUrl?>images/ljlogo.jpg" alt=""/></a></div>
                <div class="footerlist">
                    
                  <a href="https://www2.hkej.com/info/aboutus" target="_blank">信報簡介</a>
|
<a href="https://www2.hkej.com/info/memberprovision" target="_blank">服務條款</a>
|
<a href="https://www2.hkej.com/info/privacy" target="_blank">私隱條款</a>
|
<a href="https://www2.hkej.com/info/disclaimer" target="_blank">免責聲明</a>
|
<a href="https://www.hkej.com/ratecard/html/index.html" target="_blank">廣告查詢</a>
|
<a href="https://www2.hkej.com/info/jobs" target="_blank">加入信報</a>
|
<a href="https://www2.hkej.com/info/contactus" target="_blank">聯絡信報</a>
                
              </div>
           <p>信報財經新聞有限公司版權所有，不得轉載。<br>
Copyright © <?= date('Y') ?> Hong Kong Economic Journal Company Limited. All rights reserved.</p>
                </div>
              
              
                <div class="footer_links">
                 <div class="social_media_icon  width1200">   
                     <span class="fb"><a href="http://www.facebook.com/lifestylejournal" target="_blank"></a></span>
                     <span class="ig"><a href="http://instagram.com/lifestylejournal" target="_blank"></a></span>
                     <span class="email"><a href="mailto:lj@hkej.com"></a></span>
                   </div>
                    </div>
</div>             
<!-- Footer end--> 
</div>

</div>
</div>
</div><!-- Wrapper-end -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
