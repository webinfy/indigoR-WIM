<style>
    .main{
        background: url(<?php echo HTTP_ROOT . BACKGROUND_IMAGE . $backgroundImage['BackgroundImage']['image']; ?>) no-repeat center top fixed;
    }
</style>
<?php // pr($get_parent_menu);exit;            ?>
<div class="main">
    <?php if (!empty($getSeasonData)) { ?>
        <div class="summer-box-area">
            <div class="wrapper">
                <div class="summer-box">
                    <div class="summer-box-1">
                        <!--<h2>Discover the Excitement and Charm of Lake Ontario�s Eastern Shore</h2>-->
                        <h2><?php echo $getSeasonData['Season']['script']; ?></h2>
                    </div>

                    <div class="summer-box-2">
                        <?php if (!empty($getSeasonData['Season']['image'])) { ?>
                            <a href="<?php echo $getSeasonData['Season']['link']; ?>" target="_blank" title="The Best of Upstate NY"><img src="<?php echo HTTP_ROOT . SEASON_IMAGE . $getSeasonData['Season']['image']; ?>"/></a>
                            <!--<a href="http://issuu.com/cnysummerguide/docs/cny-summerguide-2015" target="_blank" title="The Best of Upstate NY"><img src="<?php echo HTTP_ROOT; ?>img/summer-book.png"/></a>-->
                        <?php } ?>
                    </div>
                     <a id='backTop' style="bottom: 54px;display: none;position: fixed;right: 40px;">Back To Top</a>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="header_area">
        <div class="wrapper">
            <div class="header">
                <div class="logo"><a href="<?php echo HTTP_ROOT; ?>"><img src="<?php echo HTTP_ROOT; ?>img/logo.png"/></a></div>
                <div class="right_section">
                    <div class="map_row"><a href="http://glvmap-it.com/" ><img src="<?php echo HTTP_ROOT; ?>img/explore-interactive-map.png"/></a></div>
                    <div class="weather_row">
                        <a href="http://www.wunderground.com/q/zmw:13126.1.99999" title="San Francisco, California Weather Forecast" target="_blank">
                            <img src="<?php echo HTTP_ROOT; ?>img/weather-(2).png"/>                           
                        </a>
                    </div>
                    <div class="social">
                        <h3>Connect with us :</h3>
                        <ul>
                            <li class="facebook"><a <?php echo $socialLinks[0]['Setting']['value'] ? 'href="' . $socialLinks[0]['Setting']['value'] . '" target="_blank"' : 'href="javascript:;"'; ?>></a></li>
                            <li class="twitter"><a <?php echo $socialLinks[1]['Setting']['value'] ? 'href="' . $socialLinks[1]['Setting']['value'] . '" target="_blank"' : 'href="javascript:;"'; ?>></a></li>
                            <li class="youtube"><a <?php echo $socialLinks[2]['Setting']['value'] ? 'href="' . $socialLinks[2]['Setting']['value'] . '" target="_blank"' : 'href="javascript:;"'; ?>></a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                    <div class="header-right">
                        <form id="rs-main-search-box" action="<?php echo $this->webroot . 'search'; ?>">
                            <input type="text" placeholder="Search..." maxlength="100" autocomplete="off" name="gsc.q" id="rs-main-search-text" />
                            <input type="submit" value="Search">
                        </form>
                    </div>
                    <div class="clear"></div>
                    <div style="float: right; margin-top: 5px;">
<!--GOOGLE TRANSLATE MINI FLAGS-->
 <div align="center" style="width:auto;">
 <!-- Add English to Spanish -->

 <a target="_blank" rel="nofollow" onclick="window.open('http://www.google.com/translate?u='+encodeURIComponent(location.href)+'&langpair=en%7Ces&hl=en&ie=UTF8'); return false;" title="Spanish"><img border="0" style="cursor:pointer; cursor:hand;" width="19" alt="Spanish " src="https://sites.google.com/site/translationflags/images/_spanish_s.png" height="19" title="Spanish"/></a>

 <!-- END English to Spanish -->

 <!-- Add English to French -->

 <a target="_blank" rel="nofollow" onclick="window.open('http://www.google.com/translate?u='+encodeURIComponent(location.href)+'&langpair=en%7Cfr&hl=en&ie=UTF8'); return false;" title="French "><img border="0" style="cursor:pointer; cursor:hand;" width="19" alt="French " src="https://sites.google.com/site/translationflags/images/_french_s.png" height="19" title="French"/></a>

 <!-- END English to French -->

 <!-- Add English to German -->

 <a target="_blank" rel="nofollow" onclick="window.open('http://www.google.com/translate?u='+encodeURIComponent(location.href)+'&langpair=en%7Cde&hl=en&ie=UTF8'); return false;" title="German"><img border="0" style="cursor:pointer; cursor:hand;" width="19" alt="German" src="https://sites.google.com/site/translationflags/images/_german_s.png" height="19" title="German"/></a>

 <!-- END English to German -->



 <!-- Add English to Italian -->

 <a target="_blank" rel="nofollow" onclick="window.open('http://www.google.com/translate?u='+encodeURIComponent(location.href)+'&langpair=en%7Cit&hl=en&ie=UTF8'); return false;" title="Italian"><img border="0" style="cursor:pointer; cursor:hand;" width="19" alt="Italian" src="https://sites.google.com/site/translationflags/images/_italian_s.png" height="19" title="Italian"/></a>

 <!-- END English to Italian -->



 <!-- Add English to Japanese BETA -->

 <a target="_blank" rel="nofollow" onclick="window.open('http://www.google.com/translate?u='+encodeURIComponent(location.href)+'&langpair=en%7Cja&hl=en&ie=UTF8'); return false;" title="Japanese"><img border="0" style="cursor:pointer; cursor:hand;" width="19" alt="Japanese" src="https://sites.google.com/site/translationflags/images/_japanese_s.png" height="19" title="Japanese"/></a>

 <!-- END English to Japanese BETA -->



 <!-- Add English to Korean BETA -->

 <a target="_blank" rel="nofollow" onclick="window.open('http://www.google.com/translate?u='+encodeURIComponent(location.href)+'&langpair=en%7Cko&hl=en&ie=UTF8'); return false;" title="Korean"><img border="0" style="cursor:pointer; cursor:hand;" width="19" alt="Korean" src="https://sites.google.com/site/translationflags/images/_korean_s.png" height="19" title="Korean"/></a>

 <!-- END English to Korean BETA -->



 <!-- Add English to Russian BETA -->

 <a target="_blank" rel="nofollow" onclick="window.open('http://www.google.com/translate?u='+encodeURIComponent(location.href)+'&langpair=en%7Cru&hl=en&ie=UTF8'); return false;" title="Russian"><img border="0" style="cursor:pointer; cursor:hand;" width="19" alt="Russian" src="https://sites.google.com/site/translationflags/images/_russian_s.png" height="19" title="Russian"/></a>

 <!-- END English to Russian BETA -->

 <!--- Add English to Chinese BETA -->
 <a target="_blank" rel="nofollow" onclick="window.open('http://www.google.com/translate?u='+encodeURIComponent(location.href)+'&langpair=en%7Czh-CN&hl=en&ie=UTF8'); return false;" title="Chinese"><img border="0" style="cursor:pointer; cursor:hand;" width="19" alt="Russian" src="https://sites.google.com/site/translationflags/images/_chinese_s.png" height="19" title="Chinese"/></a>

 <!-- END English to Chinese BETA -->
 </div>
</div>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-area">
        <div class="wrapper" style="position:relative;">
        	<?php if($controllerAction['paramController'] == 'users' && $controllerAction['paramAction'] == 'home'){ ?>
        	<a href="http://glvmap-it.com/" class="banner-map-img" ><img src="<?php echo HTTP_ROOT; ?>img/glv-map-it.png" /></a>
        	<?php } ?>
            <div class="nav" >
            	
                <ul>
                    <?php
                    foreach ($get_parent_menu as $get_parent_menus) {
                        ?>
                        <li>
                            <?php if ($get_parent_menus['Menu']['id'] == 1) {
                                ?>
                                <a href="<?php echo HTTP_ROOT; ?>"><?php echo $get_parent_menus['Menu']['name']; ?></a> 

                                <?php
                            } else if ($get_parent_menus['Menu']['seo'] == "events") {
                                ?>

                                <a href="<?php echo HTTP_ROOT; ?>all-events"><?php echo $get_parent_menus['Menu']['name']; ?></a> 
                            <?php } else { ?>
                                <a href="<?php echo HTTP_ROOT; ?>viewpage/<?php echo $get_list_of_page_header[$get_parent_menus['Menu']['page_id']]; ?>/<?php echo $get_parent_menus['Menu']['id']; ?>"><?php echo $get_parent_menus['Menu']['name']; ?></a> 

                            <?php } ?>
                            <?php if (!empty($get_parent_menus['Submenu'])) { ?>
                                <ul class="sub-menu">
                                    <?php foreach ($get_parent_menus['Submenu'] as $submenu) { ?>
                                        <?php if ($submenu ['is_active'] == 1) {
                                            ?>
                                            <?php //foreach ($get_all_page_content as $get_all_page_contents) {
                                            ?>
                                            <?php //if ($get_all_page_contents['Page']['id'] == $submenu ['page_id']) {
                                            ?>
                                            <li><a href="<?php echo HTTP_ROOT; ?>viewpage/<?php echo $get_list_of_page_header[$submenu['page_id']]; ?>/<?php echo $submenu ['id']; ?>"><?php echo $submenu ['name']; ?></a></li>
                                            <?php
                                            //}}
                                        }
                                    }
                                    ?>
                                </ul>          
                            <?php } ?>
                        </li> 
                    <?php } ?> 

                </ul>
            </div>
            <div id="dl-menu" class="dl-menuwrapper">
                <button class="dl-trigger">Open Menu</button>
                <ul class="dl-menu">
                    <?php
                    foreach ($get_parent_menu as $get_parent_menus) {
                        ?>
                        <li><span class="icon"></span>
                            <?php if ($get_parent_menus['Menu']['seo'] == "home-page") {
                                ?>
                                <a href="<?php echo HTTP_ROOT; ?>"><?php echo $get_parent_menus['Menu']['name']; ?></a> 

                                <?php
                            } else if ($get_parent_menus['Menu']['seo'] == "events") {
                                ?>

                                <a href="<?php echo HTTP_ROOT; ?>all-events"><?php echo $get_parent_menus['Menu']['name']; ?></a> 
                            <?php } else { ?>
                                <a href="<?php echo HTTP_ROOT; ?>viewpage/<?php echo $get_list_of_page_header[$get_parent_menus['Menu']['page_id']]; ?>/<?php echo $get_parent_menus['Menu']['id']; ?>"><?php echo $get_parent_menus['Menu']['name']; ?></a> 

                            <?php } ?>
                            <?php if (!empty($get_parent_menus['Submenu'])) { ?>
                                <ul class="dl-submenu">
                                    <?php foreach ($get_parent_menus['Submenu'] as $submenu) { ?>
                                        <?php if ($submenu ['is_active'] == 1) {
                                            ?>
                                            <?php //foreach ($get_all_page_content as $get_all_page_contents) {
                                            ?>
                                            <?php //if ($get_all_page_contents['Page']['id'] == $submenu ['page_id']) {
                                            ?>
                                            <li><a href="<?php echo HTTP_ROOT; ?>viewpage/<?php echo $get_list_of_page_header[$submenu['page_id']]; ?>/<?php echo $submenu ['id']; ?>"><?php echo $submenu ['name']; ?></a></li>
                                            <?php
                                            //}}
                                        }
                                    }
                                    ?>
                                </ul>      
                            <?php } ?>
                        </li> 
                    <?php } ?> 

                </ul>
            </div>
        </div>

    </div>