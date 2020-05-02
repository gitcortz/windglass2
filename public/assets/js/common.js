(function ($) {
    if (!$) {
        return;
    }
    
    $.fn.serializeFormToObject = function() {
        var $form = $(this);
        var fields = $form.find('[disabled]');
        fields.prop('disabled', false);
        var json = $form.serializeJSON();
        fields.prop('disabled', true);
        return json;
    };
})(jQuery);

var ajaxcall = function(type, url, data, success, error) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: type,
        url: url,
        data: data,
        dataType: 'json',
        success: success,
        error: error
    });
};


var uploadcall = function(type, url, data, success, error) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: type,
        url: url,
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        success: success,
        error: error
    });
};

var formatDateYYYYMMDD = function(d){
    date = [
        d.getFullYear(),
        ('0' + (d.getMonth() + 1)).slice(-2),
        ('0' + d.getDate()).slice(-2)
      ].join('-');
    return date;
}

var toDateOnly = function(d){
    return d.substring(0, 10);
}