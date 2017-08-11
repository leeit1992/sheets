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
                    ];
        }
    }

    if( undefined != typeof socket ) {
        socket.on('user-' + OPDATA.user.id, function(data) {
            $.ajax({
                url: OPDATA.adminUrl + '/autoload-inbox',
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
                        $(".op-list-notice-box").append('\
                        <li>\
                            <div class="md-list-addon-element">\
                                <a href="#" class="user_action_image">\
                                    <img class="md-user-image" style="height: 34px;" src="'+el.user_avatar+'" alt="">\
                                </a>\
                            </div>\
                            <div class="md-list-content">\
                                <a class="op-check-message" data-id="'+el.id+'" data-uk-modal="{target:\'#modal_message_head_'+el.id+'\'}" href="#">\
                                    <span class="md-list-heading">'+el.user_name+'.</span>\
                                    <span class="uk-text-small uk-text-muted">'+el.op_message_title+'.</span>\
                                </a>\
                            </div>\
                        </li>\
                        ');
                        
                        $("#op-list-message-notice").append('\
                            <div class="uk-modal" id="modal_message_head_'+el.id+'">\
                                <div class="uk-modal-dialog">\
                                    <div class="uk-modal-header">\
                                        <h3 class="uk-modal-title"><i class="material-icons md-24">&#xE554;</i> '+el.op_message_title+'</h3></h3>\
                                    </div>\
                                    <p>'+el.op_messages+'</p>\
                                    <div>\
                                        <p><i class="uk-icon-file-excel-o"></i> <a target="_blank" href="'+el.linkSheet+'">File Sheet</a></p>\
                                    </div>\
                                    <div class="uk-modal-footer uk-text-right">\
                                        <a class="md-btn md-btn-flat op-massage-forward" href="'+el.linkInbox+'">Goto Inbox </a>\
                                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>\
                                    </div>\
                                </div>\
                            </div>\
                        ');
                    });

                    $("body").append('<audio src="' + OPDATA.adminUrl + '/public/audio/newnotice.mp3" autoplay></audio>');
                }
            });
        });
    }
    

    $(document).on('click', '.op-check-message', function() {
        var self = this,
            id = $(this).attr('data-id');

        $.ajax({
            url: OPDATA.adminUrl + '/update-inbox',
            type: "POST",
            data: {
                id: id,
            }
        });
    });

})(jQuery);