<div id="op-page-handle-massages">
    <div id="top_bar">
        <div class="md-top-bar">
            <div class="uk-width-large-8-10 uk-container-center">
                <div class="uk-clearfix">
                    <div class="md-top-bar-actions-left">
                        <div class="md-top-bar-checkbox">
                            <input type="checkbox" name="mailbox_select_all" id="mailbox_select_all" data-md-icheck />
                        </div>
                    </div>
                    <div class="md-top-bar-actions-right">
                        <div class="md-card-list-item-menu"  data-uk-dropdown="{mode:'click'}">
                            <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                            <div class="uk-dropdown uk-dropdown-flip uk-dropdown-small">
                                <ul class="uk-nav">
                                    <li><a class="op-remove-all-mes" data-rm="send" href="#"><i class="material-icons">&#xE872;</i> Delete All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="md-card-list-wrapper" id="mailbox">
        <div class="uk-width-large-8-10 uk-container-center">
            <?php View('messages/layout/filter.tpl', [ 'mdUser' => $mdUser, 'listSheets' => $listSheets, 'type' => 'send' ]) ?>
            <div class="md-card-list">
                <div class="md-card-list-header heading_list">All Messages</div>
                <ul class="op-list-current hierarchical_slide">
                    <?php 
                    foreach ($listMessages as $value) :
                        $user = $mdUser->getUserBy('id', $value['op_user_send']);
                    ?>
                    <li class="op-mes-item-<?php echo $value['id'] ?>">
                        <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click'}">
                            <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                            <div class="uk-dropdown uk-dropdown-flip uk-dropdown-small">
                                <ul class="uk-nav">
                                    <li><a class="op-massages-rm-js" href="#" data-rm="send" data-id="<?php echo $value['id'] ?>"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <span class="md-card-list-item-date"><?php echo date('d M',strtotime($value['op_datetime'])) ?></span>
                        <div class="md-card-list-item-select">
                            <input type="checkbox" class="op-message-check" value="<?php echo $value['id'] ?>" data-md-icheck />
                        </div>
                        <div class="md-card-list-item-avatar-wrapper">
                            <span class="md-card-list-item-avatar md-bg-gray">Mes</span>
                        </div>
                        <div class="md-card-list-item-sender">
                            <span>
                               Me
                            </span>
                        </div>
                        <div class="md-card-list-item-subject">
                            <span>
                                <a href="#" data-uk-modal="{target:'#modal_message_<?php echo $value['id'] ?>'}">
                                    <?php echo ucfirst($value['op_message_title']) ?>
                                </a>
                            </span>   
                        </div>
                        <div class="uk-modal" id="modal_message_<?php echo $value['id'] ?>">
                            <div class="uk-modal-dialog">
                                <div class="uk-modal-header">
                                    <h3 class="uk-modal-title">Content</h3>
                                </div>
                                <p><?php echo $value['op_messages'] ?></p>
                                <div class="uk-modal-footer uk-text-right">
                                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="op-list-result"></ul>
            </div> 
        </div>
        <?php View('messages/layout/popinSend.tpl', [ 'mdUser' => $mdUser, 'listSheets' => $listSheets ]) ?>
    </div>
    <div class="uk-notify uk-notify-bottom-right op-notify-js" style="display: none;"></div>
</div>
<?php
registerScrips([
    'rangeSlider' => assets('bower_components/ion.rangeslider/js/ion.rangeSlider.min.js'),
    'inputmask' => assets('bower_components/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js'),
    'forms_advanced' => assets('assets/js/pages/forms_advanced.min.js'),
    'op-massages' => assets('js/messages-debug.js'),
]);
