(function($) {
"use strict";

var OP_CANCULATOR_MODEL = Backbone.Model.extend({
    initialize: function() {

        if (!this.get('sheetsNumber')) {
            this.set('sheetsNumber', 0);
        }

        if (!this.get('sheetsWidth')) {
            this.set('sheetsWidth', $('#page_content_inner').width());
        }

        if (!this.get('sheetData')) {
            
            var data100 = new Array;

            for (var i = 0; i <= 10; i++) {
               data100.push(['01/06/2017','Hai Trieu','hu shop','CULOTTE PANTS',"BJ8187","8","Black","1","22.5","","","22.5","","12/6","","61","http://www.adidas.co.uk/culotte-pants/BJ8187.html"]);
            };

            this.set(
                'sheetData',
                data100
            );
        }
        this.createView();
    },

    colType: function(){
        return [
            { // User Code
                editor: 'select',
                selectOptions: function(r,c){
                    return [ OPDATA.user.all_info.user_code + '-' + OPDATA.date + '-' + (r  + 1)];
                },
            },
            { // Date
              type: 'date',
              dateFormat: 'DD/MM/YYYY',
              correctFormat: true,
              defaultDate: '01/01/2017'
            },
            { /** Buyer **/ },
            { /** Name items **/ },
            { /** Code Items **/ },

            { // Size
                type: 'numeric',
            },
            { /** Color **/ },
            { //Quantity
                type: 'numeric',
            },
            { // Price On Website
                type: 'numeric',
            },
            
            { /** Ship Web **/ },
            { /** Coupon **/ },

            { // Price Order
                type: 'numeric',
            },
            { /** Link Items **/ },
            { // Status
                editor: 'select',
                selectOptions: ['Oke', 'Out']
            },
            { //Day In Stock
                type: 'date',
                dateFormat: 'DD/MM/YYYY',
                correctFormat: true,
                defaultDate: '01/01/2017'
            },
            { // Weight
                type: 'numeric'
            }
        ]
    },

    listCols: function(){
        return [
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T'
        ];
    },

    createView: function() {
        this.view = new OP_CANCULATOR({
            model: this
        })
    },

    extend: function() {
        return this;
    }
});

var OP_CANCULATOR = Backbone.View.extend({

    el: '#page-canculator',

    wrapSheets: '#op-content-sheets',

    noticeTpl: _.template('<div class="uk-notify-message <%= classes %>">\
                                            <a class="uk-close"></a>\
                                            <div>\
                                               <%= message %>\
                                            </div>\
                                        </div>'),

    opSheet: null,

    events: {
        'click .op-add-canculator-js': 'addCanculator',
        'mouseover .op-toolbar-menu-button': 'hoverButtonEditor',
        'click .op-save-sheets-js': 'saveSheets',
        'click .op-send-sheet-js': 'sendSheets',
        'click #style_switcher_toggle': 'openSendMes',
        'change #op_filter_sheet': 'actionFilter',
        'click .op-icon-bold': 'useFilter',
        'click .op-fx--input input': 'fxEvent',

        // For Admin role
        'change #op_sheet_add_order': 'adminChooseOrderer',
        'click .op-apply-orderer': 'setOrderer',
        'click .op-icon-add-order': 'openSetOrderer',
        'click #op_sheet_order .atl-close': 'closeSetOrderer',
        'click .op-apply-sendback': 'adminSendBack',
        'click .op-apply-share-sheet': 'shareSheet',
        'click .op-apply-transfer-sheet': 'transferSheet',
    },

    initialize: function() {

        this.listenTo(this.model, 'change', this.render);
        this.listenTo(this.model, 'change', this.fixWidthCanculator);
        this.reizeContentCanculator();
        this.render();

        var $switcher = $('#style_switcher'),
            $switcher_toggle = $('#style_switcher_toggle');

        $switcher_toggle.click(function(e) {
            e.preventDefault();
            $switcher.toggleClass('switcher_active');
        });

        $(document).click(function(){
            $(".op-set-cell").removeClass('op-current');
        })
    },

    render: function() {

        var sheetsNumber = this.model.get('sheetsNumber');

        if (0 === sheetsNumber) {
            this.canculatorConfig(0, this.model.get('sheetsWidth'));
        } else {

            for (var i = 0; i < sheetsNumber; i++) {
                this.canculatorConfig(sheetsNumber, this.model.get('sheetsWidth'));
            }
        }
    },

    formatTextHead: function(text, text2) {
        return '<p>'+text+'</p><p>'+text2+'</p>';
    },

    canculatorConfig: function(sheetId, width) {

        var self = this,
            $sheet = $('#op-sheet-' + sheetId)[0];
        this.setColor();

        var $sheetId = $("#op_sheet_id", this.el);
       

        if( 0 !== $sheetId.length ) {
            var sheetContent = $("#op_sheet_data", this.el),
                sheetMeta = $("#op_sheet_meta", this.el),
                sheetComment = new Array;
           
            sheetContent = JSON.parse(sheetContent.val());
            sheetMeta    = JSON.parse(sheetMeta.val());

            $.each(sheetMeta, function(e, v){
                if( v.comment ) {
                    sheetComment.push({row: v.row, col: v.col, comment: {value: v.comment.value}})
                }
            })
        }else{
            var sheetContent = [
                // [
                //     'Ngày/Tháng', 'Người Mua', 'Người Order', 'Tên Mặt Hàng',
                //     'Mã Hàng', 'Size', 'Mầu', ' Số Lượng', 'Giá Web', 'Ship Web', 'Giảm Giá', 'Giá Order', 'Thành Tiền',
                //     'Ngày Hàng Về', 'Tracking Number', 'Cân Nặng', 'Link Hàng'
                // ]
            ],
            sheetMeta = [],
            sheetComment = [];
        }

        Handsontable.TextCell = {
            editor: Handsontable.mobileBrowser ? Handsontable.editors.MobileTextEditor : Handsontable.editors.TextEditor,
            renderer: Handsontable.renderers.TextRenderer,
        };

        Handsontable.NumericCell = {
            editor: Handsontable.editors.NumericEditor,
            renderer: Handsontable.renderers.NumericRenderer,
            validator: Handsontable.NumericValidator,
            dataType: 'number'
        };

        this.opSheet = new Handsontable($sheet, {
            readOnly: ( window.sheetShareStatus ) ? true : false,
            data: sheetContent,
            startRows: 100,
            rowHeaders: true,
            colHeaders: [
                self.formatTextHead('A','User Code'),
                self.formatTextHead('B','Date'),
                self.formatTextHead('C','Buyer'),
                self.formatTextHead('D','Name items'),
                self.formatTextHead('E','Code Items'),
                self.formatTextHead('F','Size'),
                self.formatTextHead('G','Color'),
                self.formatTextHead('H','Quantity'),
                self.formatTextHead('I','Price On Website'),
                self.formatTextHead('J','Ship Web'),
                self.formatTextHead('K','Coupon'),
                self.formatTextHead('L','Price Order'),
                self.formatTextHead('M','Link Items'),
                self.formatTextHead('N','Status'),
                self.formatTextHead('O','Day In Stock'),
                self.formatTextHead('P','Weight'),
                self.formatTextHead('Q',''),
            ],
            //comments: [{row: 2, col: 2, comment: "Test comment"}],
            columns: self.model.colType(),
            rowHeaders: true,
            colWidths: 100,
            // rowHeights: 30,
            manualColumnMove: true,
            manualRowMove: true,
            manualColumnResize: false,
            manualRowResize: false,
            minSpareRows: true,
            filters: true,
            dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
            width: width - 30,
            height: window.outerHeight - 258,
            formulas: true,
            contextMenu: ( 2 == OPDATA.user.meta.user_role) ? false : true,
            comments: true,

            afterInit: function() {
                
                $("#HandsontableCopyPaste").css('position','absolute');
                $("#HandsontableCopyPaste").css('top',0);

                var self = this;
                $(".wtHolder", this.container).addClass('op-scroll');

                this.OpDataSheets = {};

                var $sheetId = $("#op_sheet_id", this.el);
                var $sheetStatus = $("#op_sheet_status", this.el);

                if( 0 !== $sheetId.length ) {
                    this.sheetId = $sheetId.val();
                    this.sheetStatus = $sheetStatus.val();

                    var sheetMeta = $("#op_sheet_meta", this.el);

                    if( '[]' != sheetMeta.val() ) {
                        this.OpDataSheets = JSON.parse( sheetMeta.val() );
                    }
                }

                if( 2 == OPDATA.user.meta.user_role || 3 == OPDATA.user.meta.user_role ){
                    
                }

                setTimeout(function(){
                    var limitRow = sheetContent.length;
                    
                    limitRow = 100;
                    
                    self.setDataAtCell(limitRow-1,16,'');
                }, 500 );  
            },

            AfterAutofill: function(startRow, startCol, fillData, endRow, endCol, pluginName, ff, directionOfDrag, deltas, self)
            {

                var test = new Array();
             
                test.push([this.getSourceDataArray(startRow - 1,startCol)[startRow - 1][startCol]])
                return test;
            },

            afterFilter: function(conditionsStack){

                var d = this; 
                var startNewRow = this.getData().length+4;
                var weight = 0;
                var argsWeight = new Array;
                var items  = 0;
                var argsItems  = new Array;
                var totalPrice = 0;
                var argsTotalPrice = new Array;

                this.setDataAtCell(startNewRow, 3, 'Total weight');
                this.setDataAtCell(startNewRow + 1, 3, 'Quantity of items');
                this.setDataAtCell(startNewRow + 2, 3, 'Total price');

                $.each(this.getData(), function(i, el){

                    $.each(el, function(ii, ell){
                        $(d.getCell(i, ii)).css({'background': '' });
                        d.setCellMeta(i, ii, 'background', '');
                        d.setCellMeta(i, ii, 'color', '');
                        d.OpDataSheets[ i + '-' + ii ] = d.getCellMeta(i, ii);
                        
                        if( 15 == ii ){
                            if (ell == parseInt(ell, 10)){
                                argsWeight.push(self.model.listCols()[ii] + '' + (i+1));
                                weight += parseInt(ell);
                            }
                        }

                        if( 7 == ii ){
                            if (ell == parseInt(ell, 10)){
                                argsItems.push(self.model.listCols()[ii] + '' + (i+1));
                                items += parseInt(ell);
                            }
                        }

                        if( 11 == ii ){
                            if (ell == parseFloat(ell, 10)){
                                argsTotalPrice.push(self.model.listCols()[ii] + '' + (i+1));
                                totalPrice += parseFloat(ell);
                            }
                        }
                    })
                   
                });

                this.setDataAtCell(startNewRow, 4, '=SUM('+argsWeight.join(',')+')');
                this.setDataAtCell(startNewRow + 1, 4, '=SUM('+argsItems.join(',')+')');
                this.setDataAtCell(startNewRow + 2, 4, '=SUM('+argsTotalPrice.join(',')+')');

            
                d.setCellMeta(startNewRow, 3, 'background', '#3b9c71');
                d.setCellMeta(startNewRow, 3, 'color', '#white');
                d.OpDataSheets[ startNewRow + '-3' ] = d.getCellMeta(startNewRow, 3);

                for (var i = startNewRow; i <= startNewRow + 2; i++) {
                    $(d.getCell(i, 3)).css({'background': '#3b9c71', 'color': 'white' });
                    $(d.getCell(i, 4)).css({'background': '#3b9c71', 'color': 'white' });i

                    d.setCellMeta(i, 3, 'background', '#3b9c71');
                    d.setCellMeta(i, 3, 'color', 'white');
                    d.OpDataSheets[ i + '-3' ] = d.getCellMeta(i, 3);

                    d.setCellMeta(i, 4, 'background', '#3b9c71');
                    d.setCellMeta(i, 4, 'color', 'white');
                    d.OpDataSheets[ i + '-4' ] = d.getCellMeta(i, 3);
                };

            },

            afterSelection: function(r, c){
                var self = this,
                    data = this.getDataAtCell(r,c),
                    fomulas = $(".handsontableInput").val();

                $(".op-fx--input input").val( data );
                $(".op-fx--input input").attr( 'data-row', r );
                $(".op-fx--input input").attr( 'data-col', c );
               
                if( 2 != this.sheetStatus && 2 == OPDATA.user.meta.user_role) {
                    $('.op-fx--input input').change(function(){
                        self.setDataAtCell(r,c, $(this).val());
                    });
                }   
            },

            cells: function (row, col, prop) {
                var cellProperties = this;
                if( 2 == this.instance.sheetStatus && ( 2 == OPDATA.user.meta.user_role || 3 == OPDATA.user.meta.user_role )  ) {
                    cellProperties.readOnly = true;
                }

                if( 2 == col || 13 == col || 14 == col || 15 == col ) {
                    cellProperties.readOnly = true;
                }

                if( 3 == OPDATA.user.meta.user_role || 1 == OPDATA.user.meta.user_role ) {
                    if( 11 == col || 12 == col || 13 == col || 14 == col || 15 == col ) {
                        cellProperties.readOnly = false;
                    }
                }

                if( window.sheetShareStatus ) {
                    if( 14 == col || 15 == col ) {
                        cellProperties.readOnly = false;
                    }
                }

                if( 1 == OPDATA.user.meta.user_role ) {
                    cellProperties.readOnly = false;
                }

                cellProperties.renderer = window.firstRowRenderer;
                return cellProperties;
            },
        
            cell: sheetComment
        });


        Handsontable.hooks.add('afterChange', function(changes) {
            var d = this; 

            if( changes ) {

               var change = changes[0];
                d.setCellMeta(change[0], change[1], 'fomulas', change[3]);
                if( 13 == change[1] ){
                    if( "Out" == change[3] ){
                        $(d.getCell(change[0], change[1])).css({'color': '#FF9800'});
                        d.setCellMeta(change[0], change[1], 'color', '#FF9800');
                        d.OpDataSheets[ change[0] + '-' + change[1] ] = d.getCellMeta(change[0], change[1]);
                    }
                } 

                if( 12 == change[1] ){

                    $.ajax({
                        url: OPDATA.adminUrl + 'lech',
                        type: "GET",
                        data: {
                            link: d.getDataAtCell(change[0],change[1]),
                        },
                        success: function(res) {
                            var dataResult = JSON.parse(res);
                           d.setDataAtCell(change[0],3, dataResult.title);
                           d.setDataAtCell(change[0],8, dataResult.price);
                           d.setDataAtCell(change[0],7, 1);
                        } 
                    });  
                }

            }
        });


        Handsontable.hooks.add('afterSelectionEnd', function(rst, cst, re, ce) {
            var d = this; 
            var argsCells = new Array;
            var checkRow = new Array;
            for (var i = cst; i <= ce; i++) {
                for (var ii = rst; ii <= re; ii++) {
                    argsCells.push({row : ii, col: i});
                }
            };

            d.opAfterSelectionEnd = argsCells;
            d.dataCellSelect = {rst, cst, re, ce};
            

            // Change color background for cell
            $(".op-bg-cell-color").spectrum({
                showPaletteOnly: true,
                showPalette:true,
                color: 'blanchedalmond',
                palette: [
                    ['black', 'white', 'blanchedalmond',
                    'rgb(255, 128, 0);', 'hsv 100 70 50'],
                    ['red', 'yellow', 'green', 'blue', 'violet']
                ],
                move: function(color) {
                    $.each(argsCells,function(i,v){

                        /**
                         * Set style after change.
                         */
                        $(d.getCell(v.row, v.col)).css({'background': color.toHexString()});
                        d.setCellMeta(v.row, v.col, 'background', color.toHexString());
                        d.OpDataSheets[ v.row + '-' + v.col ] = d.getCellMeta(v.row, v.col);

                    });
                }
            });

            // Change text color for cell
            $(".op-text-cell-color").spectrum({
                showPaletteOnly: true,
                showPalette:true,
                color: 'blanchedalmond',
                palette: [
                    ['black', 'white', 'blanchedalmond',
                    'rgb(255, 128, 0);', 'hsv 100 70 50'],
                    ['red', 'yellow', 'green', 'blue', 'violet']
                ],
                move: function(color) {
                    $.each(argsCells,function(i,v){
                        $(d.getCell(v.row, v.col)).css({'color': color.toHexString()});
                        d.setCellMeta(v.row, v.col, 'color',color.toHexString());
                        d.OpDataSheets[ v.row + '-' + v.col ] = d.getCellMeta(v.row, v.col);                                                                                            
                    });
                }
            });

        });   

    },

    fixWidthCanculator: function() {
        var sheetsWidth = this.model.get('sheetsWidth');
        this.opSheet.updateSettings({
            width: sheetsWidth
        });
    },

    setColor: function() {
        window.firstRowRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            Handsontable.TextCell.renderer.apply(this, arguments);
           
            if( instance.OpDataSheets ) {
                if( instance.OpDataSheets[row + '-' + col] ) {
                    var dataSheet       = instance.OpDataSheets[row + '-' + col];
                    
                    // Set style cell.
                    td.style.color      = dataSheet.color;
                    td.style.background = dataSheet.background;

                    // Set cell meta.
                    instance.setCellMeta(row, col, 'background', dataSheet.background);
                    instance.setCellMeta(row, col, 'color', dataSheet.color);
                    instance.setCellMeta(row, col, 'codeId', dataSheet.codeId );
                    
                    instance.setCellMeta(row, col, 'sheetId', dataSheet.sheetId );

                    instance.setCellMeta(row, col, 'sIdCtm', dataSheet.sIdCtm );
                    instance.setCellMeta(row, col, 'rCtm', dataSheet.rCtm );
                    instance.setCellMeta(row, col, 'cCtm', dataSheet.cCtm );
                    instance.setCellMeta(row, col, 'mesId', dataSheet.mesId );

                    if( dataSheet.readOnly && 'true' == dataSheet.readOnly ) {
                        cellProperties.readOnly = true;
                    }
                }
            }

            if( 13 == col ) {
                if( 'Out' == instance.getDataAtCell(row,col) || 'Oke' == instance.getDataAtCell(row,col) ) {
                    
                    td.style.background = 'white';
                    td.style.color = 'black';
                    if( 'Out' == instance.getDataAtCell(row,col) ) {
                        td.style.color      = '#FF9800';
                    }
                }
            }
        }
    },

    addCanculator: function() {

        var sheetsNumber = parseInt(this.model.get('sheetsNumber')) + 1;

        $('.op-sheet-tabs-content-js', this.el).append('<li><div class="op-sheet-js" id="op-sheet-' + sheetsNumber + '"/></li>');
        $('.op-sheet-tabs-js', this.el).append('<li><a href="#">Sheet ' + (sheetsNumber + 1) + '</a></li>');
        this.model.set('sheetsNumber', sheetsNumber);

        return false;
    },

    reizeContentCanculator: function() {
        var self = this;

        $(".op-switch-screen-js").click(function() {
            setTimeout(function() {

                var width = parseInt($('#page_content_inner').width());
                if (!$('body').hasClass('sidebar_main_active')) {
                    self.model.set('sheetsWidth', width - 26);
                } else {
                    self.model.set('sheetsWidth', width - 40);
                }
            }, 500)
        });
    },

    hoverButtonEditor: function(e) {
        $('.op-toolbar-menu-button').each(function() {
            $(this).removeClass('op-toolbar-menu-button-hover');
        });
        $(e.currentTarget).addClass('op-toolbar-menu-button-hover');
    },

    saveSheets: function(e){
        altair_helpers.content_preloader_show();

        var self     = this,
            opData   = new Array,
            saveType = $(e.currentTarget).attr('data-type');

        $.each(this.opSheet.OpDataSheets, function(e,v){

            if( self.opSheet.getCellMeta(v.row,v.col).comment ) {
                self.opSheet.OpDataSheets[e]['comment'] = self.opSheet.getCellMeta(v.row,v.col).comment;
            }
        });

        $.each(this.opSheet.OpDataSheets, function(e,v){

            v.instance  = undefined;
            v.prop      = undefined;
            v.visualCol = undefined;
            v.visualRow = undefined;
            v.renderer  = undefined;
        });

        var data = {
            sheetData: JSON.stringify(this.opSheet.getData()),
            sheetMeta: JSON.stringify(this.opSheet.OpDataSheets),
            saveType: saveType,
        };

        if( this.opSheet.sheetId ){
            data.sheetId = this.opSheet.sheetId;
        }
        
        $.post(OPDATA.adminUrl + 'save-sheets' ,data, function(){
            altair_helpers.content_preloader_hide();

            var output = self.noticeTpl({
                message: 'Save sheet success.',
                classes: 'uk-notify-message-success'
            });
            $('.op-notify-js', self.el).html(output).show();
            $("#style_switcher").removeClass('switcher_active');

            setTimeout(function(){
                $('.op-notify-js', self.el).fadeOut();
            }, 2000);
            
        });

        return false;
    },

    actionFilter: function(e){
        $(".op-filter-action").each(function(i, el){
            $(el).fadeOut(200);
        });
        
        var filter = $(e.currentTarget).val();

        $("#op-filter-" + filter).fadeIn(200);
    },

    useFilter : function(){
        this.opSheet.updateSettings({

            columnSummary: [
                  {
                    destinationRow: 4,
                    destinationColumn: 3,
                    type: 'sum',
                    forceNumeric: true
                  }
                ]
        });
    },

    fxEvent: function(e){
        var col = $(e.currentTarget).attr('data-col'),
            row = $(e.currentTarget).attr('data-row');

        $(this.opSheet.getCell(row, col)).addClass('op-set-cell op-current');

        return false;  
    },

    openSendMes: function(e){

        var self = this, 
            d = this.opSheet;

        if( 2 == OPDATA.user.meta.user_role ){
            var checkDataOpen = new Array();

            $.each(this.opSheet.opAfterSelectionEnd, function(i, v){
                if( 3 == v.col || 1 == v.col ) {
            
                    if( null == d.getDataAtCell(v.row, v.col) ) {
                        checkDataOpen.push(1);
                    }
                }
            });

            if( 0 < checkDataOpen.length ) {
                UIkit.modal.alert('Send sheet Error. <p>Please choose row data and please do not leave it blank row data !</p>');
                $("#style_switcher").removeClass('switcher_active')
                return false;
            }

            $.each(this.opSheet.opAfterSelectionEnd, function(i, v){
                if( d.getDataAtCell(v.row, 3) ) {

                    if( 0 == v.col ) {
                        d.setDataAtCell(v.row, v.col, OPDATA.user.all_info.user_code + '-' + OPDATA.date + '-' + (v.row  + 1))
                    }

                    $(d.getCell(v.row, v.col)).css({'background': '#85817a'});
                    $(d.getCell(v.row, v.col)).css({'color': '#ffffff'});
                    d.setCellMeta(v.row, v.col, 'background', ' #85817a');
                    d.setCellMeta(v.row, v.col, 'color', '#ffffff');
                    d.setCellMeta(v.row, v.col, 'codeId', OPDATA.user.all_info.user_code + '-' + d.sheetId + '-' + window.ATLLIB.makeid() );
                    d.setCellMeta(v.row, v.col, 'sheetId', d.sheetId );

                    var cellMeta = d.getCellMeta(v.row, v.col);

                    d.OpDataSheets[ v.row + '-' + v.col ] = cellMeta;    
                }
                 
            });
        }

        if( 3 == OPDATA.user.meta.user_role ){

            var checkDataOpen = new Array();

            $.each(this.opSheet.opAfterSelectionEnd, function(i, v){
                if( 3 == v.col || 1 == v.col ) {
            
                    if( null == d.getDataAtCell(v.row, v.col) ) {
                        checkDataOpen.push(1);
                    }
                }
            });

            if( 0 < checkDataOpen.length ) {
                UIkit.modal.alert('Send sheet Error. <p>Please choose row data and please do not leave it blank row data !</p>');
                $("#style_switcher").removeClass('switcher_active')
                return false;
            }

            if( $(e.currentTarget).closest('#style_switcher').hasClass('switcher_active') ) {
                $.each(this.opSheet.opAfterSelectionEnd, function(i, v){
                    $(d.getCell(v.row, v.col)).css({'background': '#85817a'});
                    $(d.getCell(v.row, v.col)).css({'color': '#ffffff'}); 
                });
            }else{
                $.each(this.opSheet.opAfterSelectionEnd, function(i, v){
                    $(d.getCell(v.row, v.col)).css({'background': 'white'});
                    $(d.getCell(v.row, v.col)).css({'color': '#777'}); 
                });
            }
            
        }
    },

    sendSheets: function(){
        
        var self = this, 
            d = this.opSheet,
            metaSelect = {},
            rowSend = d.getSourceDataArray(
                d.dataCellSelect.rst,
                d.dataCellSelect.cst,
                d.dataCellSelect.re,
                d.dataCellSelect.ce
            );

        // if( 0 == $("textarea[name=op_mes_description]").val().length ) {
        //     UIkit.modal.alert('Please choose receiver!');
        //     return false;
        // }

        metaSelect = this.getCellMetaSelect(d);

        var sendStatus = new Array();

        $.each(rowSend, function(r, c){
            if( !c[3] || !c[1]) {
                sendStatus.push(1);
            }
        });

        if( 0 < sendStatus.length ) {
            UIkit.modal.alert('Send sheet Error. <p>Please choose row data and please do not leave it blank row data !</p>');
            return false;
        }
       
        if(3 == OPDATA.user.meta.user_role) {
            $.ajax({
                url: OPDATA.adminUrl + 'sendback-inbox',
                type: "POST",
                data: {
                    sheetData: JSON.stringify(rowSend),
                    sheetMeta: JSON.stringify(metaSelect),
                    title: $("input[name=op_mes_title]").val(),
                    receiver: $("select[name=op_receiver]").val(),
                    message: $("textarea[name=op_mes_description]").val(),
                },
                success: function(res) {
                    var result = JSON.parse(res);

                    if( result.socketId ) {
                        $.each(result.socketId, function(i, el){
                            socket.emit('notice-inbox', el);
                        });
                    }
                    $(".op-save-sheets-js").trigger('click');
                    altair_helpers.content_preloader_hide();
                    UIkit.modal.alert('Send back success!');
                } 
            });
        }else{
            var data = {
                sheetData: JSON.stringify(rowSend),
                receiver: $("select[name=op_receiver]").val(),
                sheetMeta: JSON.stringify(metaSelect),
                message: $("textarea[name=op_mes_description]").val(),
                title: $("input[name=op_mes_title]").val(),
                sheetId: this.opSheet.sheetId
            };

            altair_helpers.content_preloader_show();
            $.post(OPDATA.adminUrl + 'send-sheet' ,data, function(){
                altair_helpers.content_preloader_hide();

                var output = self.noticeTpl({
                    message: 'Send sheet success.',
                    classes: 'uk-notify-message-success'
                });
                $('.op-notify-js', self.el).html(output).show();
                $("#style_switcher").removeClass('switcher_active');

                $(".op-save-sheets-js").trigger('click');

                socket.emit('notice-inbox', $("select[name=op_receiver]").val());

                setTimeout(function(){
                    $('.op-notify-js', self.el).fadeOut();
                }, 2000);
                
            });
        }

        return false;
    },


    getCellMetaSelect: function(d){
        var metaSelect = {};
        for (var i = d.dataCellSelect.cst; i <= d.dataCellSelect.ce; i++) {
            for (var ii = d.dataCellSelect.rst; ii <= d.dataCellSelect.re; ii++) {
                var meta = d.getCellMeta(ii, i);
                if( meta.comment ) {
                    meta['comment'] = meta.comment;
                }

                metaSelect[ ii + '-' + i ] = meta; 
            }
        };
        for (var i = d.dataCellSelect.cst; i <= d.dataCellSelect.ce; i++) {
            for (var ii = d.dataCellSelect.rst; ii <= d.dataCellSelect.re; ii++) {
                d.setCellMeta(ii, i, 'readOnly', 'true');

                var meta = d.getCellMeta(ii, i);
                    meta.instance  = undefined;
                    meta.prop      = undefined;
                    meta.visualCol = undefined;
                    meta.visualRow = undefined;
                    meta.renderer  = undefined;
                metaSelect[ ii + '-' + i ] = meta; 
            }
        };

        return metaSelect;
    },

    adminChooseOrderer: function(e){
        var self     = this,
            ordererId = $(e.currentTarget).val();
        $(".op_orderer_list").hide();

        $(".op_orderer_" + ordererId).fadeIn();
        $(".op-apply-orderer").attr('data-id', ordererId);
        return false;
    },

    setOrderer: function(e){
        altair_helpers.content_preloader_show();
        var self     = this,
            d = this.opSheet,
            metaSelect = {},
            rowSend = d.getSourceDataArray(
                d.dataCellSelect.rst,
                d.dataCellSelect.cst,
                d.dataCellSelect.re,
                d.dataCellSelect.ce
            ),
            ordererId = $(e.currentTarget).attr('data-id'),
            dataUser = JSON.parse( $('textarea[name=op_orderer_'+ordererId+']').val() );

        var sendStatus = new Array();

        if( ordererId ) {

            $.each(d.opAfterSelectionEnd, function(i, v){

                if( 0 < d.getDataAtCell(v.row, 0).length ) {

                    var metaCurrent = d.OpDataSheets[v.row + '-' + v.col];
                    
                    if( metaCurrent ) {
                        $(d.getCell(v.row, v.col)).css({'background': dataUser.user_color});
                        $(d.getCell(v.row, v.col)).css({'color': '#ffffff'});

                        // Set meta user order
                        d.setCellMeta(v.row, v.col, 'background', dataUser.user_color);
                        d.setCellMeta(v.row, v.col, 'color', '#ffffff');
                        d.setCellMeta(v.row, v.col, 'codeId', metaCurrent.codeId );
                        d.setCellMeta(v.row, v.col, 'sheetId', d.sheetId );

                        d.setCellMeta(v.row, v.col, 'sIdCtm', metaCurrent.sIdCtm );
                        d.setCellMeta(v.row, v.col, 'rCtm', metaCurrent.rCtm );
                        d.setCellMeta(v.row, v.col, 'cCtm', metaCurrent.cCtm );

                        var cellMeta = d.getCellMeta(v.row, v.col);

                        d.OpDataSheets[ v.row + '-' + v.col ] = cellMeta;    

                        // Set user order.
                        if( 2 == v.col ) {
                            d.setDataAtCell(v.row, 2, dataUser.user_name);
                        }
                    }
                }  
            });

            metaSelect = this.getCellMetaSelect(d);

            var 
            orderId = window.ATLLIB.makeid(),
            data = {
                sheetData: JSON.stringify(rowSend),
                receiver: ordererId,
                sheetMeta: JSON.stringify(metaSelect),
                message: 'Oder #' + orderId,
                title: 'Oder #' + orderId,
                sheetId: this.opSheet.sheetId
            };
             
            $.post(OPDATA.adminUrl + 'send-sheet' ,data, function(){
                altair_helpers.content_preloader_hide();

                var output = self.noticeTpl({
                    message: 'Add sheet to oderer success.',
                    classes: 'uk-notify-message-success'
                });
                $('.op-notify-js', self.el).html(output).show();
                $(".uk-close").trigger('click');

                socket.emit('notice-inbox', ordererId);

                setTimeout(function(){
                    $('.op-notify-js', self.el).fadeOut();
                    $(".op-save-sheets-js").trigger('click');
                }, 2000);
                
            });
        }

    },

    openSetOrderer : function(){
        var self     = this,
            d = this.opSheet;

        var checkDataOpen = this.checkSelectBeforeSend(d.opAfterSelectionEnd);

        if( 0 != checkDataOpen.length ) {
               $(".atl-close").trigger('click');
            return false;
        }

        $.each(d.opAfterSelectionEnd, function(i, v){

                if( null != d.getDataAtCell(v.row, 0) ) {

                    var metaCurrent = d.OpDataSheets[v.row + '-' + v.col];
                    
                    if( metaCurrent ) {
                        $(d.getCell(v.row, v.col)).css({'background': '#777'});
                        $(d.getCell(v.row, v.col)).css({'color': 'white'});
                    }
                }  
            });
    },
    closeSetOrderer: function(){
        var self     = this,
            d = this.opSheet;

        $.each(d.opAfterSelectionEnd, function(i, v){
                if( undefined != d.getDataAtCell(v.row, 0) ) {
                   if( 0 < d.getDataAtCell(v.row, 0).length ) {

                        var metaCurrent = d.OpDataSheets[v.row + '-' + v.col];
                        
                        if( metaCurrent ) {
                            $(d.getCell(v.row, v.col)).css({'background': metaCurrent.background});
                            $(d.getCell(v.row, v.col)).css({'color': metaCurrent.color});
                        }
                    }  
                }
                 
            });
    },

    adminSendBack: function(){
        altair_helpers.content_preloader_show();
        var self = this, 
            d = this.opSheet,
            metaSelect = {},
            rowSend = d.getSourceDataArray(
                d.dataCellSelect.rst,
                d.dataCellSelect.cst,
                d.dataCellSelect.re,
                d.dataCellSelect.ce
            );
        metaSelect = this.getCellMetaSelect(d);

        $.ajax({
            url: OPDATA.adminUrl + 'sendback-inbox',
            type: "POST",
            data: {
                sheetData: JSON.stringify(rowSend),
                sheetMeta: JSON.stringify(metaSelect),
                title: $("input[name=op_mes_title]").val(),
                message: $("textarea[name=op_mes_description]").val(),
            },
            success: function(res) {
                var result = JSON.parse(res);

                if( result.socketId ) {
                    $.each(result.socketId, function(i, el){
                        socket.emit('notice-inbox', el);
                    });
                }
                $(".uk-modal-close").trigger('click');
                altair_helpers.content_preloader_hide();
                UIkit.modal.alert('Send back success!');
            } 
        });
    },

    shareSheet: function(){
        var self = this;
        var listID = $("#op_sheet_share_list").val();

        $.ajax({
            url: OPDATA.adminUrl + 'share-sheet',
            type: "POST",
            data: {
                listID: listID,
                sheetId: self.opSheet.sheetId,
            },
            success: function(res) {
                var result = JSON.parse(res);

                if( result.socketId ) {
                    $.each(result.socketId, function(i, el){
                        socket.emit('notice-inbox', el);
                    });
                }
                $(".uk-modal-close").trigger('click');
                altair_helpers.content_preloader_hide();
                UIkit.modal.alert('Share success!');
            } 
        });

    },

    transferSheet: function(){
        
        var self = this, 
            d = this.opSheet;

        if( undefined == d.dataCellSelect ) {
            UIkit.modal.alert('Please choose row before transfer sheet.');
            return false;
        }

        if( undefined == d.dataCellSelect ) {
            UIkit.modal.alert('Please choose row before transfer sheet.');
            return false;
        }

        var 
            metaSelect = {},
            rowSend = d.getSourceDataArray(
                d.dataCellSelect.rst,
                d.dataCellSelect.cst,
                d.dataCellSelect.re,
                d.dataCellSelect.ce
            );
        var sheetId = $("#op_sheet_transfer_list").val();
        metaSelect = this.getCellMetaSelect(d);

        altair_helpers.content_preloader_show();
        $.ajax({
            url: OPDATA.adminUrl + 'transfer-sheet',
            type: "POST",
            data: {
                sheetData: JSON.stringify(rowSend),
                sheetMeta: JSON.stringify(metaSelect),
                sheetId: sheetId,
            },
            success: function(res) {
                $(".uk-modal-close").trigger('click');
                altair_helpers.content_preloader_hide();
                UIkit.modal.alert('Transfer success!');
            } 
        });
    },

    checkSelectBeforeSend : function(opAfterSelectionEnd){
        var checkDataOpen = new Array();
        var d = this.opSheet;

        $.each(opAfterSelectionEnd, function(i, v){
            if( 3 == v.col || 1 == v.col ) {
        
                if( null == d.getDataAtCell(v.row, v.col) ) {
                    checkDataOpen.push(1);
                }
            }
        });

        if( 0 < checkDataOpen.length ) {
            UIkit.modal.alert('Send sheet Error. <p>Please choose row data and please do not leave it blank row data !</p>');
        }

        return checkDataOpen;
    }

});
new OP_CANCULATOR_MODEL;
OP_CANCULATOR_MODEL;

})(jQuery);