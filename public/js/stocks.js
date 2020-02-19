$(document).ready(function() {
    var crud = new Crud();
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
        }
    );
    init_dropdown(crud);
});

function init_dropdown(crud) {
    crud.ajaxcall("GET", "/v2/products/all", null, 
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
    crud.ajaxcall("GET", "/v2/branches/all", null, 
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
