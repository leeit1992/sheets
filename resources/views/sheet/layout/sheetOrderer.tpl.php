<style type="text/css">
.uk-datepicker {
    z-index: 9999;
}
</style>

<div class="uk-modal uk-open" id="op_sheet_order" aria-hidden="false" style="display: none; overflow-y: auto;">
    <div class="uk-modal-dialog" style="top: 116px;">
        <button class="uk-modal-close uk-close" type="button"></button>
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Add Orderer</h3>
        </div>
        <div class="uk-modal-content uk-margin-top">  
            <div class="uk-grid uk-margin-top">
                <div class="uk-width-large-1-1">
                    <p>
                        <select id="op_sheet_add_order" data-md-selectize>
                            <option value=""> Choose Orderer </option>
                            <?php foreach ($mdUser->getAll() as $key => $value) {
                                if( 3 == $value['user_role'] ){
                                    echo '<option value="' . $value['id'] . '">' . $value['user_name'] . ' ( ' . $value['user_email'] . ' )' . '</option>';
                                }
                            } ?>
                        </select>
                    </p>
                    <?php foreach ($mdUser->getAll() as $key => $value) {
                        if( 3 == $value['user_role'] ){

                            $avatar = assets('img/user.png');
                            if( isset( $value['user_avatar'] ) ) {
                                $avatar = url($value['user_avatar']);
                            }

                            ?>
                            <textarea style="display: none;" name="op_orderer_<?php echo $value['id'] ?>"><?php echo json_encode($value) ?></textarea>
                            <div style="display: none;" class="md-card op_orderer_list op_orderer_<?php echo $value['id'] ?>">
                                <div class="md-card-head" style="background: <?php echo $value['user_color'] ?>">
                                    <div class="md-card-head-menu" data-uk-dropdown>
                                        <i class="md-icon material-icons md-icon-light">&#xE5D4;</i>
                                        <div class="uk-dropdown uk-dropdown-small uk-dropdown-flip">
                                            <ul class="uk-nav">
                                                <li><a href="<?php echo url('/edit-user/'. $value['id']) ?>">User profile</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="uk-text-center">
                                        <img class="md-card-head-avatar" src="<?php echo $avatar ?>" alt=""/>
                                    </div>
                                    <h3 class="md-card-head-text uk-text-center md-color-white">
                                        <?php echo ucfirst($value['user_name']) ?>                              
                                    </h3>
                                </div>
                                <div class="md-card-content">
                                    <ul class="md-list md-list-addon">
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="uk-text-small uk-text-muted"><?php echo $value['user_email'] ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="md-list-addon-icon material-icons">&#xE0CD;</i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><?php echo $value['user_phone'] ?></span>
                                                <span class="uk-text-small uk-text-muted">Phone</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        }
                    } ?>
                    
                </div>
            </div>          
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat md-btn-flat-primary op-apply-orderer">Apply</button>
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>