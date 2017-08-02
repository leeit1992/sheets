/**
 * Handle page admin messages
 *
 * @version 	1.0
 * @author 		HaLe
 * @package 	ATL
 */
(function($) {
	"use strict";
	var OP_MESSAGES = Backbone.View.extend({
		el: '#op-page-handle-massages',

		formClassError: 'md-input-danger',

		events: {
			'submit #op-form-messages': 'handleForm',
			'click .op-massages-rm-js': 'removeMessage',
			'click .op-remove-all-mes': 'removeAllMessage',
			'click .op-check-message': 'checkInbox',
			'click .op-massage-forward': 'getDataForward',
			'change .op-mes-search, .op-mes-filter-by-user, .op-mes-filter-by-date': 'filterMessages'
		},

		noticeTpl: _.template('<div class="uk-notify-message <%= classes %>">\
								        <a class="uk-close"></a>\
								        <div>\
								           <%= message %>\
								        </div>\
								    </div>'),

		initialize: function() {
			var $mailbox = $("#mailbox");
			$("#mailbox_select_all").on("ifChanged", function() {
				var i = $(this);
				$mailbox.find("[data-md-icheck]").each(function() {
					$(this).iCheck(i.is(":checked") ? "check" : "uncheck")
				})
			});
		},

		handleForm: function() {
			var self = this,
				data = {
					formData: $('#op-form-messages', this.el).serialize()
				};

			altair_helpers.content_preloader_show();
			$.ajax({
				url: OPDATA.adminUrl + '/write-messages',
				type: "POST",
				data: data,
				success: function(res) {
					altair_helpers.content_preloader_hide();
					//var dataResult = JSON.parse( res );

					$(".uk-close").trigger('click');

					var output = self.noticeTpl({
						message: 'Send messages success.',
						classes: 'uk-notify-message-success'
					});

					$('.op-notify-js', self.el).html(output).show();

					setTimeout(function() {
						$('.op-notify-js', self.el).fadeOut();
					}, 2000);

				}
			});

			return false;
		},

		removeMessage: function(e) {
			var self = this,
				mesId = $(e.currentTarget).attr('data-id'),
				rmtype = $(e.currentTarget).attr('data-rm'),
				parrent = $('.op-mes-item-' + mesId);

			$.ajax({
				url: OPDATA.adminUrl + '/delete-messages',
				type: "POST",
				data: {
					id: mesId,
					type: rmtype
				},
				success: function(res) {
					parrent.remove();
					UIkit.modal.alert('Delete Success!');
				}
			});
		},

		removeAllMessage: function(e) {
			var self = this,
				mesId = new Array,
				rmtype = $(e.currentTarget).attr('data-rm'),
				parrent = $(e.currentTarget).closest('li');

			$(".op-message-check", this.el).each(function(i, el) {
				if (el.checked) {
					mesId.push($(el).val());
				}
			});

			$.ajax({
				url: OPDATA.adminUrl + '/delete-messages',
				type: "POST",
				data: {
					id: mesId,
					type: rmtype
				},
				success: function(res) {
					$(parrent).remove();
					$.each(mesId, function(i, el) {
						$('.op-mes-item-' + el).remove();
					})
					UIkit.modal.alert('Delete Success!');
				}
			});
		},

		filterMessages: function(e) {
			var self = this,
				value = $(e.currentTarget).val(),
				type  = $(e.currentTarget).attr('data-type'),
				typeMes = $(e.currentTarget).attr('data-type-mes');

			if (0 < value.length) {
				$(".op-list-current", this.el).fadeOut();
				$(".op-list-result", this.el).fadeIn();
				altair_helpers.content_preloader_show();
			} else {
				$(".op-list-result", this.el).fadeIn();
				$(".op-list-current", this.el).fadeOut();
				altair_helpers.content_preloader_hide();
			}

			$.ajax({
				url: OPDATA.adminUrl + '/filter-messages',
				type: "GET",
				data: {
					value: $(e.currentTarget).val(),
					type: type,
					typeMes: typeMes,
				},
				success: function(res) {
					var dataResult = JSON.parse(res);
					$(".op-list-result", self.el).html(dataResult.data);

					altair_form_adv.masked_inputs();
					altair_helpers.content_preloader_hide();
				}
			});
		},

		checkInbox: function(e){
			var self = this,
				id  = $(e.currentTarget).attr('data-id');

				$.ajax({
				url: OPDATA.adminUrl + '/update-inbox',
				type: "POST",
				data: {
					id: id,
				},
				success: function(res) {
				}
			});
		},

		getDataForward: function(e){
			var self = this,
				id  = $(e.currentTarget).attr('data-id'),
				dataMes = $('.op-data-mes-'+id).val();

				dataMes = JSON.parse(dataMes);

				console.log(dataMes);
		}

	});
	new OP_MESSAGES;
})(jQuery);