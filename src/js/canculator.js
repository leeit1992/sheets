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
            this.set(
                'sheetData',
                [
                ]
            );
        }
        this.createView();
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

        $('.op-fx--input input').bind('paste',function(e) {
           console.log(e.originalEvent.clipboardData.getData('text/html'));
        });
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

    canculatorConfig: function(sheetId, width) {

        var self = this,
            $sheet = $('#op-sheet-' + sheetId)[0];
        this.setColor();

        this.opSheet = new Handsontable($sheet, {
            // readOnly: true,
            //data: this.model.get('sheetData'),

            startRows: 100,
      
            contextMenu: true,
            rowHeaders: true,
            colHeaders: [
                'Ngày/Tháng', 'Người Mua', 'Người Order', 'Tên Mặt Hàng',
                'Mã Hàng', 'Size', 'Mầu', ' Số Lượng', 'Giá Web', 'Giảm Giá', 'Giá Order', 'Sau Thuế',
                'Ship Web', 'Tổng', 'Giá VNĐ', 'Bill Order', 'Tracking Number', 'Link Hàng'
            ],
            colWidths: 100,
            // columns: [
            //   {
            //     data: 'Ngày/Tháng',
            //     editor: false
            //   }
            // ],
            manualColumnMove: true,
            manualRowMove: true,
            manualColumnResize: true,
            manualRowResize: true,
            minSpareRows: true,

            width: width - 30,
            height: window.outerHeight - 258,

            afterInit: function(datsa) {
                var self = this;
                $(".wtHolder", this.container).addClass('op-scroll');
                this.OpDataSheets = {};

                var $sheetId = $("#op_sheet_id", this.el);

                if( 0 !== $sheetId.length ) {
                    this.sheetId = $sheetId.val();

                    var sheetContent = $("#op_sheet_data", this.el);
                    this.OpDataSheets = JSON.parse( sheetContent.val() );

                    $.each(self.OpDataSheets, function(i, el){
                        var valueDefault = el.default[3];
                        // Check value row. set value row if null.
                        if( null == el.default[3] ) {
                            valueDefault = ' '
                        }

                        self.setDataAtCell(el.default[0], el.default[1], valueDefault);
                    });
                }
            
                setTimeout(function(){
                    self.setDataAtCell(100,18,'');
                }, 500 );
                
            },

            // afterSelection: function (row, col, row2, col2) {
            //     var meta = this.getCellMeta(row2, col2);

            //     if (meta.readOnly) {
            //         this.updateSettings({fillHandle: false});
            //     }
            //     else {
            //         this.updateSettings({fillHandle: true});
            //     }
            // },
            cells: function (row, col, prop) {
                var cellProperties = {};
                cellProperties.renderer = window.firstRowRenderer;
                return cellProperties;
            }
        });
 

        Handsontable.hooks.add('afterChange', function(changes) {
            var d = this; 

            if( changes ) {
                if( !d.sheetId ){
                    $.each(changes,function(i,v){
                        var meta = d.getCellMeta(v[0],v[1]);
                        $(meta.instance.getCell(v[0],v[1])).css({'background': meta.background, 'color': meta.color});
                        d.OpDataSheets[ v[0] + '-' + v[1] ] = {default: v, meta: meta};
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

                    /**
                     * Set default data event select row
                     */
                    if( null == d.getDataAtCell(ii, i) ) {
                        d.setDataAtCell(ii, i,' ');

                        d.OpDataSheets[ii + '-' + i] = { default: [ii, i, null, d.getDataAtCell(ii, i)], meta: d.getCellMeta(ii, i)};
                    }
                }
            };

            // Change color background for cell
            $(".op-bg-cell-color").spectrum({
                color: "#f00",
                move: function(color) {
                    $.each(argsCells,function(i,v){

                        /**
                         * Set style after change.
                         */
                        $(d.getCell(v.row, v.col)).css({'background': color.toHexString()});
                        d.setCellMeta(v.row, v.col, 'background', color.toHexString());

                        if( null != d.getDataAtCell(v.row, v.col) ) {
                            if( undefined !== d.OpDataSheets[ v.row + '-' + v.col ] ) {
                                d.OpDataSheets[ v.row + '-' + v.col ].meta = d.getCellMeta(v.row, v.col);
                            }
                        }
                    });
                }
            });

            // Change text color for cell
            $(".op-text-cell-color").spectrum({
                color: "#f00",
                move: function(color) {
                    $.each(argsCells,function(i,v){
                        $(d.getCell(v.row, v.col)).css({'color': color.toHexString()});
                        d.setCellMeta(v.row, v.col, 'color',color.toHexString());
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
                    td.style.color      = dataSheet.meta.color;
                    td.style.background = dataSheet.meta.background;;
                }
            }
  
        }

        // function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties) {
        //     Handsontable.renderers.TextRenderer.apply(this, arguments);

        //     // if row contains negative number
        //     if (parseInt(value, 10) < 0) {
        //         // add class "negative"
        //         td.className = 'make-me-red';
        //     }

        //     if (!value || value === '') {
        //         td.style.background = '#EEE';
        //     } else {
        //         if (value === 'Nissan') {
        //             td.style.fontStyle = 'italic';
        //         }
        //         td.style.background = '';
        //     }
        // }

        // Handsontable.renderers.registerRenderer('negativeValueRenderer', negativeValueRenderer);
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

    saveSheets: function(){
        altair_helpers.content_preloader_show();

        var self   = this,
            opData = new Array;

        $.each(this.opSheet.OpDataSheets, function(e,v){
            v.meta.instance  = undefined;
            v.meta.prop      = undefined;
            v.meta.visualCol = undefined;
            v.meta.visualRow = undefined;
        });

        var data = {
            sheetTitle: $('input[name=op_sheet_title]').val(),
            sheetMessage: $('textarea[name=op_sheet_message]').val(),
            sheetData: JSON.stringify(this.opSheet.OpDataSheets)
        };

        $.post(OPDATA.adminUrl + 'save-sheets' ,data, function(){
            altair_helpers.content_preloader_hide();

            self.opSheet.updateSettings({
                readOnly: true, // make table cells read-only
                cells: function (row, col, prop) {
                    var cellProperties = {};
                    cellProperties.readOnly = true; 
                    cellProperties.renderer = window.firstRowRenderer;
                    return cellProperties;
                }
            });

            var output = self.noticeTpl({
                message: 'Send sheet success.',
                classes: 'uk-notify-message-success'
            });
            $('.op-notify-js', self.el).html(output).show();
            $("#style_switcher").removeClass('switcher_active');

            setTimeout(function(){
                $('.op-notify-js', self.el).fadeOut();
            }, 2000);
            
        });

        return false;
    }
});
new OP_CANCULATOR_MODEL;
OP_CANCULATOR_MODEL;

})(jQuery);