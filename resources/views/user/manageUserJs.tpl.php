<?php foreach ($users as $user) : ?>
<tr class="atl-user-item-<?php echo $user['id'] ?>">
    <td class="uk-text-center">
        <input type="checkbox" class="atl-checkbox-child-js" value="<?php echo $user['id'] ?>" />
    </td>
    <td class="uk-text-center">
        <?php
            $avatar = $mdUser->getMetaData( $user['id'], 'user_avatar' );
        ?>
        <img class="md-user-image" style="height: 34px;" src="<?php echo !empty($avatar) ? url($avatar): assets('img/user.png') ; ?>">
    </td>
    <td><?php echo $user['user_email'] ?></td>
    <td class="uk-text-center">
        <span class="uk-badge <?php echo (1 == $user['user_role'] ) ? 'uk-badge-danger': '' ?>">
            <?php echo $mdUser->getRoleUser( $user['user_role']) ?>
        </span>
    </td>
    <td class="uk-text-center">
        <a href="<?php echo url('/edit-user/' . $user['id']) ?>">
            <i class="md-icon material-icons">&#xE254;</i>
        </a>
        <a href="#" class="atl-manage-user-delete-js" data-id="<?php echo $user['id'] ?>">
            <i class="md-icon material-icons">&#xE872;</i>
        </a>
    </td>
</tr>
<?php endforeach; ?>