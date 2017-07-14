<li>
    <div class="uk-margin-top">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-1">
                <label for="user_edit_uname_control">Email</label>
                <input class="md-input atl-required-js" type="email" name="atl_user_email" value="<?php echo isset( $user['user_email'] ) ? $user['user_email'] : '' ?>" />
            </div>
            <div class="uk-width-medium-1-2">
                
                <div class="md-input-wrapper <?php echo !empty( $user ) ? 'md-input-filled' : '' ?>">
                    <label for="user_edit_position_control">Password</label>
                    <input class="md-input atl-required-js" type="password" name="atl_user_pass" value="<?php echo isset( $user['user_password'] ) ? $user['user_password'] : '' ?>" />
                    <a href="#" class="uk-form-password-toggle" data-uk-form-password="">Show</a>
                    <span class="md-input-bar"></span>
                </div>
            </div>
            <div class="uk-width-medium-1-2">
                <div class="md-input-wrapper <?php echo !empty( $user ) ? 'md-input-filled' : '' ?>">
                    <label for="user_edit_position_control">Confirm password</label>
                    <input class="md-input atl-required-js" type="password" name="atl_user_cf_pass" value="<?php echo isset( $user['user_password'] ) ? $user['user_password'] : '' ?>" />
                    <a href="#" class="uk-form-password-toggle" data-uk-form-password="">Show</a>
                    <span class="md-input-bar"></span>
                </div>
            </div>
        </div>
    </div>  
</li>