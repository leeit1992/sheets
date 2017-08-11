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
            { // Trạng Thái
                editor: 'select',
                selectOptions: [OPDATA.user.all_info.user_code]
            },
            { // Ngày/Tháng
              type: 'date',
              dateFormat: 'DD/MM/YYYY',
              correctFormat: true,
              defaultDate: '01/01/2017'
            },
            { /** Người Mua **/ },
            { /** Người Order **/ },
            { /** Tên Mặt Hàng **/ },
            { /** Mã Hàng **/ },

            { // Size
                type: 'numeric',
            },
            { /** Mầu **/ },
            { //Số Lượng
                type: 'numeric',
            },
            { // Giá Web
                type: 'numeric',
            },
            
            { /** Ship Web **/ },
            { /** Giảm Giá **/ },

            { // Giá Order
                type: 'numeric',
            },
            { // Thành Tiền
                type: 'numeric',
            },
            { // Ngày Hàng Về
                type: 'date',
                dateFormat: 'DD/MM/YYYY',
                correctFormat: true,
                defaultDate: '01/01/2017'
            },
            { /** Tracking Number **/ },
            { // Cân Nặng
                type: 'numeric'
            },
            { /** Link Hàng **/ },
            { // Trạng Thái
                editor: 'select',
                selectOptions: ['Oke', 'Out']
            },
            { /** Link Hàng **/ }
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
            sheetContent = JSON.parse(sheetContent.val());
        }else{
            var sheetContent = [
                // [
                //     'Ngày/Tháng', 'Người Mua', 'Người Order', 'Tên Mặt Hàng',
                //     'Mã Hàng', 'Size', 'Mầu', ' Số Lượng', 'Giá Web', 'Ship Web', 'Giảm Giá', 'Giá Order', 'Thành Tiền',
                //     'Ngày Hàng Về', 'Tracking Number', 'Cân Nặng', 'Link Hàng'
                // ]
            ];
        }

        this.opSheet = new Handsontable($sheet, {
            // readOnly: true,
            data: sheetContent,

            startRows: 100,
            rowHeaders: true,
            colHeaders: true,
            colHeaders: [
                self.formatTextHead('A','User Code'),
                self.formatTextHead('B','Date'),
                self.formatTextHead('C','Buyer'),
                self.formatTextHead('D','Collector'),
                self.formatTextHead('E','Name items'),
                self.formatTextHead('F','Code Items'),
                self.formatTextHead('G','Size'),
                self.formatTextHead('H','Color'),
                self.formatTextHead('I','Quantity'),
                self.formatTextHead('J','Price On Website'),
                self.formatTextHead('K','Ship Web'),
                self.formatTextHead('L','Sale'),
                self.formatTextHead('M','Price Order'),
                self.formatTextHead('N','Into Money'),
                self.formatTextHead('O','Day In Stock'),
                self.formatTextHead('P','Tracking Number'),
                self.formatTextHead('Q','Weight'),
                self.formatTextHead('R','Link Items'),
                self.formatTextHead('S','Status'),
                self.formatTextHead('T',''),
            ],
            //comments: [{row: 2, col: 2, comment: "Test comment"}],
            columns: self.model.colType(),
            contextMenu: true,
            rowHeaders: true,
            // fixedRowsTop: 1,
            colWidths: 150,
            // rowHeights: 30,
            manualColumnMove: true,
            manualRowMove: true,
            manualColumnResize: true,
            manualRowResize: true,
            minSpareRows: true,
            filters: true,
            dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
            width: width - 30,
            height: window.outerHeight - 258,
            formulas: true,
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
            
                setTimeout(function(){
                    var limitRow = sheetContent.length;
                    if( 2 == OPDATA.user.meta.user_role ){
                        limitRow = 100;
                    }
                    self.setDataAtCell(limitRow-1,18,'');
                }, 500 );  
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

            afterRenderer: function(td, row, col, prop, value){
                // console.log(row, col);
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
                var cellProperties = {};
                if( 2 == this.instance.sheetStatus && ( 2 == OPDATA.user.meta.user_role || 3 == OPDATA.user.meta.user_role )  ) {
                    cellProperties.readOnly = true;
                }

                if( 17 == col ) {
                    cellProperties.readOnly = false;
                }

                if( 2 == col ) {
                    cellProperties.readOnly = true;
                }

                if( 17 == col && 2 == OPDATA.user.meta.user_role ) {
                    cellProperties.readOnly = true;
                }

                cellProperties.renderer = window.firstRowRenderer;
                return cellProperties;
            }
        });

        Handsontable.hooks.add('afterChange', function(changes) {
            var d = this; 

            if( changes ) {
                if( !d.sheetId ){
                    $.each(changes,function(i,v){
                       // var meta = d.getCellMeta(v[0],v[1]);
                        //$(meta.instance.getCell(v[0],v[1])).css({'background': meta.background, 'color': meta.color});
                        //d.OpDataSheets[ v[0] + '-' + v[1] ] = {status: true, meta: meta};
                    });
                }
            }    
        })

        Handsontable.hooks.add('afterSelectionEnd', function(rst, cst, re, ce) {
            var d = this; 
            var argsCells = new Array;
            for (var i = cst; i <= ce; i++) {
                for (var ii = rst; ii <= re; ii++) {
                    argsCells.push({row : ii, col: i});
                }
            };

            d.opAfterSelectionEnd = argsCells;
            d.dataCellSelect = {rst, cst, re, ce};
       
           // console.log(rst, cst, re, ce);

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

                    if( dataSheet.readOnly && 'true' == dataSheet.readOnly ) {
                        cellProperties.readOnly = true;
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
        })
        $(e.currentTarget).addClass('op-toolbar-menu-button-hover');
    },

    saveSheets: function(e){
        altair_helpers.content_preloader_show();

        var self     = this,
            opData   = new Array,
            saveType = $(e.currentTarget).attr('data-type');

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

    openSendMes: function(){

        var self = this, 
            d = this.opSheet;
        if( 2 == OPDATA.user.meta.user_role ){
            $.each(this.opSheet.opAfterSelectionEnd, function(i, v){

                $(d.getCell(v.row, v.col)).css({'background': ' #85817a'});
                $(d.getCell(v.row, v.col)).css({'color': '#ffffff'});
                d.setCellMeta(v.row, v.col, 'background', ' #85817a');
                d.setCellMeta(v.row, v.col, 'color', '#ffffff');
                d.setCellMeta(v.row, v.col, 'codeId', OPDATA.user.all_info.user_code + '-' + d.sheetId + '-' + window.ATLLIB.makeid() );
                d.setCellMeta(v.row, v.col, 'sheetId', d.sheetId );

                var cellMeta = d.getCellMeta(v.row, v.col);

                d.OpDataSheets[ v.row + '-' + v.col ] = cellMeta;     
            });
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

        if( 0 == $("textarea[name=op_mes_description]").val().length ) {
            UIkit.modal.alert('Please choose receiver!');
            return false;
        }


        metaSelect = this.getCellMetaSelect(d);

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

            setTimeout(function(){
                $('.op-notify-js', self.el).fadeOut();
            }, 2000);
            
        });

        return false;
    },


    getCellMetaSelect: function(d){
        var metaSelect = {};

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

        if( ordererId ) {
            $.each(d.opAfterSelectionEnd, function(i, v){
                var metaCurrent = d.getCellMeta(v.row, v.col);

                $(d.getCell(v.row, v.col)).css({'background': dataUser.user_color});
                $(d.getCell(v.row, v.col)).css({'color': '#ffffff'});

                // Set meta user order
                d.setCellMeta(v.row, v.col, 'background', dataUser.user_color);
                d.setCellMeta(v.row, v.col, 'color', '#ffffff');
                d.setCellMeta(v.row, v.col, 'codeId', metaCurrent.codeId );
                d.setCellMeta(v.row, v.col, 'sheetId', metaCurrent.sheetId );

                var cellMeta = d.getCellMeta(v.row, v.col);

                d.OpDataSheets[ v.row + '-' + v.col ] = cellMeta;    

                // Set user order.
                if( 2 == v.col ) {
                    d.setDataAtCell(v.row, 2, dataUser.user_name);
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


                setTimeout(function(){
                    $('.op-notify-js', self.el).fadeOut();
                    $(".op-save-sheets-js").trigger('click');
                }, 2000);
                
            });
        }

    }
});
new OP_CANCULATOR_MODEL;
OP_CANCULATOR_MODEL;

})(jQuery);