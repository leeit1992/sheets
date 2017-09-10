(function($) {

    window.ATLLIB = {
        validateEmail: function(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        fileReader: function(event, appendTo = '') {
            var file = event.target.files[0];

            if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    // The file's text will be printed here
                    $(appendTo).attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        },
        checkAll: function($el = null) {
            $(".atl-checkbox-primary-js", $el).change(function() {
                if (this.checked) {
                    $(".atl-checkbox-child-js", $el).each(function(index, el) {
                        $(el).prop('checked', true)
                    });
                } else {
                    $(".atl-checkbox-child-js", $el).each(function(index, el) {
                        $(el).prop('checked', false)
                    });
                }
            });

            return false;
        },
        makeid: function() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 5; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        },

        colSheetFormat: function(){
            return [
                { // User Code
                    editor: 'select',
                    selectOptions: [OPDATA.user.all_info.user_code]
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
        }
    }

    socket.on('user-' + OPDATA.user.id, function(data) {
        $.ajax({
            url: OPDATA.adminUrl + 'autoload-inbox',
            type: "GET",
            data: {
                userId: OPDATA.user.id,
            },
            success: function(result) {
                var dataResult = JSON.parse(result);
                $(".op-number-notice").text(dataResult.length);

                $(".op-list-notice-box").html('');
                $("#op-list-message-notice").html('');
                
                $.each(dataResult, function(i, el) {
                    var inboxLink = OPDATA.adminUrl + 'massages-manage?show=' + el.id;
                    if( 'notice' == el.op_type ) {
                        inboxLink = OPDATA.adminUrl + 'message-notice?show=' + el.id;
                    }

                    $(".op-list-notice-box").append('\
                    <li>\
                        <div class="md-list-addon-element">\
                            <a href="'+inboxLink+'" class="user_action_image">\
                                <img class="md-user-image" style="height: 34px;" src="'+el.user_avatar+'" alt="">\
                            </a>\
                        </div>\
                        <div class="md-list-content">\
                            <a href="'+inboxLink+'">\
                                <span class="md-list-heading">'+el.user_name+'.</span>\
                                <span class="uk-text-small uk-text-muted">'+el.op_message_title+'.</span>\
                            </a>\
                        </div>\
                    </li>\
                    ');
                });

                $("body").append('<audio src="' + OPDATA.adminUrl + 'public/audio/newnotice.mp3" autoplay></audio>');
            }
        });
    });
   

})(jQuery);