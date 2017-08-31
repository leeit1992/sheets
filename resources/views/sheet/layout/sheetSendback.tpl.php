<style type="text/css">
.uk-datepicker {
    z-index: 9999;
}
</style>

<div class="uk-modal" id="op_sheet_sendback" aria-hidden="true">
    <div class="uk-modal-dialog" style="top: 116px;">
        <button class="uk-modal-close uk-close" type="button"></button>
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Send notice for user</h3>
        </div>
        <div class="uk-modal-content uk-margin-top">  
            <div class="uk-grid uk-margin-top">
                <div class="uk-width-medium-1-1 uk-margin-bottom">
                    <div class="md-input-wrapper">
                        <label>Title</label>
                        <input type="text" class="md-input" name="op_mes_title">
                        <span class="md-input-bar"></span>
                    </div>
                </div>
                <div class="uk-width-medium-1-1 uk-margin-bottom">
                    <div class="md-input-wrapper">
                        <label>Messages</label>
                        <textarea cols="30" rows="4" class="md-input" name="op_mes_description"></textarea>
                        <span class="md-input-bar"></span>
                    </div>
                    
                </div>
            </div>          
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat md-btn-flat-primary op-apply-sendback">Apply</button>
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>