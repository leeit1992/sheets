<div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new thumbnail">
            <img src="<?php echo !empty( $meta['user_avatar'] ) ? url($meta['user_avatar']) : assets('backend/assets/img/user.png') ?>" class="atl-user-avatar-js" alt="user avatar"/>
        </div>     
        <div class="user_avatar_controls">
            <span class="btn-file">
                <span class="fileinput-new"><i class="material-icons">&#xE2C6;</i></span>
                <span class="fileinput-exists"><i class="material-icons">&#xE86A;</i></span>
                <input type="file" name="atl_user_avatar" onchange="ATLLIB.fileReader(event, '.atl-user-avatar-js')">
            </span>
            <a href="#" class="btn-file fileinput-exists" data-dismiss="fileinput"><i class="material-icons">&#xE5CD;</i></a>
        </div>
    </div>
    <div class="user_heading_content">
        <h2 class="heading_b">
            <span class="uk-text-truncate"><?php echo $actionName; ?></span>
            <span class="sub-heading">
            <?php 
                if( isset( $meta['user_role'] ) ) {
                    echo $mdUser->getRoleUser( $meta['user_role'] );
                }
            ?> 
            </span>
        </h2>
    </div>
    <button type="submit" class="md-fab md-fab-small md-fab-success">
        <i class="material-icons">save</i>
    </button>
</div>