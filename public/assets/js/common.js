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