$(document).ready(function() {
    var crud = new Crud();
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "name", name : "name"},
            {data: "action_btns", name : "action_btns"},
        ], function(e) {
            $('.nav-tabs a[href="#tab_1"]').tab('show');
            data = e.data
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=name]").val(data.name);
            form.find("input[name=email]").val(data.email);
            $("#role").val(e.role_id);
            init_user_branches(crud, data.id);

        }
    );
    crud.set_addModalCallBack(function() {    
        $('.nav-tabs a[href="#tab_1"]').tab('show');
    });
    init_branch_selection(crud,);
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
    });

});
function init_user_branches(crud, id) {
    $('.chkuserbranches').iCheck('uncheck');
    $('.chkuserbranches').iCheck('update');
    crud.ajaxcall("GET", "/v2/users/"+id+"/branches", null, 
    function(data) {
        var userbranches = data;
        for(var i=0; i<userbranches.length; i++){
            $('#branch_'+userbranches[i].branch_id).iCheck('check');
        }
    }, 
    function(e) {
        console.log(e);
    });
}

function init_branch_selection(crud) {
    
    crud.ajaxcall("GET", "/v2/branches/all", null, 
        function(data) {
            var branch_checkbox = '<div class="col-md-4 mt-1"><label>'+
                                '<input type="checkbox" class="chkuserbranches" id="branch_{BRANCH_ID}" name="branch[]" value="{BRANCH_ID}">'
                                +'&nbsp;{BRANCH_NAME}</label></div>';

            var _branch_selection = $('#branch_selection');
            var branches = data.data;
            for(var i=0; i<branches.length; i++){
                _branch_selection.append($(branch_checkbox
                        .replace(new RegExp("{BRANCH_ID}", 'g'), branches[i].id)
                        .replace("{BRANCH_NAME}", branches[i].name)
                        
                    ));
            }
            $('.chkuserbranches').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass   : 'iradio_flat-green'
            });              
        }, 
        function(e) {
            console.log(e);
        });
}
