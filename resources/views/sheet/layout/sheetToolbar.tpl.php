<div id="op-toolbar-wrapper">

   <!--  <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-bold" style="user-select: none;">&nbsp;</div>
            </div>
        </div>
    </div>
     <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-italic" style="user-select: none;">&nbsp;</div>
            </div>
        </div>
    </div>
     <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-strikethrough" style="user-select: none;">&nbsp;</div>
            </div>
        </div>
    </div>
     <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div> -->
    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box">
            <div class="op-color-menu-button-indicator" style="border-bottom-color: rgb(0, 0, 0);">
                <div class="op-icon op-inline-block op-text-cell-color" style="user-select: none;">
                    <div class="op-icon-img-container op-icon-img op-icon-text-color" style="user-select: none;">&nbsp;</div>
                </div>
                <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
            </div>
        </div>
    </div>
    <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box">
            <div class="op-color-menu-button-indicator" style="border-bottom-color: rgb(0, 0, 0);">
                <div class="op-icon op-inline-block op-bg-cell-color" style="user-select: none;">
                    <div class="op-icon-img-container op-icon-img op-icon-fill-color" style="user-select: none;">&nbsp;</div>
                </div>
                <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
            </div>
        </div>
    </div>  
    <!-- <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    <div id="op-font-size" class=" op-toolbar-menu-buttonop-toolbar-combo-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box">
            <input type="text" class="op-toolbar-combo-button-input" name="" value="10">
            <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
        </div>

    </div> -->
    <!-- <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    <div id="op-font-size" class="op-toolbar-menu-button op-toolbar-combo-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-caption op-inline-block">
            Arial
        </div>
        <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
    </div>  -->
     <!-- <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
     <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-link" style="user-select: none;">&nbsp;</div>
            </div>
        </div>
    </div> -->
   <!--  <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-insert-function" style="user-select: none;">&nbsp;</div>

            </div>
            <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
        </div>
    </div> -->
    <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>

    <?php if (1 == $infoUser['meta']['user_role']) : ?>
    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box" data-uk-tooltip="{pos:'bottom'}" data-uk-modal="{target:'#op_sheet_order'}" title="Add Orderer">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-add-order" style="user-select: none;">&nbsp;</div>

            </div>
            <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
        </div>
    </div>
    <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box" data-uk-tooltip="{pos:'bottom'}" data-uk-modal="{target:'#op_sheet_sendback'}" title="Send notice for user">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-send-back" style="user-select: none;">&nbsp;</div>

            </div>
            <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
        </div>
    </div>
    <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box" data-uk-tooltip="{pos:'bottom'}" data-uk-modal="{target:'#op_sheet_share'}" title="Share">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-share-sheet" style="user-select: none;">&nbsp;</div>

            </div>
            <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
        </div>
    </div>
    <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    
    <?php endif; ?>

    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box" data-uk-tooltip="{pos:'bottom'}" data-uk-modal="{target:'#op_sheet_transfer'}" title="Transfer sheet">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-transfer-sheet" style="user-select: none;">&nbsp;</div>

            </div>
            <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
        </div>
    </div>
    <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>

    <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box" data-uk-tooltip="{pos:'bottom'}" data-uk-modal="{target:'#op_sheet_add_row'}" title="Add rows sheet">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img op-icon-add-row-sheet" style="user-select: none;">&nbsp;</div>

            </div>
            <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
        </div>
    </div>
    <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div>
    <!-- <div class="op-toolbar-menu-button op-toolbar-color-menu-button op-inline-block op-toolbar-menu-button">
        <div class="op-toolbar-menu-button-outer-box" data-uk-tooltip="{pos:'bottom'}" data-uk-modal="{target:'#op_sheet_filter'}" title="Filter">
            <div class="op-icon op-inline-block" style="user-select: none;">
                <div class="op-icon-img-container op-icon-img2 op-icon-autofilter-filled" style="user-select: none;">&nbsp;</div>
            </div>
            <div class="op-toolbar-combo-button-dropdown op-inline-block " style="user-select: none;">&nbsp;</div>
        </div>
    </div>
    <div class="op-toolbar-separator op-inline-block" style="user-select: none;">&nbsp;</div> -->
</div>
<?php if (1 == $infoUser['meta']['user_role']) : ?>
<?php View('sheet/layout/sheetOrderer.tpl', ['mdUser' => $mdUser]) ?>
<?php View('sheet/layout/sheetSendback.tpl', ['mdUser' => $mdUser]) ?>
<?php View('sheet/layout/sheetShare.tpl', ['mdUser' => $mdUser, 'sheet' => $sheet]) ?>
<?php endif; ?>
<?php View('sheet/layout/sheetTransfer.tpl', ['mdSheet' => $mdSheet, 'sheet' => $sheet, 'infoUser' => $infoUser]) ?>
<?php View('sheet/layout/addRowsSheet.tpl', ['mdSheet' => $mdSheet, 'sheet' => $sheet, 'infoUser' => $infoUser]) ?>