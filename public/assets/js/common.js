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

var initialBranches = function() {
    ajaxcall("GET", "/branches/session", null, 
    function(data) {
        var branches = data.data;
        for(var i=0; i<branches.length; i++){
            $("#header_branch_selection").append("<option value='" + branches[i].branch_id + "' " +(data.selected == branches[i].branch_id ? "selected":"")+ " >"+branches[i].branch.name+"</option>"); 
        }
        
        $('#header_branch_selection').change(function() {
            switchBranch( $(this).find(":selected").val() );
        });
    }, 
    function(e) {
        console.log(e);
    });

   
}

var switchBranch = function(id){
    ajaxcall("GET", "/branches/switch/"+id, null, 
    function(data) {
        if (data.result) {
            location.href = location.href;
        }
    }, 
    function(e) {
        console.log(e);
    });
}


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
};

var toDateOnly = function(d){
    return d.substring(0, 10);
};


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

    initialBranches();

})(jQuery);
