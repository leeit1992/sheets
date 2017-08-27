<!-- <div class="md-fab-wrapper">
    <a class="md-fab md-fab-accent" href="#op-massage-accept" data-uk-modal="{center:true}">
        <i class="material-icons">&#xE150;</i>
    </a>
</div> -->
<div class="uk-modal" id="op-massage-accept">
    <div class="uk-modal-dialog">
        <button class="uk-modal-close uk-close" type="button"></button>
        <form id="op-form-accept">
            <div class="uk-modal-header">
                <h3 class="uk-modal-title">Accept and add order</h3>
            </div>

            <div class="uk-margin-medium-bottom">
                <label for="op_sheet_accept">Accept To</label>
                <select id="op_sheet_accept" name="op_sheet_accept" data-md-selectize>
                    <?php $sheetI = 1; foreach ($listSheets as $key => $value) {
                        echo '<option value="' . $value['id'] . '">Sheet ' . ($sheetI++) . '</option>';
                    } ?>
                </select>
            </div>
 
            <div class="uk-modal-footer">
                <button type="button" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary op-accept-data">Accept</button>
            </div>
        </form>
    </div>
</div>