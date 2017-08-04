<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> 
<html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <title>Atl Travel Manage - Login Page</title>

    <?php  
        enqueueStyle(
            array(
                    'googleapis'  => 'http://fonts.googleapis.com/css?family=Roboto:300,400,500',
                    'almost'      => assets('bower_components/uikit/css/uikit.almost-flat.min.css'),
                    'login_page'  => assets('assets/css/login_page.min.css'),
                )
        );
    ?>

    <script type="text/javascript">
        window.OPDATA = {
            adminUrl: "<?php echo url('/'); ?>",
        }
    </script>

</head>
<body id="op-login-page" class="login_page">

    <div class="login_page_wrapper">
        <div class="md-card" id="login_card">

            <?php 
                if( !empty( $noticeLogin ) ) {
                    ?>
                    <div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>
                        <?php
                            echo $noticeLogin[0];
                        ?>
                    </div>
                    <?php   
                }
            ?>
           
            <div class="md-card-content large-padding" id="login_form">
                <div class="login_heading">
                    <div class="user_avatar"></div>
                </div>
                <form method="POST" action="<?php echo url('/check-login') ?>">
                    <div class="uk-form-row">
                        <label for="atl_login_acc">Email</label>
                        <input class="md-input" type="email" name="op_login_acc" />
                    </div>
                    <div class="uk-form-row">
                        <label for="atl_login_pass">Password</label>
                        <input class="md-input" type="password" name="op_login_pass" />
                    </div>
                    <div class="uk-margin-medium-top">
                        <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Sign In</button>
                    </div>
                    <div class="uk-margin-top">
                        <a href="#" id="login_help_show" class="uk-float-right">Need help?</a>
                        <span class="icheck-inline">
                            <input type="checkbox" name="login_page_stay_signed" id="login_page_stay_signed" data-md-icheck />
                            <label for="login_page_stay_signed" class="inline-label">Stay signed in</label>
                        </span>
                    </div>
                </form>
            </div>
            <div class="md-card-content large-padding uk-position-relative" id="login_help" style="display: none">
                <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                <h2 class="heading_b uk-text-success">Can't log in?</h2>
                <p>Here’s the info to get you back in to your account as quickly as possible.</p>
                <p>First, try the easiest thing: if you remember your password but it isn’t working, make sure that Caps Lock is turned off, and that your username is spelled correctly, and then try again.</p>
                <p>If your password still isn’t working, it’s time to 
                <a href="#" id="password_reset_show">reset your password</a>.</p>
            </div>
            <div class="md-card-content large-padding" id="login_password_reset" style="display: none">
                <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                <h2 class="heading_a uk-margin-large-bottom">Reset password</h2>
                <form>
                    <div class="uk-form-row">
                        <label for="login_email_reset">Your email address</label>
                        <input class="md-input" type="text" name="login_email_reset" />
                    </div>
                    <div class="uk-margin-medium-top">
                        <a href="index-2.html" class="md-btn md-btn-primary md-btn-block">Reset password</a>
                    </div>
                </form>
            </div>
            <div class="md-card-content large-padding" id="register_form" style="display: none">
                <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                <h2 class="heading_a uk-margin-medium-bottom">Create an account</h2>
                <form id="op-register-user" action="" method="POST">
                    <div class="uk-form-row">
                        <label for="register_username">Username</label>
                        <input class="md-input atl-required-js" type="text" name="register_username" />
                    </div>
                    <div class="uk-form-row">
                        <label for="register_password">Password</label>
                        <input class="md-input atl-required-js" type="password" name="register_password" />
                    </div>
                    <div class="uk-form-row">
                        <label for="register_password_repeat">Repeat Password</label>
                        <input class="md-input atl-required-js" type="password" name="register_password_repeat" />
                    </div>
                    <div class="uk-form-row">
                        <label for="register_email">E-mail</label>
                        <input class="md-input atl-required-js" type="email" name="register_email" />
                    </div>
                    <div class="uk-margin-medium-top">
                        <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="uk-margin-top uk-text-center">
            <a href="#" id="signup_form_show">Create an account</a>
        </div>
    </div>

    <?php  
        enqueueScripts(
            array(
                    'common'  => assets('assets/js/common.min.js'),
                    'altair_admin_common'  => assets('assets/js/altair_admin_common.min.js'),
                    'uikit_custom'  => assets('assets/js/uikit_custom.min.js'),
                    'login'  => assets('assets/js/pages/login.min.js'),
                    'jquery-ui'  => assets('bower_components/jquery-ui/jquery-ui.js'),
                    'underscore' => assets('bower_components/backbone/underscore.js'),
                    'backbone'   => assets('bower_components/backbone/backbone-min.js'),
                    'backend'   => assets('js/backend-scripts.min.js'),
                    'op-login' => assets('js/login-debug.js'),
                )
        );
        ?>

</body>
</html>