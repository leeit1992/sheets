<!-- <div class="md-fab-wrapper">
    <a class="md-fab md-fab-accent" href="#mailbox_new_message" data-uk-modal="{center:true}">
        <i class="material-icons">&#xE150;</i>
    </a>
</div> -->
<div class="uk-modal" id="mailbox_new_message">
    <div class="uk-modal-dialog">
        <button class="uk-modal-close uk-close" type="button"></button>
        <form id="op-form-messages">
            <div class="uk-modal-header">
                <h3 class="uk-modal-title">Send Message</h3>
            </div>
            <div class="uk-margin-medium-bottom">
                <label for="op_receiver">Send To</label>
                <select id="op_receiver" name="op_receiver" data-md-selectize>
                    <option value="">Select...</option>
                    <?php foreach ($mdUser->getAll() as $key => $value) {
                        if( 1 == $value['user_role'] && 2 == $userCurrent['meta']['user_role'] ){
                            echo '<option value="' . $value['id'] . '">' . $value['user_name'] . '</option>';
                        }
                        if( 1 == $value['user_role'] && 3 == $userCurrent['meta']['user_role'] ){
                            echo '<option value="' . $value['id'] . '">' . $value['user_name'] . '</option>';
                        }
                        if( 1 == $userCurrent['meta']['user_role'] ){
                            echo '<option value="' . $value['id'] . '">' . $value['user_name'] . '</option>';
                        }
                    } ?>
                </select>
            </div>
            <div class="uk-margin-large-bottom">
                <label for="mail_new_message">Title</label>
                <input name="op_title" class="md-input">
            </div>
            <div class="uk-margin-large-bottom">
                <label for="mail_new_message">Message</label>
                <textarea name="op_messages" cols="30" rows="6" class="md-input"></textarea>
            </div>

            <div class="uk-margin-medium-bottom op-list-sheet-select">
                <label for="op_sheet">Choose sheets</label>
                <select id="op_sheet" name="op_sheet" data-md-selectize>
                    <option value="">Select...</option>
                    <?php 
                    $dataListSheet = array();
                    foreach ($listSheets as $key => $value) {
                        $dataListSheet[] = [
                            'id' => $value['id'],
                            'sheet_title' => $value['sheet_title'],
                            'sheet_author' => $value['sheet_author'],
                            'sheet_status' => $value['sheet_status'],
                            'sheet_datetime' => $value['sheet_datetime'],
                        ];
                        echo '<option value="' . $value['id'] . '">' . $value['sheet_title'] . '</option>';
                    } ?>
                </select>
 
                <textarea id="op-data-list-sheets" style="display: none;"><?php echo json_encode($dataListSheet) ?></textarea>
            </div>
            
            <div class="uk-modal-footer">
                <button type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>
            </div>
        </form>
    </div>
</div>