/**
 * Handle page admin user
 *
 * @version 	1.0
 * @author 		HaLe
 * @package 	ATL
 */
(function($) {
	"use strict";
	var ATL_USER = Backbone.View.extend({
		el: '#op-login-page',

		formClassError: 'md-input-danger',

		events: {
			'submit #op-register-user': 'handleForm',
		
		},

		errorFormTpl: _.template('<div class="uk-notify-message <%= classes %>">\
								        <a class="uk-close"></a>\
								        <div>\
								           <%= message %>\
								        </div>\
								    </div>'),

		initialize: function() {
			
		},

		/**
		 * handleForm
		 * Handle form submit user
		 * @return void
		 */
		handleForm: function(event) {
			var self = this,
				$formData = $(".atl-required-js", this.el),
				error = new Array();

			$.each($formData, function(index, el) {
				var getValInput = $(el).val();

				if ('email' === $(el).attr('type')) {
					if (false === ATLLIB.validateEmail(getValInput)) {
						$(el).addClass(self.formClassError);
						error.push(index);
					} else {
						$(el).removeClass(self.formClassError);
						error.splice(index, 1);
					}
				}

				if (0 === getValInput.length) {
					$(el).addClass(self.formClassError);
					error.push(index);
				} else {
					$(el).removeClass(self.formClassError);
					error.splice(index, 1);
				}
			});

			var formUserPass = $('input[name=register_password]', this.el),
				formUserCfPass = $('input[name=register_password_repeat]', this.el);

			if (0 === formUserPass.val().length || (formUserPass.val() != formUserCfPass.val())) {

				formUserPass.addClass(self.formClassError);
				formUserCfPass.addClass(self.formClassError);
				error.push(1);
			} else {
				formUserPass.removeClass(self.formClassError);
				formUserCfPass.removeClass(self.formClassError);
			}

			if (0 === error.length) {
				this.handleUser(event);
				return false;
			} else {
				return false;
			}
		},

		handleUser: function(event) {

			var self = this,
				formdata = $('#op-register-user', this.el).serialize();

			altair_helpers.content_preloader_show();

			$.ajax({
				url: OPDATA.adminUrl + '/register-user',
				type: "POST",
				data: { formdata: formdata },
				success: function(res) {
					altair_helpers.content_preloader_hide();
					var dataResult = JSON.parse(res);
					UIkit.modal.alert(dataResult.output);
					// if (false === dataResult.status) {

					// 	var output = '';
					// 	$.each(dataResult.message, function(i, el) {
					// 		output += self.errorFormTpl({
					// 			message: el,
					// 			classes: 'uk-notify-message-danger'
					// 		});
					// 	});

					// 	$('.atl-notify-js', self.el).html(output).show();
					// 	setTimeout(function() {
					// 		$('.atl-notify-js', self.el).fadeOut();
					// 	}, 3000);
					// } else {
					// 	window.location = location.href = '';
					// }

				}
			});

		}
	});
	new ATL_USER;

})(jQuery);