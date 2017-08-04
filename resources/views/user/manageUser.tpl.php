<div id="atl-page-handle-user">
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <h3 class="heading_a uk-margin-bottom">Users Management</h3>
            
            <?php View('user/layout/manageUserFilter.tpl', [ 'mdUser' => $mdUser ]); ?>
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
                        <?php foreach ($listUser as $value): ?>
                        <tr class="atl-user-item-<?php echo $value['id'] ?>">
                            <td class="uk-text-center">
                                <input type="checkbox" class="atl-checkbox-child-js" value="<?php echo $value['id'] ?>" />
                            </td>
                            <td class="uk-text-center">
                            <?php
                                $avatar = $mdUser->getMetaData( $value['id'], 'user_avatar' );
                            ?>
                                <img class="md-user-image" style="height: 34px;" src="<?php echo !empty($avatar) ? url($avatar): assets('img/user.png') ; ?>">
                            </td>
                            <td>
                                <?php echo $value['user_email'] ?>
                            </td>
                            <td class="uk-text-center">
                                <span class="uk-badge <?php echo (1 == $mdUser->getMetaData( $value['id'], 'user_role' ) ? 'uk-badge-danger': '') ?>">
                                    <?php echo $mdUser->getRoleUser( $mdUser->getMetaData( $value['id'], 'user_role' ) ) ?>
                                </span>
                            </td>
                           
                            <td class="uk-text-center">
                                <a href="<?php echo url('/edit-user/' . $value['id']) ?>">
                                    <i class="md-icon material-icons">edit</i>
                                </a>
                                <a href="#" class="atl-manage-user-delete-js" data-id="<?php echo $value['id'] ?>">
                                    <i class="md-icon material-icons">delete</i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tbody class="atl-list-user-js"></tbody>
                </table>
            </div>
            <br>

            <?php View('user/layout/manageUserAction.tpl'); ?>
            <?php echo $pagination; ?>

        </div>
        <?php View('user/layout/addUserButton.tpl'); ?>
    </div>  
</div>

<?php 
registerScrips( array(
    'page-admin-user' => assets('js/page-admin-user.min.js'),
) );