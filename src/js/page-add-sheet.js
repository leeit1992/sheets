/**
 * Handle page admin messages
 *
 * @version 	1.0
 * @author 		HaLe
 * @package 	ATL
 */
(function($) {
	"use strict";
	var OP_ADD_SHEET = Backbone.View.extend({
		el: '#op-page-add-sheet',

		formClassError: 'md-input-danger',

		events: {

		},

		noticeTpl: _.template('<div class="uk-notify-message <%= classes %>">\
								        <a class="uk-close"></a>\
								        <div>\
								           <%= message %>\
								        </div>\
								    </div>'),

		initialize: function() {
			window.ATLLIB.checkAll();
		},


	});
	new OP_ADD_SHEET;
})(jQuery);