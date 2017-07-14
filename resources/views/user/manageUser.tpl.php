<div id="atl-page-handle-user">
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <h3 class="heading_a uk-margin-bottom">Users Management</h3>
            
            <?php View('user/layout/manageUserFilter.tpl' ); ?>
            <br>
            <?php View('user/layout/manageUserAction.tpl'); ?>
            <br>
            <div class="uk-overflow-container">
                <table class="uk-table uk-table-hover">
                    <thead>
                    <tr>
                        <th class="uk-text-center">
                            <input type="checkbox" class="atl-checkbox-primary-js" />
                        </th>
                        <th class="uk-text-center"> 
                            Avatar 
                        </th>
                        <th class="uk-width-2-5">Email</th>
                        <th class="uk-width-1-5 uk-text-center">Role</th>
                        <th class="uk-width-2-5 uk-text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="atl-list-user-not-js">
                       
                        <tr class="atl-user-item-1">
                            <td class="uk-text-center">
                                <input type="checkbox" class="atl-checkbox-child-js" value="" />
                            </td>
                            <td class="uk-text-center">
                                Administrator
                                <img class="md-user-image" style="height: 34px;" src="<?php echo assets('/assets/img/blank.png') ?>">
                            </td>
                            <td>
                                admin@gmail.com
                            </td>
                            <td class="uk-text-center">
                                <span class="uk-badge uk-badge-danger">
                                    Administrator
                                </span>
                            </td>
                           
                            <td class="uk-text-center">
                                <a href="#">
                                    <i class="md-icon material-icons">edit</i>
                                </a>
                                <a href="#" class="atl-manage-user-delete-js" data-id="#">
                                    <i class="md-icon material-icons">delete</i>
                                </a>
                            </td>
                        </tr>
                        <tr class="atl-user-item-1">
                            <td class="uk-text-center">
                                <input type="checkbox" class="atl-checkbox-child-js" value="" />
                            </td>
                            <td class="uk-text-center">
                                Administrator
                                <img class="md-user-image" style="height: 34px;" src="<?php echo assets('/assets/img/blank.png') ?>">
                            </td>
                            <td>
                                admin@gmail.com
                            </td>
                            <td class="uk-text-center">
                                <span class="uk-badge uk-badge-success">
                                    Editor
                                </span>
                            </td>
                           
                            <td class="uk-text-center">
                                <a href="#">
                                    <i class="md-icon material-icons">edit</i>
                                </a>
                                <a href="#" class="atl-manage-user-delete-js" data-id="#">
                                    <i class="md-icon material-icons">delete</i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="atl-list-user-js"></tbody>
                </table>
            </div>
            <br>

            <?php View('user/layout/manageUserAction.tpl'); ?>

        </div>
        <?php View('user/layout/addUserButton.tpl'); ?>
    </div>  
</div>
