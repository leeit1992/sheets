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
			'click .op-massage-accept': 'acceptSheetInbox',
			'click .op-accept-data': 'acceptSheetData',
			'click .op-massage-send-back': 'sheetOrdererSendBack',
			'click .op-massage-cancel': 'cancelOrder',
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

			$('.op-list-current').ready(function(){
				var checkAuto = $("input[name=op_inbox_auto_open]");

				if( 0 < checkAuto.length ) {
					var idBox = checkAuto.val();
					$(".op-mes-item-" + idBox).find('.op-check-message').trigger('click');
					history.pushState('', '', OPDATA.adminUrl +"massages-manage");
				}
			});

			var getUrlParameter = function getUrlParameter(sParam) {
		        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		            sURLVariables = sPageURL.split('&'),
		            sParameterName,
		            i;

		        for (i = 0; i < sURLVariables.length; i++) {
		            sParameterName = sURLVariables[i].split('=');

		            if (sParameterName[0] === sParam) {
		                return sParameterName[1] === undefined ? true : sParameterName[1];
		            }
		        }
		    };

		    var mesIDSocket = getUrlParameter('show');
		    if( typeof mesIDSocket != undefined ) {
		    	var currentBox = $(".op-mes-item-" + mesIDSocket).find('.op-check-message')[0];
        		
		       	setTimeout(function(){
		       		$(currentBox).trigger('click');
		       	},1000)
		    }

		},

		formatTextHead: function(text, text2) {
	        return '<p>'+text+'</p><p>'+text2+'</p>';
	    },

		initInboxSheet : function( id, sheetData ){

			var self = this,
            	$sheet = $('.op-sheet-inbox-show-' + id)[0];
			this.opSheet = new Handsontable($sheet, {
	            readOnly: true,
	            data: sheetData,
	            startRows: 100,
	            rowHeaders: true,
	            colHeaders: true,
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
	            columns: window.ATLLIB.colSheetFormat(),
	            contextMenu: true,
	            rowHeaders: true,
	            colWidths: 150,
	            manualColumnMove: true,
	            manualRowMove: true,
	            manualColumnResize: true,
	            manualRowResize: true,
	            minSpareRows: true,
	            filters: true,
	            width: $("#page_content_inner").width() - 30,
	            height: 300,
	            afterInit: function() {
	            	var self = this;

	            	$("#HandsontableCopyPaste").css('position','absolute');
                	$("#HandsontableCopyPaste").css('top',0);

                	setTimeout(function(){
	                    self.setDataAtCell(sheetData.length,18,'');
	                }, 500 ); 


	            },
	            cells: function (row, col, prop) {
	                var cellProperties = {};

	                if( 18 == col ) {
	                	if( 3 == OPDATA.user.meta.user_role ) {
	                		cellProperties.readOnly = false;
	                	}
	                    
	                }

	                return cellProperties;
	            }
      
	        });
		},
		//OPDATA.user.meta.user_role
		handleForm: function() {
			var self = this,
				data = {
					formData: $('#op-form-messages', this.el).serialize()
				};

			altair_helpers.content_preloader_show();
			$.ajax({
				url: OPDATA.adminUrl + 'write-messages',
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

					socket.emit('notice-inbox', $("select[name=op_receiver]").val() );
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
				url: OPDATA.adminUrl + 'delete-messages',
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
				url: OPDATA.adminUrl + 'delete-messages',
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
				type = $(e.currentTarget).attr('data-type'),
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
				url: OPDATA.adminUrl + 'filter-messages',
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

		checkInbox: function(e) {
			var self = this,
				id = $(e.currentTarget).attr('data-id'),
				mStatus = $(e.currentTarget).attr('data-status'),
				sheetData = $('.op-data-mes-' + id).val(),
				sheetMeta = $('.op-meta-mes-' + id).val();

			if( 0 < sheetData.length ) {
				sheetData = JSON.parse(sheetData);
				this.initInboxSheet(id, sheetData);
			}
			
			$.ajax({
				url: OPDATA.adminUrl + 'update-inbox',
				type: "POST",
				data: {
					id: id,
					mStatus: mStatus,
				},
				success: function(res) {} 
			});
		},

		acceptSheetInbox: function(e){
			var self = this,
				id = $(e.currentTarget).attr('data-id'),
				user_send = $(e.currentTarget).attr('user-send-id'),
				apccetStatus = $(e.currentTarget).attr('apccet-status');
			
			if( 1 == apccetStatus ) {
				$(".uk-close").trigger('click');
				UIkit.modal.alert('This data has been added to personal data.!');
				return false;
			}

			$(".op-accept-data").attr('data-id', id);
			$(".op-accept-data").attr('user-send', user_send);
		},

		acceptSheetData: function(e){
			var self = this,
				id = $(e.currentTarget).attr('data-id'),
				user_send = $(e.currentTarget).attr('user-send');

			altair_helpers.content_preloader_show();

			$.ajax({
				url: OPDATA.adminUrl + 'accept-sheet',
				type: "POST",
				data: {
					mesId: id,
					sheetId: $("select[name=op_sheet_accept]").val(),
				},
				success: function(res) {
					altair_helpers.content_preloader_hide();

					$("#modal_message_" + id).find('.op-massage-accept').attr('apccet-status',1);
					$(".uk-close").trigger('click');
					UIkit.modal.alert('Accept Success!');
					socket.emit('notice-inbox', user_send);
				}
			});
		},

		sheetOrdererSendBack : function(e){
			var self = this,
				id = $(e.currentTarget).attr('data-id');
			altair_helpers.content_preloader_show();
			$.ajax({
				url: OPDATA.adminUrl + 'sendback-inbox',
				type: "POST",
				data: {
					sheetData: JSON.stringify(this.opSheet.getData()),
					mesId : id
				},
				success: function(res) {
					var result = JSON.parse(res);

					if( result.socketId ) {
						$.each(result.socketId, function(i, el){
							socket.emit('notice-inbox', el);
						});
					}

					altair_helpers.content_preloader_hide();
					UIkit.modal.alert('Send back success!');
				} 
			});
		},

		cancelOrder : function(e){
			var self = this,
				user_send = $(e.currentTarget).attr('user-send'),
				id = $(e.currentTarget).attr('data-id');

			altair_helpers.content_preloader_show();

			$.ajax({
				url: OPDATA.adminUrl + 'cancel-order',
				type: "POST",
				data: {
					mesId : id
				},
				success: function(res) {
					altair_helpers.content_preloader_hide();
					UIkit.modal.alert('Cancel success!');
					socket.emit('notice-inbox', user_send);
					$(".uk-close").trigger('click');
				} 
			});

		}

	});
	new OP_MESSAGES;
})(jQuery);