$(document).ready(function() {
    var crud = new Crud();
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "name", name : "name"},
            {data: "brand", name : "brand"},
            {data: "producttype", name : "producttype"},
            {data: "unit_price", name : "unit_price"},
            {data: "action_btns", name : "action_btns"},
        ], function(data) {
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=name]").val(data.name);
            form.find("input[name=description]").val(data.description);
            form.find("input[name=unit_price]").val(data.unit_price);
            form.find("#brand").val(data.brand_id);
            form.find("#producttype").val(data.producttype_id);
        }
    );
    init_dropdown(crud);
});

function init_dropdown(crud) {
    crud.ajaxcall("GET", "/v2/producttypes/all", null, 
    function(data) {
        var producttypes = data.data;
        $("#producttype").append("<option value=''>-- None --</option>"); 
        for(var i=0; i<producttypes.length; i++){
            $("#producttype").append("<option value='"+producttypes[i].id+"'>"+producttypes[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });
    crud.ajaxcall("GET", "/v2/brands/all", null, 
    function(data) {
        var brands = data.data;
        $("#brand").append("<option value=''>-- None --</option>"); 
        for(var i=0; i<brands.length; i++){
            $("#brand").append("<option value='"+brands[i].id+"'>"+brands[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });
}
