<?php 
foreach ($listMessages as $value) :
    $user = $mdUser->getUserBy('id', $value['op_user_send']);
?>
<li class="op-mes-item-<?php echo $value['id'] ?>">
    <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click'}">
        <a href="#" class="md-icon material-icons">&#xE5D4;</a>
        <div class="uk-dropdown uk-dropdown-flip uk-dropdown-small">
            <ul class="uk-nav">
                <li><a class="op-massages-rm-js" href="#" data-rm="<?php echo $typeMes ?>" data-id="<?php echo $value['id'] ?>"><i class="material-icons">&#xE872;</i> Delete</a></li>
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
            if( 1 == $value['op_status'] && 'inbox' == $typeMes){
                $classNotice = 'md-bg-light-blue';
            }
        ?>
        <span class="md-card-list-item-avatar <?php echo $classNotice ?>">Mes</span>
    </div>
    <div class="md-card-list-item-sender">
        <span>
           <?php 
                if( isset( $user[0]) && 'inbox' == $typeMes ) {
                    echo $user[0]['user_name'];
                }else{
                    echo 'Me';
                }
            ?>
        </span>
    </div>
    <div class="md-card-list-item-subject">
        <span>
             <?php
                $link = '<span><a class="op-check-message" data-id="'.$value['id'].'" data-uk-modal="{target:\'#modal_message_js_'.$value['id'].'\'}" href="#">' . ucfirst($value['op_message_title']) .'</a></span>';
                
                if( 1 == $value['op_status'] && 'inbox' == $typeMes ){
                    echo '<strong style="">' . $link . '</strong>';
                }else{
                    echo $link;
                }
            ?> 
         
        </span>   
    </div>
    <div class="uk-modal" id="modal_message_js_<?php echo $value['id'] ?>">
        <div class="uk-modal-dialog">
            <div class="uk-modal-header">
                <h3 class="uk-modal-title"><i class="material-icons md-24">&#xE554;</i> Messages</h3>
            </div>
            <p><?php echo $value['op_messages'] ?></p>
            <div>
                <p><i class="uk-icon-file-excel-o"></i> <a target="_blank" href="<?php echo url('/view-sheet/' . $value['op_sheet_id']) ?>">File Sheet</a></p>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <?php if( 'inbox' == $typeMes ){ ?>
                <textarea class="op-data-mes-<?php echo $value['id'] ?>" style="display: none;"><?php echo json_encode($value) ?></textarea>
                <a data-id="<?php echo $value['id'] ?>" class="md-btn md-btn-flat op-massage-forward" href="#mailbox_new_message" data-uk-modal="{center:true}">Forward </a>
                <?php } ?>                            
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
            </div>
        </div>
    </div>
</li>
<?php endforeach; ?>
