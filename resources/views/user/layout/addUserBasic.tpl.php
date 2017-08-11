<?php 
$userCode = '';
$inputDis = '';
if( !empty($user) ) {
    if( isset( $user['user_code'] ) ) {
        $userCode = explode('-',$user['user_code']);
        $userCode = $userCode[1];
    }
    
    $inputDis = 'readonly';
}

?>
<li>
    <div class="uk-margin-top">
        <h3 class="full_width_in_card heading_c">
            General info
        </h3>
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-2">
                <label>User name</label>
                <input class="md-input" type="text" name="atl_user_name" value="<?php echo isset( $user['user_name'] ) ? $user['user_name'] : '' ?>" />
            </div>
            <div class="uk-width-medium-1-2">
                <div class="uk-input-group">
                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                    <div class="md-input-wrapper <?php echo isset( $meta['user_birthday'] ) ? 'md-input-filled' : '' ?>">
                        <label>Birthday</label>
                        <input class="md-input" type="text" name="atl_user_birthday" data-uk-datepicker="{format:'DD.MM.YYYY'}" value="<?php echo isset( $meta['user_birthday'] ) ? $meta['user_birthday'] : '' ?>">
                        <span class="md-input-bar"></span>
                    </div>
                </div>
            </div>

        </div>
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <label>More information</label>
                <textarea class="md-input" name="atl_user_moreinfo" cols="30" rows="4"><?php echo isset( $meta['user_moreinfo'] ) ? $meta['user_moreinfo'] : '' ?></textarea>
            </div>
        </div>

        <div class="uk-grid">
            <div class="uk-width-1-2">
                <label>User Code</label>
                <input <?php echo $inputDis ?> type="text" class="md-input input-count atl-required-js" value="<?php echo $userCode ?>" name="atl_user_code" style="text-transform: uppercase" maxlength="3" />
            </div>
            <div class="uk-width-1-2">
                <label>User Color</label>
                <input type="text" <?php echo $inputDis ?> name="atl_user_color" value="<?php echo isset( $user['user_color'] ) ? $user['user_color'] : '' ?>" class="op-user-color" />
            </div>
        </div>
  
        <h3 class="full_width_in_card heading_c">
            Contact info
        </h3>
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2" data-uk-grid-margin>
                    <div>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">
                                <i class="md-list-addon-icon material-icons material-icons">home</i>
                            </span>
                            <label>Address</label>
                            <input type="text" class="md-input" name="atl_user_address" value="<?php echo isset( $meta['user_address'] ) ? $meta['user_address'] : '' ?>" />
                        </div>
                    </div>
                    <div>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">
                                <i class="md-list-addon-icon material-icons">&#xE0CD;</i>
                            </span>
                            <label>Phone Number</label>
                            <input type="text" class="md-input" name="atl_user_phone" value="<?php echo isset( $meta['user_phone'] ) ? $meta['user_phone'] : '' ?>" />
                        </div>
                    </div>
                    <div>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">
                                <i class="md-list-addon-icon uk-icon-facebook-official"></i>
                            </span>
                            <label>Facebook</label>
                            <input type="text" class="md-input" name="atl_user_social[fb]" value="<?php echo isset( $social['fb'] ) ? $social['fb'] : '' ?>" />
                        </div>
                    </div>
                    <div>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">
                                <i class="md-list-addon-icon uk-icon-twitter"></i>
                            </span>
                            <label>Twitter</label>
                            <input type="text" class="md-input" name="atl_user_social[twitter]" value="<?php echo isset( $social['twitter'] ) ? $social['twitter'] : '' ?>" />
                        </div>
                    </div>
                    <div>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">
                                <i class="md-list-addon-icon uk-icon-linkedin"></i>
                            </span>
                            <label>Linkdin</label>
                            <input type="text" class="md-input" name="atl_user_social[linkedin]"  value="<?php echo isset( $social['linkedin'] ) ? $social['linkedin'] : '' ?>" />
                        </div>
                    </div>
                    <div>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">
                                <i class="md-list-addon-icon uk-icon-google-plus"></i>
                            </span>
                            <label>Google+</label>
                            <input type="text" class="md-input" name="atl_user_social[gplus]" value="<?php echo isset( $social['gplus'] ) ? $social['gplus'] : '' ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>