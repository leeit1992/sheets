<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> 
<html lang="en"> <!--<![endif]-->

<!-- Mirrored from altair_html.tzdthemes.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Sep 2015 09:17:10 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <title>Atl Travel Manage - </title>
    
    <?php  
		enqueueStyle(
			array(
					'uikit.almost'  => assets('bower_components/uikit/css/uikit.almost-flat.min.css'),
					'flags'  => assets('assets/icons/flags/flags.min.css'),
                    'main'  => assets('assets/css/main.min.css'),
					'project'  => assets('css/project.css'),
				)
		);
	?>

    <script type="text/javascript">
        window.OPDATA = {
            adminUrl: "<?php echo url('/'); ?>",
        }
    </script>
	
    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body class="sidebar_main_open sidebar_main_swipe">
	<!-- main header -->
    <header id="header_main">
        <div class="header_main_content">
            <nav class="uk-navbar">
                <!-- main sidebar switch -->
                <a href="#" id="sidebar_main_toggle" class="op-switch-screen-js sSwitch sSwitch_left">
                    <span class="sSwitchIcon"></span>
                </a>
                <!-- secondary sidebar switch -->
                <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                    <span class="sSwitchIcon"></span>
                </a>

                 <?php View('layout/menuTop.tpl') ?>
     
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav user_actions">
                        <li><a href="#" id="main_search_btn" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE8B6;</i></a></li>
                       
                        <?php View('layout/messages.tpl') ?>

                        <li data-uk-dropdown="{mode:'click'}">
                            <a href="#" class="user_action_image">
                                <img class="md-user-image" style="height: 34px;" src="<?php echo url( $userInfo['user_avatar'] ) ?>" alt=""/>
                            </a>
                            <div class="uk-dropdown uk-dropdown-small uk-dropdown-flip">
                                <ul class="uk-nav js-uk-prevent">
                                    <li><a href="<?php echo url('/atl-admin/edit-user/' . $userId) ?>">My profile</a></li>
                                    <li><a href="<?php echo url('/logout') ?>">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

            </nav>
        </div>
        <div class="header_main_search_form">
            <i class="md-icon header_main_search_close material-icons">&#xE5CD;</i>
            <form class="uk-form">
                <input type="text" class="header_main_search_input" />
                <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">&#xE8B6;</i></button>
            </form>
        </div>
    </header>
    <!-- main header end -->

<!-- page content -->
<div id="page_content">
    <div id="page_content_inner">