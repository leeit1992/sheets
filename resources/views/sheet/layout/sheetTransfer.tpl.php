 <?php
    $listSheetAuthor = $mdSheet->getBy(['sheet_author' => Session()->get('op_user_id')]);
    ?>
<style type="text/css">
.uk-datepicker {
    z-index: 9999;
}
</style>

<div class="uk-modal" id="op_sheet_transfer" aria-hidden="true">
    <div class="uk-modal-dialog" style="top: 116px;">
        <button class="uk-modal-close uk-close" type="button"></button>
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Transfer to sheet</h3>
        </div>
        <div class="uk-modal-content uk-margin-top">  
            <div class="uk-grid uk-margin-top">

                <div class="uk-width-large-1-1">
                    <p>
                        <select id="op_sheet_transfer_list" data-md-selectize>
                            <?php

                            $sheetI = 1;
                            if (6 < date('m')) {
                                $sheetI = 7;
                            }

                            $titleSheet = 'Month';
                            if (1 == $infoUser['meta']['user_role']) {

                                $titleSheet = 'Month';
                            }
                            
                            $titleSheet = 'Month';
                            if (1 != $infoUser['meta']['user_role']) {
                                $titleSheet = 'Month';
                            }
                            
                            foreach ($listSheetAuthor as $key => $value) {
                                if( 3 == $value['sheet_status'] ){
                                    echo '<option value="' . $value['id'] . '">'. $value['sheet_title'] . '</option>';
                                }
                                if( 1 == $value['sheet_status'] ){
                                    echo '<option value="' . $value['id'] . '">'. $titleSheet . ' ' . ($sheetI++) . '</option>';
                                }
                                
                            } ?>
                        </select>
                    </p>
                </div>
            </div>          
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat md-btn-flat-primary op-apply-transfer-sheet">Apply</button>
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>