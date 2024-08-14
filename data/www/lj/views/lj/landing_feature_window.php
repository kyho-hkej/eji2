<?php 
$staticUrl = Yii::$app->params['ljstaticUrl'].'/web/';
?>
<script type="text/javascript">
$(function() {
    
    $(".topmenu").stick_in_parent({
  parent: "#wrapper"
  }); 

 });
function resize() {
    if ($(window).width() > 799) {
    $('body').removeClass('mobileview');
     
    $(".sticklist").stick_in_parent({
     parent: ".row1", 
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
<div class="width1200_feature">  
				<div class="loading">  
                <div class="feature_window">
                    
                    
                    <!---- Swiper ----->
                    <div class="swiper">
                  
                  
                    <?php 

	                  foreach ($slider_all as $s) {
	                  	
	                  	$articleUrl=$s->URL;
	                  	$sectionLabel=$s->subhead;
	                  	$subjectline=$s->subjectline;
	                  
	                ?>


                        
                        <div class="swiper-slide">
                        <a href="<?=$articleUrl?>" title="<?=$subjectline?>">
                        <span class="bg_layer_landing"></span>                        
                        <span class="text">
                        <span class="cat"><?=$sectionLabel?></span>
                        <span><?=$subjectline?></span>
                        </span>
                        <?php 
                        if($s->firstPhoto != ''){
                            for($i=0;$i<count($s->photos);$i++){
                            	$p=$s->photos[$i];
                            	if ($p->publishType ==3){
								?>
								<img src="<?=$staticUrl?><?=$p->dirPath ?><?=$p->filename?>" alt="" class="desktopView"/>
								<?php 
                            	}
                            	if ($p->publishType ==5){ //mobile 大圖
								?>
								<img src="<?=$staticUrl?><?=$p->dirPath ?><?=$p->filename?>" alt="" class="mobileView"/>
								<?php 
                            	}
                            }
	                  	}                           
                        ?>

                        </a>
                        </div>
                  
                   <?php }?>     
                    </div>
                    <!---- Swiper ----->
                    
                   </div>
                   </div>
</div>
                    
                    
<!-- Gallery list -->
<script src="<?=$staticUrl?>gallery/slick.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

$(document).on('ready', function() {
    $(".gallerylist").slick({
      dots: true,
      infinite: false,
      slidesToShow: 3,
      slidesToScroll: 3,
        responsive: [
          {
            breakpoint: 480,
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
    
    
    
    $(document).on('ready', function() {
    $(".video_mobile").slick({
      dots: false,
      infinite: false,
      slidesToShow: 3,
      slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 881,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              dots: false
            }
          }
        ] 
    });                                        
  });
    

  
  $(document).on('ready', function() {
    $(".swiper").slick({
      dots: true,
      infinite: true,
        autoplay: true,
         autoplaySpeed: 3500
       
    });                                        
  });




  $(document).on('ready', function() {
    $(".popu").slick({
      slidesToShow: 4,
        infinite: false,
        dots: false,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 881,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              infinite: true,
              dots: false
            }
          }
        ] 
    });                                        
  });
                                                                
 </script>
 <!-- Gallery list -->                    