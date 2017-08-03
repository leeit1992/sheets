<li data-uk-dropdown="{mode:'click'}">
    <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i><span class="uk-badge"><?php echo count($listMessages) ?></span></a>
    <div class="uk-dropdown uk-dropdown-xlarge uk-dropdown-flip">
        <div class="md-card-content">
            <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                <li class="uk-width-1-1 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Messages (<?php echo count($listMessages) ?>)</a></li>
            </ul>
            <ul id="header_alerts" class="uk-switcher uk-margin">
                <li>
                    <ul class="md-list md-list-addon">
                        <?php foreach ($listMessages as $key => $value) : ?>
                        <li>
                            <div class="md-list-addon-element">
                                <span class="md-user-letters md-bg-cyan">nq</span>
                            </div>
                            <div class="md-list-content">
                                <span class="md-list-heading"><a class="op-check-message" data-uk-modal="{target:'#modal_message_<?php echo $value['id'] ?>'}" href="#"><?php echo $value['op_user_send'] ?>.</a></span>
                                <span class="uk-text-small uk-text-muted"><?php echo $value['op_message_title'] ?>.</span>
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