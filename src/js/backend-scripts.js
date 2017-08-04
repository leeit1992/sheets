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
    }
}

$(document).on('click', '.op-check-message', function(){
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