<?php
$submitFormRule = '';
if( !empty( $sheet ) && ( 2 == $infoUser['meta']['user_role'] or 3 == $infoUser['meta']['user_role'] ) ) {
   // $submitFormRule = 'readonly';
}

?>
<style type="text/css">
/*html {
    overflow:hidden;
}*/
td.op-current{
    border: 2px solid rgb(82, 146, 247);
}
</style>
<div id="page-canculator">
	<div id="op-content-sheets">
		<div class="md-card uk-margin-medium-bottom">
	        <div class="md-card-content">
	            <div class="uk-grid" data-uk-grid-margin>
	                <div class="uk-width-1-1">
	                    <ul class="uk-tab op-sheet-tabs-js" data-uk-tab="{connect:'#tab_sheet'}">
	                        <li class="uk-active"><a href="#">Sheet Editor</a></li>
	                    </ul>
                        <?php View('sheet/layout/sheetToolbar.tpl') ?>
                        <div class="op-fx">
                            <div class="op-fx--icon">
                                <div class="op-icon op-inline-block" style="user-select: none;">
                                    <div class="op-icon-img-container op-icon-img op-icon-insert-formula" style="user-select: none;">&nbsp;</div>
                                </div>
                            </div>
                            <div class="op-fx--input">
                                <input type="text">
                            </div>
                        </div>
                        <?php 
                            if( !empty( $sheet ) ) {
                                ?>
                                <input type="hidden" id="op_sheet_status" value="<?php echo $sheet[0]['sheet_status'] ?>">
                                <input type="hidden" id="op_sheet_id" value="<?php echo $sheet[0]['id'] ?>">
                                <textarea style="display: none;" id="op_sheet_data"><?php echo $sheet[0]['sheet_content'] ?></textarea>
                                <textarea style="display: none;" id="op_sheet_meta"><?php echo $sheet[0]['sheet_meta'] ?></textarea>
                                <?php
                            }
                        ?>
	                    <ul id="tab_sheet" class="uk-switcher uk-margin op-sheet-tabs-content-js">
	                        <li>
                                <div class="op-sheet-js style-5" id="op-sheet-0"></div>
                            </li>
	                    </ul>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
    <!--  op-add-canculator-js -->
	<div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent md-fab-small" href="<?php echo url('/sheet') ?>" data-uk-tooltip="{pos:'left'}"  title="Add new sheet">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>
    <div id="style_switcher">
        <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
        <div class="uk-margin-medium-bottom">
            <h4 class="heading_c uk-margin-bottom">Save Sheet</h4>
           
            <div class="uk-width-medium-1-1 uk-margin-bottom">
                <label>Title</label>
                <input <?php echo $submitFormRule ?> type="text" class="md-input" value="<?php echo isset( $sheet[0]['sheet_title'] ) ? $sheet[0]['sheet_title'] : '' ?>" name="op_sheet_title" />
            </div>

            <div class="uk-width-medium-1-1 uk-margin-bottom">
                <label>Description</label>
                <textarea <?php echo $submitFormRule ?> cols="30" rows="4" class="md-input" name="op_sheet_description"><?php echo isset( $sheet[0]['sheet_description'] ) ? $sheet[0]['sheet_description'] : '' ?></textarea>
            </div>
            <?php if( ( !empty( $sheet ) && 1 == $sheet[0]['sheet_status'] ) or ( 3 == $infoUser['meta']['user_role'] ) or ( 2 == $infoUser['meta']['user_role'] ) or ( 1 == $infoUser['meta']['user_role'] ) ): ?>
            <button type="button" class="md-btn op-save-sheets-js"> Save </button>
            <?php endif; ?>
            <?php 
                if( !empty( $sheet ) ) {
                    ?>
                    <button type="button" class="md-btn op-save-sheets-new-js" data-type="new"> Save New </button>
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="uk-notify uk-notify-bottom-right op-notify-js" style="display: none;"></div>
</div>

<?php
registerScrips([
	'handsontable' => assets('bower_components/handsontable/handsontable.full.min.js'),
    'spectrum' => assets('bower_components/spectrum/spectrum.js'),
    'lodash' => assets('bower_components/handsontable/plugin/lodash.js'),
    'underscore.string' => assets('bower_components/handsontable/plugin/underscore.string.js'),
    'moment' => assets('bower_components/handsontable/plugin/moment.js'),
    'numeral' => assets('bower_components/handsontable/plugin/numeral.js'),
    'numeric' => assets('bower_components/handsontable/plugin/numeric.js'),
    'md5' => assets('bower_components/handsontable/plugin/md5.js'),
    'jstat' => assets('bower_components/handsontable/plugin/jstat.js'),
    'formula' => assets('bower_components/handsontable/plugin/formula.js'),
    'parser' => assets('bower_components/handsontable/plugin/parser.js'),
    'ruleJS' => assets('bower_components/handsontable/plugin/ruleJS.js'),
    'handsontable.formula' => assets('bower_components/handsontable/plugin/handsontable.formula.js'),
	'canculator'   => assets('js/canculator-debug.js'),
]);