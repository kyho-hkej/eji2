<?php $dir_path='/'.Yii::$app->params['dir_path'].'/';?>

<!-- menu -->  
        <div id="menu">
              
        <div class="topmenu topmenu2">
            
        <!-- navbar -->  
      <div  id="navbar" class="navbar justify-content-center align-items-center animate__animated animate__fadeInDown">
        <ul class="align-items-center justify-content-between">
          <li class="logo"><a href="<?=$dir_path?>" title="Home"><img src="eji/img/eji_icon.png" alt="" /></a></li>
          
          <?php
          foreach (Yii::$app->params['mainmenu_nav'] as $m) {
                if($m['show']==1) {


                        print " <li class='nav-item dropdown'><a class='nav-link '' href='{$dir_path}{$m['id']}'><span>{$m['label']}</span> <i class='bi bi-chevron-down'></i></a>";
                   
                        if(!empty($m['sub_nav'])) {

                            print "<ul class='dropdown-menu'>";
                            foreach ($m['sub_nav'] as $nav=>$label) {
                                print "<li><a class='dropdown-item' href='{$dir_path}{$nav}'>{$label}</a></li>";
                            }
                            print "</ul>";
                        }
                        print "</li>";
                    }

                   /* echo $m['label'].'<br>';
                    if(!empty($m['sub_nav'])) {
                        foreach ($m['sub_nav'] as $nav=>$label) {
                            echo $nav.'<br>';
                        }
                    }*/
                }
          
          ?>
            
          <li class="search"><a href="#inlinesearch" data-lity ><img src="images/searchicon.jpg" alt="" /></a></li>	
            
        </ul>
      </div><!-- navbar -->
            
            
       </div>
            
            <div class="mobile_menu ">
                 <div id="nav-icon2" class="hamburger js-toggle-left-slidebar">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div></div>    
                  </div>
                
            <div class="mobilelogo"><a href="<?=$dir_path?>" title="Home"><img src="eji/img/eji_logo.png" alt="" /></a></div>	
            <div class="search"><a href="#inlinesearch" data-lity title="Search"><img src="images/searchicon2.jpg" alt="" /></a></div>	    
  
           </div>
            
        </div><!-- menu -->
        