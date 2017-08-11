<li data-uk-dropdown="{mode:'click'}">
    <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i><span class=" op-number-notice uk-badge"><?php echo count($listMessages) ?></span></a>
    <div class="uk-dropdown uk-dropdown-xlarge uk-dropdown-flip">
        <div class="md-card-content">
            <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                <li class="uk-width-1-1 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Messages (<?php echo count($listMessages) ?>)</a></li>
            </ul>
            <ul id="header_alerts" class="uk-switcher uk-margin">
                <li>
                    <ul class="md-list md-list-addon op-list-notice-box">
                        <?php 
                            foreach ($listMessages as $key => $value) : 
                            $user = $mdUser->getUserBy('id', $value['op_user_send']);

                            $avatar = assets('img/user.png');
                            if( isset( $user[0]['user_avatar'] ) ) {
                                $avatar = url($user[0]['user_avatar']);
                            }
                        ?>
                        <li>
                            <div class="md-list-addon-element">
                                <a href="#" class="user_action_image">
                                    <img class="md-user-image" style="height: 34px;" src="<?php echo $avatar ?>" alt="">
                                </a>
                            </div>
                            <div class="md-list-content">
                                <a class="op-check-message" data-id="<?php echo $value['id'] ?>" data-uk-modal="{target:'#modal_message_head_<?php echo $value['id'] ?>'}" href="#">
                                    <span class="md-list-heading"><?php echo isset($user[0]) ? $user[0]['user_name'] : '' ?>.</span>
                                    <span class="uk-text-small uk-text-muted"><?php echo $value['op_message_title'] ?>.</span>
                                </a>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="uk-text-center uk-margin-top uk-margin-small-bottom">
                        <a href="<?php echo url('/massages-manage') ?>" class="md-btn md-btn-flat md-btn-flat-primary js-uk-prevent">Show All</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</li>
