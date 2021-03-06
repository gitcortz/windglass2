$(document).ready(function() {
    var crud = new Crud();
    crud.init(_component, 
        [
            {data: "city", name : "city"},
            {data: "code", name : "code"},
            {data: "name", name : "name"},
            {data: "address", name : "address"},            
            {data: "phone", name : "phone"},
            {data: "mobile", name : "mobile"},
            {data: "action_btns", name : "action_btns"},
        ], function(data) {
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=code]").val(data.code);
            form.find("input[name=name]").val(data.name);
            form.find("input[name=address]").val(data.address);
            form.find("input[name=city]").val(data.city);
            form.find("input[name=mobile]").val(data.mobile);
            form.find("input[name=phone]").val(data.phone);
            form.find("#city").val(data.city_id);
        }
    );
    init_dropdown(crud);
});

function init_dropdown(crud) {
    crud.ajaxcall("GET", "/cities/all", null, 
    function(data) {
        var cities = data.data;
        $("#city").append("<option value=''>-- Please select --</option>"); 
        for(var i=0; i<cities.length; i++){
            $("#city").append("<option value='"+cities[i].id+"'>"+cities[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });
}
