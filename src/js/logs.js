/**
 * Handle page admin user
 *
 * @version 	1.0
 * @author 		HaLe
 * @package 	ATL
 */
(function($) {
	"use strict";
	var OP_LOGS = Backbone.View.extend({
		el: '#atl-page-handle-logs',

		formClassError: 'md-input-danger',

		events: {
			'change .op-log-filter' : 'filterByUser',
			'click .op-remove-log' : 'deleteLog',
			'click .op-clear-log' : 'clearLogs',
		},

		errorFormTpl: _.template('<div class="uk-notify-message <%= classes %>">\
								        <a class="uk-close"></a>\
								        <div>\
								           <%= message %>\
								        </div>\
								    </div>'),

		initialize: function() {},

		filterByUser: function(e){
			var self = this,
				key = $(e.currentTarget).val(),
				type = $(e.currentTarget).attr('data-type');

			$.ajax({
				url: OPDATA.adminUrl + 'filter-logs',
				type: "GET",
				data: {
					key: key,
					type: type,
				},
				success: function(res) {
					var dataResult = JSON.parse(res);

					$(".op-logs-items").html('');

					$.each(dataResult.data, function(i, el){
						$(".op-logs-items").append('\
								<tr class="op-log-item-'+el.id+'">\
                                    <td>'+el.logs+'</td>\
                                    <td class="uk-text-nowrap">\
                                        <a  class="op-remove-log" data-id="'+el.id+'" href="#"><i class="material-icons md-24">&#xE872;</i></a>\
                                    </td>\
                                </tr>'
                        );
					});
				}
			});
		},

		deleteLog: function(e){
			var self = this,
				id = $(e.currentTarget).attr('data-id');

			$.ajax({
				url: OPDATA.adminUrl + 'remove-log',
				type: "POST",
				data: {
					id: id,
				},
				success: function(res) {
					$(".op-log-item-"+id).remove();
					UIkit.modal.alert('Delete Success!');
				}
			});
		},

		clearLogs: function(){
			$.ajax({
				url: OPDATA.adminUrl + 'clear-logs',
				type: "POST",
				data: {
					type: 'clear',
				},
				success: function(res) {
					$(".op-logs-items").html('');
					UIkit.modal.alert('Clear Logs Success!');
				}
			});
		}

	});
	new OP_LOGS;

})(jQuery);