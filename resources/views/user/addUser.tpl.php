<form action="#" class="uk-form-stacked" id="user_edit_form">
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-large-7-10">
            <div class="md-card">
                <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                    <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                            <img src="<?php echo assets('/assets/img/blank.png') ?>" alt="user avatar"/>
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div class="user_avatar_controls">
                            <span class="btn-file">
                                <span class="fileinput-new"><i class="material-icons">&#xE2C6;</i></span>
                                <span class="fileinput-exists"><i class="material-icons">&#xE86A;</i></span>
                                <input type="file" name="user_edit_avatar_control" id="user_edit_avatar_control">
                            </span>
                            <a href="#" class="btn-file fileinput-exists" data-dismiss="fileinput"><i class="material-icons">&#xE5CD;</i></a>
                        </div>
                    </div>
                    <div class="user_heading_content">
                        <h2 class="heading_b"><span class="uk-text-truncate" id="user_edit_uname">Leilani McCullough</span><span class="sub-heading" id="user_edit_position">Land acquisition specialist</span></h2>
                    </div>
                    <button type="submit" class="md-fab md-fab-small md-fab-success" id="user_edit_submit">
                        <i class="material-icons">&#xE161;</i>
                    </button>
                </div>
                <div class="user_content">
                    <ul id="user_edit_tabs" class="uk-tab" data-uk-tab="{connect:'#user_edit_tabs_content'}">
                        <li class="uk-active"><a href="#">Basic</a></li>
                        <li><a href="#">Account</a></li>
                        <li><a href="#">Role</a></li>
                    </ul>
                    <ul id="user_edit_tabs_content" class="uk-switcher uk-margin">
                        <li>
                            <div class="uk-margin-top">
                                <h3 class="full_width_in_card heading_c">
                                    General info
                                </h3>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-2">
                                        <label for="user_edit_uname_control">User name</label>
                                        <input class="md-input" type="text" id="user_edit_uname_control" name="user_edit_uname_control" />
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

                                <h3 class="full_width_in_card heading_c">
                                    Contact info
                                </h3>
                                <div class="uk-grid">
                                    <div class="uk-width-1-1">
                                        <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2" data-uk-grid-margin>
                                            <div>
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                                    </span>
                                                    <label>Email</label>
                                                    <input type="text" class="md-input" name="user_edit_email" value="aleen96@gmail.com" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="md-list-addon-icon material-icons">&#xE0CD;</i>
                                                    </span>
                                                    <label>Phone Number</label>
                                                    <input type="text" class="md-input" name="user_edit_phone" value="668-737-9537" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="md-list-addon-icon uk-icon-facebook-official"></i>
                                                    </span>
                                                    <label>Facebook</label>
                                                    <input type="text" class="md-input" name="user_edit_facebook" value="facebook.com/envato" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="md-list-addon-icon uk-icon-twitter"></i>
                                                    </span>
                                                    <label>Twitter</label>
                                                    <input type="text" class="md-input" name="user_edit_twitter" value="twitter.com/envato" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="md-list-addon-icon uk-icon-linkedin"></i>
                                                    </span>
                                                    <label>Linkdin</label>
                                                    <input type="text" class="md-input" name="user_edit_linkdin" value="linkedin.com/company/envato" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="md-list-addon-icon uk-icon-google-plus"></i>
                                                    </span>
                                                    <label>Google+</label>
                                                    <input type="text" class="md-input" name="user_edit_google_plus" value="plus.google.com/+envato/about" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
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
                        <li>
                            <?php 
                                $module = [
                                    [ 'name' => 'Module Tour' ],
                                    [ 'name' => 'Module Booking' ],
                                    [ 'name' => 'Module User' ],
                                    [ 'name' => 'Module Setting' ],
                                ];
                            ?>
                            <ul class="md-list md-list-addon">
                                <li>
                                    <div class="md-list-addon-element">
                                        <input type="checkbox" data-md-icheck/>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Read</span>
                                        <span class="uk-text-small uk-text-muted">Amet sunt voluptatem dignissimos commodi quo velit magnam.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <input type="checkbox" data-md-icheck/>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Write</span>
                                        <span class="uk-text-small uk-text-muted">Amet sunt voluptatem dignissimos commodi quo velit magnam.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <input type="checkbox" data-md-icheck/>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Only Read</span>
                                        <span class="uk-text-small uk-text-muted">Amet sunt voluptatem dignissimos commodi quo velit magnam.</span>
                                    </div>
                                </li>
                            </ul>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="uk-width-large-3-10">
            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_c uk-margin-medium-bottom">Other settings</h3>
                    <div class="uk-form-row">
                        <input type="checkbox" checked data-switchery id="user_edit_active" />
                        <label for="user_edit_active" class="inline-label">User Active</label>
                    </div>
                    <hr class="md-hr">
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="user_edit_role">User Role</label>
                        <select data-md-selectize>
                            <option value="">Select...</option>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="editor" selected>Editor</option>
                            <option value="author">Author</option>
                            <option value="none">None</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>