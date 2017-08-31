<style type="text/css">
.uk-datepicker {
    z-index: 9999;
}
</style>

<div class="uk-modal" id="op_sheet_share" aria-hidden="true">
    <div class="uk-modal-dialog" style="top: 116px;">
        <button class="uk-modal-close uk-close" type="button"></button>
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Share sheet</h3>
        </div>
        <div class="uk-modal-content uk-margin-top">  
            <div class="uk-grid uk-margin-top">
                <div class="uk-width-large-1-1">
                    <p>
                        <select id="op_sheet_share_list" multiple="multiple" data-md-selectize>
                            <option value=""> Choose Member </option>
                            <?php foreach ($mdUser->getAll() as $key => $value) {

                                $select = '';
                                if( !empty( $sheet[0]['sheet_share'] ) ) {

                                    $checkSheetShare = json_decode($sheet[0]['sheet_share']);

                                    if( in_array($value['id'], $checkSheetShare ) ) {
                                        $select = 'selected="selected"';
                                    }

                                }
                                echo '<option '.$select.' value="' . $value['id'] . '">' . $value['user_name'] . ' ( ' . $value['user_email'] . ' )' . '</option>';
                                
                            } ?>
                        </select>
                    </p>
                </div>
            </div>          
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat md-btn-flat-primary op-apply-share-sheet">Apply</button>
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>