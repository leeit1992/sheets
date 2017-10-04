<?php
$submitFormRule = '';
if( !empty( $sheet ) && ( 2 == $infoUser['meta']['user_role'] or 3 == $infoUser['meta']['user_role'] ) ) {
   // $submitFormRule = 'readonly';
}
?>
<style type="text/css">
html {
    overflow:hidden;
}
td.op-current{
    border: 2px solid rgb(82, 146, 247);
}
body>.content-preloader{
    z-index: 9999 !important;
}
</style>
<script type="text/javascript">
    window.sheetShareStatus = <?php echo ($sheetShareStatus) ? $sheetShareStatus : 0 ?>
</script>
<div id="page-canculator">
	<div id="op-content-sheets">
		<div class="md-card uk-margin-medium-bottom">
	        <div class="md-card-content">
	            <div class="uk-grid" data-uk-grid-margin>
	                <div class="uk-width-1-1">

	                    <ul class="uk-tab">
                            <?php

                            $i = 1; 
                            if( 6 < date('m') ) {
                                $i = 7;
                            }

                            $titleSheet = 'Month';
                            if( 1 == $infoUser['meta']['user_role'] ) {
                                $i = 1; 
                                $titleSheet = 'Sheet';
                            }

                            foreach ($listSheetsOther as $sheetOther) {
                                $active = '';
                                if( !empty( $sheet ) ) {
                                    if( $sheet[0]['id'] == $sheetOther['id'] ) {
                                        $active = 'uk-active';
                                    }
                                }
                                echo '<li class="'.$active.'"><a href="'. url('/view-sheet/'.$sheetOther['id']) .'">'.$sheetOther['sheet_title'].'</a></li>';
                            }
                             
                            foreach( $listSheets as $sheetNav ) { 
                                $_i = $i++;
                                $active = '';
                                if( !empty( $sheet ) ) {
                                    if( $sheet[0]['id'] == $sheetNav['id'] ) {
                                        $active = 'uk-active';
                                    }
                                }

                                echo '<li class="'.$active.'"><a href="'. url('/view-sheet/'.$sheetNav['id']) .'">'.$titleSheet.' '.($_i).'</a></li>';
                            } ?>
                        </ul>
                        <?php View('sheet/layout/sheetToolbar.tpl', ['mdUser' => $mdUser, 'infoUser' => $infoUser, 'sheet' => $sheet, 'mdSheet' => $mdSheet] ) ?>
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
	                    <ul id="tab_sheet" class="uk-margin op-sheet-tabs-content-js">
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
        <a class="md-fab md-fab-accent md-fab-small op-save-sheets-js" href="#" data-uk-tooltip="{pos:'left'}"  title="Save sheet">
            <i class="material-icons">insert_drive_file</i>
        </a>
    </div>
    <?php if( 1 != $infoUser['meta']['user_role'] && !$sheetShareStatus ) : ?>
    <div id="style_switcher">
        <div id="style_switcher_toggle" data-uk-tooltip="{pos:'left'}"  title="Submit Data"><i class="material-icons md-24">&#xE163;</i></div>
        <div class="uk-margin-medium-bottom">
            <h4 class="heading_c uk-margin-bottom">Send Sheet</h4>

            <div class="uk-width-medium-1-1 uk-margin-bottom">
                <label>Title</label>
                <input type="text" class="md-input" name="op_mes_title">
            </div>

            <div class="uk-width-medium-1-1 uk-margin-bottom">
                <label>Messages</label>
                <textarea cols="30" rows="4" class="md-input" name="op_mes_description"></textarea>
            </div>

            <div class="uk-width-medium-1-1 uk-margin-bottom">
                <label for="op_receiver">Send To</label>
                <select id="op_receiver" name="op_receiver" data-md-selectize>
                    <option value="">Select...</option>
                    <?php foreach ($mdUser->getAll() as $key => $value) {
                        if( 1 == $value['user_role'] ){
                            echo '<option value="' . $value['id'] . '">' . $value['user_name'] . '</option>';
                        }
                    } ?>
                </select>
            </div>

            <button type="button" class="md-btn op-send-sheet-js"> Send </button> 
        </div>
    </div>
    <?php endif; ?>
    <div class="uk-notify uk-notify-bottom-right op-notify-js" style="display: none;"></div>
</div>


<?php

// registerScrips([
//     'pikaday' => assets('bower_components/handsontable/plugin/pikaday.js'),
//     // 'handsontable' => assets('bower_components/handsontable/handsontable.full2.min.js'),
//     'handsontable.full' => assets('bower_components/handsontable/handsontable.full.js'),
//     'spectrum' => assets('bower_components/spectrum/spectrum.js'),
//     'lodash' => assets('bower_components/handsontable/plugin/lodash.js'),
//     'underscore.string' => assets('bower_components/handsontable/plugin/underscore.string.js'),
//     'moment' => assets('bower_components/handsontable/plugin/moment.js'),
//     'numeral' => assets('bower_components/handsontable/plugin/numeral.js'),
//     'numeric' => assets('bower_components/handsontable/plugin/numeric.js'),
//     'md5' => assets('bower_components/handsontable/plugin/md5.js'),
//     'jstat' => assets('bower_components/handsontable/plugin/jstat.js'),
//     'formula' => assets('bower_components/handsontable/plugin/formula.js'),
//     'parser' => assets('bower_components/handsontable/plugin/parser.js'),
//     'ruleJS' => assets('bower_components/handsontable/plugin/ruleJS.js'),
//     'handsontable.formula' => assets('bower_components/handsontable/plugin/handsontable.formula.js'),
//     'canculator'   => assets('js/canculator-debug.js'),
// ]);

registerScrips([
    // 'pikaday' => assets('bower_components/handsontable/plugin/pikaday.js'),
    'handsontable' => assets('bower_components/handsontable/handsontable.full2.min.js'),
	// 'handsontable.full' => assets('bower_components/handsontable/handsontable.full.js'),
    'spectrum' => assets('bower_components/spectrum/spectrum.js'),
 //    'lodash' => assets('bower_components/handsontable/plugin/lodash.js'),
 //    'underscore.string' => assets('bower_components/handsontable/plugin/underscore.string.js'),
 //    'moment' => assets('bower_components/handsontable/plugin/moment.js'),
    'numeral' => assets('bower_components/handsontable/plugin/numeral.js'),
    'numeric' => assets('bower_components/handsontable/plugin/numeric.js'),
 //    'md5' => assets('bower_components/handsontable/plugin/md5.js'),
 //    'jstat' => assets('bower_components/handsontable/plugin/jstat.js'),
    'formula' => assets('bower_components/handsontable/plugin/formula.js'),
    'parser' => assets('bower_components/handsontable/plugin/parser.js'),
    'ruleJS' => assets('bower_components/handsontable/plugin/ruleJS.js'),
    'handsontable.formula' => assets('bower_components/handsontable/plugin/handsontable.formula.js'),
	'canculator'   => assets('js/canculator-debug.js'),
]);