<div id="atl-page-handle-logs">
    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-2-10">
                    <label> Date </label>
                    <input type="text" class="md-input op-log-filter" data-type='date' data-uk-datepicker="{format:'DD.MM.YYYY'}">
                </div>
                
                <div class="uk-width-medium-2-10">
                    <select class="op-log-filter" data-type='user' data-md-selectize>
                        <option value="">User Logs</option>
                        <?php foreach ($mdUser->getAll() as $key => $value) {
                            echo '<option value="' . $value['id'] . '">' . $value['user_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>              
            </div>
        </div>
    </div>
    <div class="uk-width-medium-1-1">
        <a class="md-btn md-btn-flat op-clear-log" href="#"><i class="material-icons md-24">&#xE872;</i> Clear log</a>
    </div>
    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">
                    <div class="uk-overflow-container">
                        <table class="uk-table">
                            <thead>
                                <tr>
                                    <th>Log Content</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="op-logs-items">
                                <?php foreach ($listLogs as $value) : ?>
                                <tr class="op-log-item-<?php echo $value['id'] ?>">
                                    <td><?php echo $value['logs'] ?></td>
                                    <td class="uk-text-nowrap">
                                        <a class="op-remove-log" data-id="<?php echo $value['id'] ?>" href="#"><i class="material-icons md-24">&#xE872;</i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
registerScrips([
    'logs'   => assets('js/logs-debug.js'),
]);