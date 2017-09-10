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
		el: '#atl-page-handle-user',

		formClassError: 'md-input-danger',

		events: {
			'submit #atl-form-user': 'handleForm',
			'click .atl-manage-user-filter-js li': 'handleFilterByRole',
			'click .atl-manage-user-delete-js': 'removeUser',
			'click .atl-action-apply-js': 'actionManage',
			'keyup .atl-user-manage-search-js': 'searchManage',
		},

		errorFormTpl: _.template('<div class="uk-notify-message <%= classes %>">\
								        <a class="uk-close"></a>\
								        <div>\
								           <%= message %>\
								        </div>\
								    </div>'),

		initialize: function() {
			var self = this;
			$(window).load(function() {
				var message = $('.atl-notify-js', self.el).attr('data-notify');

				if (message) {
					var output = self.errorFormTpl({
						message: message,
						classes: 'uk-notify-message-success'
					});
					$('.atl-notify-js', self.el).html(output).show();

					setTimeout(function() {
						$('.atl-notify-js', self.el).fadeOut();
					}, 3000)
				}
			});

			ATLLIB.checkAll(this.el);

			// Change color background for cell
            $(".op-user-color").spectrum({
                showPalette: true,
			    palette: [
			        ['black', 'white', 'blanchedalmond'],
			        ['rgb(255, 128, 0);', 'hsv 100 70 50', 'lightyellow']
			    ],
			    change: function(color) {
			    	$('.op-user-color').val(color.toHexString());
				}

            });
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

			var formUserPass = $('input[name=atl_user_pass]', this.el),
				formUserCfPass = $('input[name=atl_user_cf_pass]', this.el);

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
				file = $('input[name=atl_user_avatar]', this.el)[0].files[0],
				formdata = new FormData();

			formdata.append("avatar", file);
			formdata.append("formData", $('#atl-form-user', this.el).serialize());

			altair_helpers.content_preloader_show();
			$.ajax({
				url: OPDATA.adminUrl + 'validate-user',
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function(res) {
					altair_helpers.content_preloader_hide();
					var dataResult = JSON.parse(res);

					if (false === dataResult.status) {

						var output = '';
						$.each(dataResult.message, function(i, el) {
							output += self.errorFormTpl({
								message: el,
								classes: 'uk-notify-message-danger'
							});
						});

						$('.atl-notify-js', self.el).html(output).show();
						setTimeout(function() {
							$('.atl-notify-js', self.el).fadeOut();
						}, 3000);
					} else {
						window.location = location.href = OPDATA.adminUrl + 'edit-user/' + dataResult.id;
					}

				}
			});

		},

		handleFilterByRole: function(e) {
			var self = this;
			altair_helpers.content_preloader_show();
			$(".atl-manage-user-filter-js li", this.el).each(function(index, el) {
				$(el).removeClass('uk-active');
			});

			$(e.currentTarget).addClass('uk-active');

			var data = {
				getBy: "role",
				roleStatus: $('a', e.currentTarget).attr('data-role')
			};

			$.get(OPDATA.adminUrl + 'ajax-manage-user', data, function(result) {

				var dataResult = JSON.parse(result);
				$(".atl-list-user-js", self.el).html(dataResult.output);
				$(".atl-list-user-not-js", self.el).hide();
				altair_helpers.content_preloader_hide();
			});

			return false;
		},

		removeUser: function(e) {

			var dataID = $(e.currentTarget).attr('data-id');

			UIkit.modal.confirm('Are you sure?', function() {
				var data = {
					id: dataID
				};
				$.post(OPDATA.adminUrl + 'delete-user', data, function(result) {

					$(e.currentTarget).closest('tr').remove();

					UIkit.modal.alert('Delete Success!');
				});
			})
			return false;
		},

		/**
		 * Handle remove multi user
		 * 
		 * @return void
		 */
		actionManage: function(e) {

			// Get action.
			var action = $(e.currentTarget).closest('.atl-action-manage').find("select[name=atl-action-manage]").val();
			var argsID = new Array;

			if ('delete' == action) {
				altair_helpers.content_preloader_show();

				// Get list id remove checked.
				$(".atl-checkbox-child-js", this.el).each(function() {
					if (this.checked) {
						argsID.push($(this).val());
					}
				})

				// Send to server handle.
				var data = {
					id: argsID
				};
				$.post(OPDATA.adminUrl + 'delete-user', data, function(result) {
					var dataResult = JSON.parse(result);
					$.each(argsID, function(i, el) {
						$(".atl-user-item-" + el).remove();
					})

					altair_helpers.content_preloader_hide();

					if (dataResult.status) {
						UIkit.modal.alert('Delete Success!');
					} else {
						UIkit.modal.alert('Delete False!');
					}
				});
			} else {
				UIkit.modal.alert('Please choose Action!');
			}
		},

		/**
		 * Handle search user
		 * 
		 * @return void
		 */
		searchManage: function(e) {
			var keyup = $(e.currentTarget).val(),
				data = {
					getBy: "search",
					keyup: keyup
				};

			if (0 < keyup.length) {
				$(".atl-list-user-not-js", this.el).fadeOut();
				$(".atl-list-user-js", this.el).fadeIn();
				altair_helpers.content_preloader_show();
			} else {
				$(".tl-list-user-not-js", this.el).fadeIn();
				$(".tl-list-user-js", this.el).fadeOut();
				altair_helpers.content_preloader_hide();
			}

			$.get(OPDATA.adminUrl + 'ajax-manage-user', data, function(result) {
				var dataResult = JSON.parse(result);
				$(".atl-list-user-js", self.el).html(dataResult.output);
				altair_helpers.content_preloader_hide();
			});

		}
	});
	new ATL_USER;

})(jQuery);