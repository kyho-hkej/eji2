           <header>
           
                    <div class="menu">
                        
                       
                    <button type="button" class="drawer-toggle drawer-hamburger">
					  <span class="drawer-hamburger-icon"></span>
                    </button>
                    
                        
                    <div class="logo"><a href="/eji/index"><img src="/images/eji_logo_600.png?20240813" alt="" /></a></div>
                   
                    <div class="user">
                     
                        <div class="search_icon dropdown">
						
							<a href="#" class="" id="dropdownsearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>Search</span></a>
						
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownsearch">

              <?php $_REQUEST['q']='';?>

							<form action="<?php echo Yii::$app->params['searchUrl']; ?>" id="menu_form" method="get" target="_blank" >							
							<input type="text" id="q" name="q" class="dropdowntext" placeholder="SEARCH" value="<?php echo $_REQUEST['q'] ?>">
							</form>
						  

              </div>
							
						</div>                         
                        <div class="fb_icon"><a href="https://facebook.com/ejinsight/" target="blank"><img src="/images/fbicon.png" alt=""></a></div>
                      
                    </div>     
                    </div>    
                        <nav class="drawer-nav" >
                         
                    
                          <ul class="drawer-menu sidemenu">
                              <li><button type="button" class="drawer-toggle drawer-hamburger closebtn">
                          <span class="drawer-hamburger-icon close"></span>
                        </button></li>
                            <li><a class="home" href="/eji/index">HOME</a></li>
                            <?php                             
                            $aryNav=Yii::$app->params['top_nav'];
                            foreach($aryNav as $k=>$v){?>
                            		 <li><a href="/eji/category/<?=$k?>"><?=$v?></a></li>
                            <?php }
                            ?>
							<!--<li><a class="cm" href="/eji/feedback">Feedback</a></li>-->
                            <li><div class="social_media_icon">EJInsight Facebook：
                              <span class="fb"><a href="https://www.facebook.com/ejinsight/" target="_blank"><img src="/images/social_media01.png" alt="" /></a></span>
                              <!-- <span class="yu"><a href="#" target="_blank"><img src="/images_v2/social_media02.png" alt="" /></a></span>--> 
                             </div></li>
                            <li class="backej"><a href="http://www.hkej.com/">www.hkej.com</a></li>
                             
                        </ul>
                                                 
                        </nav>
                    	<?php //$this->renderPartial('header_loginbox');?>
               <?php //$this->renderPartial('/layouts/header_reg_form');?>
               
         
           </header>
           <!-- header end -->  

