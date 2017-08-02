<style type="text/css">
.uk-datepicker {
    z-index: 9999;
}
</style>

<div class="uk-modal uk-open" id="op_sheet_filter" aria-hidden="false" style="display: none; overflow-y: auto;">
    <div class="uk-modal-dialog" style="top: 116px;">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Filter Sheet</h3>
        </div>
        <div class="uk-modal-content uk-margin-top">  
            <div class="uk-grid uk-margin-top">
                <div class="uk-width-large-1-1">
                    <p>
                        <select id="op_filter_sheet" data-md-selectize>
                            <option value="date">Filter by date</option>
                            <option value="orderer">Filter by orderer</option>
                            <option value="commodity">Filter by day has commodity</option>
                            <option value="name">Filter by name</option>
                        </select>
                    </p>
                    <p>
                        <div class="uk-input-group op-filter-action" id="op-filter-date" style="display: none;">
                            <span class="uk-input-group-addon">
                                <i class="uk-input-group-icon uk-icon-calendar"></i>
                            </span>
                            <label for="uk_dp_end">Choose date</label>
                            <input class="md-input" type="text" data-uk-datepicker="{format:'DD/MM/YYYY'}">
                        </div>
                    </p>

                    <p>
                        <div class="uk-input-group op-filter-action" id="op-filter-name" style="display: none;">
                            <span class="uk-input-group-addon">
                                <i class="uk-input-group-icon uk-icon-calendar"></i>
                            </span>
                            <label for="uk_dp_end">Name</label>
                            <input class="md-input" type="text">
                        </div>
                    </p>

                    <p>
                        <div class="uk-input-group op-filter-action" id="op-filter-commodity" style="display: none;">
                            <span class="uk-input-group-addon">
                                <i class="uk-input-group-icon uk-icon-calendar"></i>
                            </span>
                            <label for="uk_dp_end">Day has commodity</label>
                            <input class="md-input" type="text" data-uk-datepicker="{format:'DD/MM/YYYY'}">
                        </div>
                    </p>

                    <p>
                        <div class="uk-input-group op-filter-action" id="op-filter-orderer" style="display: none;">
                            <span class="uk-input-group-addon">
                                <i class="uk-input-group-icon uk-icon-calendar"></i>
                            </span>
                            <label for="uk_dp_end">Orderer name</label>
                            <input class="md-input" type="text">
                        </div>
                    </p>
                </div>
            </div>          
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
            <button type="button" class="md-btn md-btn-flat md-btn-flat-primary">Apply Filter</button>
        </div>
    </div>
</div>