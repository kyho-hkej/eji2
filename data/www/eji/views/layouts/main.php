<?php
use yii\helpers\Html;
use yii\helpers\EjiHelper;
use app\models\HKEJUser;
//use yii\base\Controller;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0">    
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="Pragma" content="no-cache" />
  <title><?= Html::encode($this->title) ?></title>
  <?PHP
  $this->head();
  ?>
  <LINK REL="SHORTCUT ICON" HREF="/images/favicon.ico?123">    

  <!-- Material Design for Bootstrap CSS -->
  <link rel="stylesheet" href="/assets/bootstrap/bootstrap.css" />
  <link rel="stylesheet" href="/assets/sidemenu/drawer.css" />
  <!-- icheck Button -->
  <link href="/assets/icheck/green.css" rel="stylesheet" />
  <link href="/assets/icheck/skins/square/green.css" rel="stylesheet" />
  <!-- auto complete -->
  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />           
  <!-- Add fancyBox main CSS files -->      
  <link rel="stylesheet" type="text/css" href="/assets/fancybox3/jquery.fancybox.css" media="screen" />

  <!-- swiper slider -->      
  <link rel="stylesheet" type="text/css" href="/assets/swiper/slick-theme.css" />
      
  <!-- lightslider -->
  <link rel="stylesheet"  href="/assets/lightslider/lightslider.css"/>
      
  <link rel="stylesheet" href="/assets/innermenu/style.css" />
  <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="/assets/slider/swiper.css">

  <link rel="stylesheet" href="/assets/css/style.css?20200108b" />
                
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

  <!--  JavaScript Force HTTPS/HTTP  -->
  <script type="text/javascript">
  /*if (location.protocol != 'https:')
        {
         location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
        }*/
  </script>
  <!--  JavaScript Force HTTPS/HTTP  -->
  <!-- auto complete -->
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>        
  <script type="text/javascript" src="//code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
       
  <!-- Javascript -->
  <script src="/assets/js/smooth-scroll.js"></script>
  <script>
    smoothScroll.init();
  </script>
   
          
  <!-- Add fancyBox main JS files -->
  <script type="text/javascript" src="/assets/fancybox3/jquery.fancybox.js"></script>


  <!-- Google Analytics Asynchronous Tracking -->
  <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-4710049-1']);
    _gaq.push(['_setDomainName', 'hkej.com']);
    _gaq.push(['_addIgnoredRef', 'hkej.com']);    
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
    })();

  </script>

  <!-- cookie consent --> 
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->params['staticEJUrl'];?>css/cookieconsent.min.css?20200115a" />
  <script src="<?php echo Yii::$app->params['staticEJUrl'];?>js/cookieconsent.min.js"></script>
  <script src="/assets/js/consent_setting.js?20200320c"></script>
  <!-- cookie consent -->
  <!-- Async AD   -->
  <script src="/assets/js/asyncad.js?20240812a"></script>
  <!-- Async AD  -->
  <!-- getclicky script -->
  <script>var clicky_site_ids = clicky_site_ids || []; clicky_site_ids.push(101164885);</script>
  <script async src="//static.getclicky.com/js"></script>

  <script type="text/javascript" class="teads" src="//a.teads.tv/page/106206/tag" async="true"></script>

  <script src="/assets/js/mixpanel.js?20200122a"></script>

  </head>

  <body class="drawer drawer--left">
  <?php $this->beginBody() ?>
  <!-- Wrapper --> 
  <div id="top"></div>
  <?php //if(preg_match("/\/index/i", $_SERVER['REQUEST_URI'])){ 
        if($this->context->action->id == 'index'){ 
  ?>
  <div id="wrapper_home" > 
  <?php }?>
  <div id="wrapper" >
  <?php include(dirname(__FILE__).'/../banner/ad_TopBanner_setting.php'); ?>
  <?=$this->render("/layouts/header");
  //yii\base\View::renderPartial('header'); ?>
  <?php echo $content; ?>
  <!-- footer --> 
  <div class="footer">
  <div id="go-top" ><a title="Back to Top" data-scroll href="#top">&#9650;</a>
  </div>
        
                  
  <div class="info">

                  
  <div class="footerlist">
  <a href="/eji/aboutus">About us</a>
  |
  <a href="/eji/contactus">Contact us</a>
  |  
  <a href="//www.hkej.com/ad/html/eji_rate.html" target="_blank">Advertise</a>
  |
  <a href="<?=Yii::$app->params['www2Url'] ?>info/disclaimer" target="_blank">Disclaimer</a>
  |
  <a href="<?=Yii::$app->params['www2Url'] ?>info/privacy" target="_blank">Privacy</a>
  |
  <a href="//www.hkej.com/" target="_blank">HKEJ</a>         
  </div>

  <div class="disclaimer"> 
  Copyright © <?= date('Y') ?> Hong Kong Economic Journal Company Limited. All rights reserved.</p>
  </div>
             
  </div>
  <!-- footer end --> 
  </div>
  <!-- Wrapper-end -->
  <?php if(preg_match("/\/index/i", $_SERVER['REQUEST_URI'])){ ?>
  <!-- Wrapper home -end -->
  </div> 
  <?php }?>

  <!-- iScroll -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/iScroll/5.2.0/iscroll.js"></script>
  <!-- bootstrap -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
  <!-- drawer.js -->
  <script src="/assets/sidemenu/drawer.min.js?20200103b" charset="utf-8"></script>
  <script> 
  jQuery(function($){  
      $(document).ready(function() {
        $('.drawer').drawer();
      });
  });    
  </script>
  <!--
  <script src="/assets/icheck/icheck.js?20190315" ></script>  
  <script>
  $(document).ready(function(){
    $('input.icheckstyle').each(function(){
      var self = $(this),
        label = self.next(),
        label_text = label.text();

      label.remove();
      self.iCheck({
        checkboxClass: 'icheckbox_line-green',
           radioClass: 'iradio_square-green',
        insert: '<div class="icheck_line-icon"></div>' + label_text
      });
    });
  });
        
  </script> 


//no working
  <script src="/assets/js/sticky-kit.js"></script>
  <script src="/assets/js/stickyhere.js"></script>
  <script>

  (function() {
                 
                 $(".menu").stick_in_parent({
               parent: "#wrapper"
               }); 

          
                 
  });   
  </script>-->

  <!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5dc3c2d35b76b96d"></script>

  <!-- Swiper list -->
  <script src="/assets/swiper/slick.js" type="text/javascript" ></script>

  <script src="/assets/js/jquery.js" ></script>    


  <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-4710049-1']);
  _gaq.push(['_setDomainName', 'hkej.com']);
  _gaq.push(['_addIgnoredRef', 'hkej.com']);
  _gaq.push(['_trackPageview']);
  <?php 
  echo "_gaq.push(['_trackEvent', '". $this->params['trackEvent']['category']."', '". $this->params['trackEvent']['action']."', '". $this->params['trackEvent']['label']."']);";
  /*foreach($this->params['trackEvent'] as $event){
    echo "_gaq.push(['_trackEvent', '".$event['category']."', '".$event['action']."', '".$event['label']."']);";
  }
  */
  ?>

  (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script> 
  <!-- Begin comScore Tag -->
  <script>
      document.write(unescape("%3Cscript src='" + (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js' %3E%3C/script%3E"));
  </script>

  <script>
    COMSCORE.beacon({
      c1:2,
      c2:7634239,
      c3:"",
      c4:"",
      c5:"",
      c6:"",
      c15:""
    });
  </script>
  <noscript>
    <img src="//b.scorecardresearch.com/p?c1=2&c2=7634239&c3=&c4=&c5=&c6=&c15=&cj=1" />
  </noscript>
  <!-- End comScore Tag -->

  <script type="text/javascript">
  $("body").children().each(function () {
      $('img').prop('src', function () { return this.src.replace('https://static.hkej.com/','https://static.hkej.net/'); });
      $('img').prop('src', function () { return this.src.replace('http://static.hkej.com/','http://static.hkej.net/'); });
    //$(this).html( $(this).html().replace(/static.hkej.com/g,"static.hkej.net") );
  });
  </script>

  <!-- Swiper JS -->
  <script src="/assets/slider/swiper.min.js"  type="text/javascript"></script>
  <script type="text/javascript">                
  var swiper = new Swiper('.swiper-container', {
     autoplay: {
          delay: 5500,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      });
    
                
  </script>



<?php 
//apply on all layout except article
if (!preg_match("/\/article/i", $_SERVER['REQUEST_URI'])){ ?>

<!-- HKEJ Counter - Start -->
<script type="text/javascript">

  var ejValue={};
  
  ejValue['currentGMT']="<?php echo gmdate('c'); ?>";     
  ejValue['locationIp']="<?php echo (isset($_SERVER['HTTP_CF_CONNECTING_IP'])?$_SERVER['HTTP_CF_CONNECTING_IP']:$_SERVER['REMOTE_ADDR']); ?>";
  <?php if (isset($_SERVER['HTTP_CF_IPCOUNTRY'])) {?>
  ejValue['locationCountry']="<?php echo $_SERVER['HTTP_CF_IPCOUNTRY']; ?>";    
  <?php } 
  ?>

  ejValue['categoryId']="1002";      
  ejValue['categoryName']="EJINSIGHT";   

<?php
  if(preg_match("/\/index/i", $_SERVER['REQUEST_URI'])){ 
?> 

    ejValue['firstSectionId']="";
    ejValue['firstSectionName']="";

<?php
  } else if (preg_match("/\/listing/i", $_SERVER['REQUEST_URI'])){ ?>

    ejValue['firstSectionId']="<?php //echo $firstSectionId; ?>";
    ejValue['firstSectionName']="<?php echo EjiHelper::getSectionLabel($_REQUEST['category']); ?>";

<?php
  } else {
?>   

    ejValue['firstSectionId']="";
    ejValue['firstSectionName']="";


<?php } 

  $isMobilePage='';

  //echo \Yii::$app->mobileDetect->isMobile();
  //echo \Yii::$app->mobileDetect->isTablet();
  //echo \Yii::$app->mobileDetect->isDesktop();

  // $detect = Yii::$app->mobileDetect;
    //if device is mobile, redirect to mobile version
    if (Yii::$app->mobileDetect->isMobile() && !Yii::$app->mobileDetect->isTablet()) {
        $isMobilePage='Y';
    } else {
        $isMobilePage='N';
    }

?>

  ejValue['isMobilePage']="<?php echo $isMobilePage; ?>";    

  <?php if(preg_match("/\/index/i", $_SERVER['REQUEST_URI'])){ ?>
    ejValue['typeOfPage']="EJI Landing";
  <?php } else { ?>
    ejValue['typeOfPage']="Listing";  
  <?php } ?>

  //ejValue['num']="<?php //echo $this->getUserId()*73; ?>";  
  ejValue['num']="0";
  <?php 
  $forumname = '';
  if (isset($_COOKIE["forumname"])) {
    $forumname = $_COOKIE["forumname"];
  } else {
      $forumname = '';
  }
  ?>
  ejValue['Forumname']="<?php echo $forumname; ?>"; 

  (function() {
    var eja = document.createElement('script'); eja.type = 'text/javascript'; eja.async = true;
    eja.src = ('https:' == document.location.protocol ? 'https://www' : 'http://www') + '.hkej.com/js/ejcounter.js?v='+Math.random();
    var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(eja, x);
  })();

</script> 
<!-- HKEJ Counter - End --> 
<?php } ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
