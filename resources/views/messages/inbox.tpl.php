<?php 
    if( isset($_GET['inbox']) ) {
        echo '<input type="hidden" name="op_inbox_auto_open" value="'.$_GET['inbox'].'">';
    }
?>
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
                                    <li><a class="op-remove-all-mes" data-rm="inbox" href="#"><i class="material-icons">&#xE872;</i> Delete All </a></li>
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
            <?php View('messages/layout/filter.tpl', [ 'mdUser' => $mdUser, 'listSheets' => $listSheets, 'type' => $pageType, 'userCurrent' => $userCurrent ]) ?>
            <div class="md-card-list">
                <div class="md-card-list-header heading_list">All Messages</div>
                <ul class="op-list-current hierarchical_slide">
                    <?php 
                    foreach ($listMessages as $value) :
                        $user = $mdUser->getUserBy('id', $value['op_user_send']);
                        $avatar = assets('img/user.png');
                        if( isset( $user[0]['user_avatar'] ) ) {
                            $avatar = url($user[0]['user_avatar']);
                        }
                    ?>
                    <li class="op-mes-item-<?php echo $value['id'] ?>">
                        <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click'}">
                            <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                            <div class="uk-dropdown uk-dropdown-flip uk-dropdown-small">
                                <ul class="uk-nav">
                                    <li><a class="op-massages-rm-js" href="#" data-rm="inbox" data-id="<?php echo $value['id'] ?>"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <span class="md-card-list-item-date"><?php echo date('d M',strtotime($value['op_datetime'])) ?></span>
                        <div class="md-card-list-item-select">
                            <input type="checkbox" class="op-message-check" value="<?php echo $value['id'] ?>" data-md-icheck />
                        </div>
                        <div class="md-card-list-item-avatar-wrapper">
                            <?php
                                $classNotice = 'md-bg-gray';
                                if( 1 == $value['op_status'] ){
                                    $classNotice = 'md-bg-light-blue';
                                }
                            ?>
                            <a href="#" class="md-card-list-item-avatar user_action_image <?php echo $classNotice  ?>">
                                <img class="md-user-image" style="height: 34px;" src="<?php echo $avatar ?>" alt="">
                            </a>
                        </div>
                        <div class="md-card-list-item-sender">
                            <span>
                                <?php 
                                    if( isset( $user[0] ) ) {
                                        echo $user[0]['user_name'];
                                    }
                                ?>
                            </span>
                        </div>
                       
                        <div class="md-card-list-item-subject" style="width: 16%;display: inline-block;float: left;">
                            <span>
                                <?php
                                    $link = '<span><a class="op-check-message" data-status="'.$value['op_status'].'" data-id="'.$value['id'].'" data-type="inbox" data-uk-modal="{target:\'#modal_message_'.$value['id'].'\'}" href="#">' . ucfirst($value['op_message_title']) .'</a></span>';
                                    if( 1 == $value['op_status'] ){
                                        echo '<strong style="">' . $link . '</strong>';
                                    }else{
                                        echo $link;
                                    }
                                ?> 
                            </span>   
                        </div>

                        <div class="md-card-list-item-status" style="display: inline-block;padding-top: 8px;">
                            
                            <?php
                                if( 1 == $value['op_status'] ){
                                    echo '<span class="uk-badge uk-badge-warning">Waiting</span>';
                                }
                           
                                if( 3 == $value['op_status'] ){
                                    echo '<span class="uk-badge uk-badge-success">Accept</span>';
                                }
                                if( 4 == $value['op_status'] ){
                                    echo '<span class="uk-badge uk-badge-danger">Cancel</span>';
                                }
                            ?> 
                            
                        </div>

                        <div class="uk-modal" id="modal_message_<?php echo $value['id'] ?>">
                            <div class="uk-modal-dialog op-inbox-sheet-wrap" style="width: 100%;">
                                <button class="uk-modal-close uk-close" type="button"></button>
                                <div class="uk-modal-header">
                                    <h3 class="uk-modal-title"><i class="material-icons md-24">&#xE554;</i> <?php echo ucfirst($value['op_message_title']) ?></h3>
                                </div>
                                <p><?php echo $value['op_messages'] ?></p>
                                <div class="uk-width-large-1-1">
                                    <textarea class="op-data-mes-<?php echo $value['id'] ?>" style="display: none;"><?php echo $value['op_data_sheet'] ?></textarea>
                                    <textarea class="op-meta-mes-<?php echo $value['id'] ?>" style="display: none;"><?php echo $value['op_data_sheet_meta'] ?></textarea>
                                    <div class="op-sheet-inbox-show-<?php echo $value['id'] ?>"></div>
                                </div>
                                <div class="uk-modal-footer uk-text-right">
                                <?php if( 'inbox' == $pageType ) : ?>
                                    <?php if( 1 == $userCurrent['meta']['user_role'] || 3 == $userCurrent['meta']['user_role']) : ?>
                                   
                                    <?php if( 4 != $value['op_status'] ) : ?>
                                    <a apccet-status="<?php echo $value['op_accept_status'] ?>" data-id="<?php echo $value['id'] ?>" user-send-id="<?php echo $value['op_user_send'] ?>" class="md-btn md-btn-flat op-massage-accept" href="#op-massage-accept" data-uk-modal="{center:true}">Accept </a>
                                    <?php endif; ?>

                                    <?php if( 1 != $value['op_accept_status'] && 4 != $value['op_status'] && 3 != $userCurrent['meta']['user_role'] ) : ?>
                                    <a data-id="<?php echo $value['id'] ?>" user-send="<?php echo $value['op_user_send'] ?>" class="md-btn md-btn-flat op-massage-cancel"> Cancel Order </a>
                                    <?php endif; ?>

                                    <a class="md-btn md-btn-flat uk-modal-close"> Close </a>
                                    <?php endif; ?>
                    
                                <?php endif; ?> 
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="op-list-result"></ul>
            </div> 
        </div>
        <?php if( 1 == $userCurrent['meta']['user_role'] || 3 == $userCurrent['meta']['user_role'] ) : ?>
        <?php View('messages/layout/popinAcceptOrder.tpl', [ 'listSheets' => $listSheets, 'listSheetsOther' => $listSheetsOther, 'pageType' => $pageType, 'userCurrent' => $userCurrent, 'listSheetsOther' => $listSheetsOther ]) ?>
        <?php View('messages/layout/popinSend.tpl', [ 'userCurrent' => $userCurrent, 'mdUser' => $mdUser, 'listSheets' => $listSheets ]) ?>
        <?php endif; ?>
    </div>
    <div class="uk-notify uk-notify-bottom-right op-notify-js" style="display: none;"></div>
</div>
<?php
registerScrips([
    'handsontable' => assets('bower_components/handsontable/handsontable.full.min.js'),
    'op-massages' => assets('js/messages-debug.js'),
    'rangeSlider' => assets('bower_components/ion.rangeslider/js/ion.rangeSlider.min.js'),
    'inputmask' => assets('bower_components/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js'),
    'forms_advanced' => assets('assets/js/pages/forms_advanced.min.js'),
]);
