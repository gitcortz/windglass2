var _mv_container = $('#dataTableLoan');
var _mv_datatable;
//var _mvform_add = $('#loanform-add');
//var _mvmodal_add = $('.modal-add');

var _mvform = $('#mvform-addupdate');
var _mvmodal = $('.mvmodal-addupdate');
var _mv_errors = $('#mv-error-list');
var _mv_error_bag = $('#mv-error-bag');
var _stock_id = 0;

var crud = new Crud();
$(document).ready(function() {
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "branch", name : "branch"},
            {data: "product", name : "product"},
            {data: "producttype", name : "producttype"},
            {data: "initial_stock", name : "initial_stock"},
            {data: "current_stock", name : "current_stock"},
            {data: "status", name : "status"},
            {data: "action_btns", name : "action_btns"},
        ], function(data) { 
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=branch_id]").val(data.branch_id);
            form.find("input[name=product_id]").val(data.product_id);
            form.find("input[name=initial_stock]").val(data.initial_stock);
            form.find("input[name=current_stock]").val(data.current_stock);
            form.find("input[name=stock_status_id]").val(data.stock_status_id);
            form.find("#branch").val(data.branch_id);
            form.find("#product").val(data.product_id);
            form.find("#branch").prop( "disabled", true );
            form.find("#product").prop( "disabled", true );
            form.find("input[name=initial_stock]").prop( "disabled", true );
            form.find("input[name=current_stock]").prop( "disabled", true );
            $('.stockName').html(form.find("#product option:selected").html());
            init_mv(data.id);
            _stock_id = data.id;
            _branch_id = data.branch_id;
        }
    );
    //init_datatable
    init_dropdown(crud);

    
    $("#btn-save-movement").click(function() {
        var data = _mvform.serializeFormToObject();
        console.log(data);
        ajaxcall("POST", "/stocks/add_movement", data, mv_updateSuccess, updateError);
    });

    $("#btn-open-new-mv").click(function() {
        _mv_error_bag.hide();                
        $('.form-group').find('label.error').remove();
        _mvform.trigger("reset");
        _mvmodal.modal('show');
        _mvform.find("input[name=stock_id]").val(_stock_id);
        _mvform.find("input[name=from_id]").val(_branch_id);
        
    });
    
});

var mv_updateSuccess = function(data) {
    _mvform.trigger("reset");
    _mvform.find(".close").click();
    _mv_container.DataTable().ajax.reload();
}

var updateError = function(data) {
    var errors = $.parseJSON(data.responseText);
    _mv_errors.html('');
    $.each(errors.messages, function(key, value) {
        _mv_errors.append('<li>' + value + '</li>');
    });
    _mv_error_bag.show();
}

function init_dropdown(crud) {
    crud.ajaxcall("GET", "/branches/all", null, 
    function(data) {
        var branches = data.data;
        $("#branches").append("<option value=''>-- All --</option>"); 
        for(var i=0; i<branches.length; i++){
            $("#branches").append("<option value='"+branches[i].id+"'>"+branches[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });

    $('#branches').change(function(){
        var branch_id = $('#branches').val();   
        crud.fetch_data({branch_id : branch_id});
    });

    crud.ajaxcall("GET", "/products/all", null, 
    function(data) {
        var products = data.data;
        $("#product").append("<option value=''>-- Select --</option>"); 
        for(var i=0; i<products.length; i++){
            $("#product").append("<option value='"+products[i].id+"'>"+products[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });
    crud.ajaxcall("GET", "/branches/all", null, 
    function(data) {
        var branches = data.data;
        $("#branch").append("<option value=''>-- Select --</option>"); 
        for(var i=0; i<branches.length; i++){
            $("#branch").append("<option value='"+branches[i].id+"'>"+branches[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });
}



var init_mv = function(id) {
    if (_mv_container.length > 0) {
        _mv_datatable = _mv_container.DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            searching: false,
            ajax : "/stocks/"+id+"/movements",
            columns : [
                //{data: "id", name : "id"},
                {data: "created_at", name : "created_at"},
                {data: "from", name : "from"},
                {data: "movement_type_name", name : "movement_type_id", width:"50px"},
                {data: "quantity_before", name : "quantity_before"},
                {data: "quantity", name : "quantity"},
            ],
            order: [[ 0, "desc" ]],           
        });

    }

}