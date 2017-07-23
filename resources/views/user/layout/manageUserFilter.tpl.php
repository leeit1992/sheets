<div class="uk-grid">
    <div class="uk-width-medium-2-3">
        <div class="uk-vertical-align">
            <div class="uk-vertical-align-middle">
                <ul class="uk-subnav uk-subnav-pill atl-manage-user-filter-js">
                    <li class="uk-active">
                        <a href="<?php echo url( '/manage-user' ) ?>">All</a>
                    </li>
                    <?php foreach ($mdUser->getRoleUser() as $key => $value) {
                        echo '<li><a data-role="' . $key . '" href="' . url( '/manage-user?role=' .$key ) . '">' . $value . '</a></li>';
                    } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="uk-input-group">
            <span class="uk-input-group-addon">
                <i class="md-list-addon-icon material-icons material-icons">search</i>
            </span>
            <div class="md-input-wrapper"><label>Search</label><input type="text" class="md-input atl-user-manage-search-js" name="atl_user_address" value=""><span class="md-input-bar"></span></div>
        </div>
    </div>
</div>