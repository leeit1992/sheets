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
                    ['', 'Kia', 'Nissan', 'Toyota', 'Honda'],
                    ['2014', -5, '', 12, 13],
                    ['2015', '', -11, 14, 13],
                    ['2016', '', 15, -12, 'readOnly']
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

    opSheet: null,

    events: {
        'click .op-add-canculator-js': 'addCanculator',
        'mouseover .op-toolbar-menu-button': 'hoverButtonEditor'
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

        this.opSheet = new Handsontable($sheet, {
            // readOnly: true,
            // data: data,
            startRows: 200,
            startCols: 26,
            contextMenu: true,
            rowHeaders: true,
            colHeaders: true,
            manualColumnMove: true,
            manualRowMove: true,
            manualColumnResize: true,
            manualRowResize: true,
            minSpareRows: true,
            width: width - 30,
            height: window.outerHeight - 258,
            afterInit: function() {
                console.log(this);

                $(".wtHolder", this.container).addClass('op-scroll');
            },
            afterSelection: function(row, col, row2, col2) {}
        });
    },

    fixWidthCanculator: function() {
        var sheetsWidth = this.model.get('sheetsWidth');
        this.opSheet.updateSettings({
            width: sheetsWidth
        });
    },

    initialize: function() {
        this.listenTo(this.model, 'change', this.render);
        this.listenTo(this.model, 'change', this.fixWidthCanculator);
        this.reizeContentCanculator();
        this.render();

        $(".custom").spectrum({
            color: "#f00"
        });

        var $switcher = $('#style_switcher'),
            $switcher_toggle = $('#style_switcher_toggle');

        $switcher_toggle.click(function(e) {
            e.preventDefault();
            $switcher.toggleClass('switcher_active');
        });

        // var data = 
        //   [
        //       ['', 'Kia', 'Nissan', 'Toyota', 'Honda'],
        //       ['2014', -5, '', 12, 13],
        //       ['2015', '', -11, 14, 13],
        //       ['2016', '', 15, -12, 'readOnly']
        //     ];
        //  var self = this,
        //     $$ = function(id) {
        //       return document.getElementById(id);
        //     },
        //     container = $('#op-sheet-1')[0],
        //     exampleConsole = $$('example1console'),
        //     autosave = $$('autosave'),
        //     load = $$('load'),
        //     save = $$('save'),
        //     autosaveNotification;
        //  console.log(container);
        //  this.setColor();

        //      this.hot = new Handsontable(container, {
        //              // readOnly: true,
        //              data: data,
        //          startRows: 25,
        //          startCols: 26,
        //          contextMenu: true,
        //          rowHeaders: true,
        //          colHeaders: true,
        //          manualColumnMove: true,
        //          manualRowMove: true,
        //          manualColumnResize: true,
        //              manualRowResize: true,
        //              minSpareRows: true,
        //              width: window.outerWidth - 50,
        //                  height: window.outerHeight - 200,
        //                  afterSelection: function (row, col, row2, col2) {
        //            var meta = this.getCellMeta(row2, col2);

        //            if (meta.readOnly) {
        //              this.updateSettings({fillHandle: false});
        //            }
        //            else {
        //              this.updateSettings({fillHandle: true});
        //            }
        //          },
        //                  cells: function (row, col, prop) {
        //            var cellProperties = {};

        //            if (row === 0 || this.instance.getData()[row][col] === 'readOnly') {
        //              cellProperties.readOnly = true; // make cell read-only if it is first row or the text reads 'readOnly'
        //            }
        //            if (row === 0) {
        //              cellProperties.renderer = window.firstRowRenderer; // uses function directly
        //            }
        //            else {
        //              cellProperties.renderer = "negativeValueRenderer"; // uses lookup map
        //            }

        //            return cellProperties;
        //          }
        //  });

        // Handsontable.dom.addEvent(save, 'click', function() {
        //      console.log( this.hot.getData() );  
        // });

    },

    setColor: function() {
        window.firstRowRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.fontWeight = 'bold';
            td.style.color = 'green';
            td.style.background = '#CEC';
        }
        function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);

            // if row contains negative number
            if (parseInt(value, 10) < 0) {
                // add class "negative"
                td.className = 'make-me-red';
            }

            if (!value || value === '') {
                td.style.background = '#EEE';
            } else {
                if (value === 'Nissan') {
                    td.style.fontStyle = 'italic';
                }
                td.style.background = '';
            }
        }

        Handsontable.renderers.registerRenderer('negativeValueRenderer', negativeValueRenderer);
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


            }, 300)
        });
    },

    hoverButtonEditor: function(e) {
        $('.op-toolbar-menu-button').each(function() {
            $(this).removeClass('op-toolbar-menu-button-hover');
        })
        $(e.currentTarget).addClass('op-toolbar-menu-button-hover');
    }
});
new OP_CANCULATOR_MODEL;
OP_CANCULATOR_MODEL;

})(jQuery);