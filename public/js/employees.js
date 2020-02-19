$(document).ready(function() {
    var crud = new Crud();
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "first_name", name : "first_name"},
            {data: "last_name", name : "last_name"},
            {data: "mobile", name : "mobile"},
            {data: "employeetype", name : "employeetype"},
            {data: "hire_date", name : "hire_date"},
            {data: "action_btns", name : "action_btns"},
        ], function(data) {
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=first_name]").val(data.first_name);
            form.find("input[name=last_name]").val(data.last_name);
            form.find("input[name=address]").val(data.address);
            form.find("input[name=city]").val(data.city);
            form.find("input[name=notes]").val(data.notes);
            form.find("input[name=mobile]").val(data.mobile);
            form.find("input[name=phone]").val(data.phone);
            form.find("input[name=base_salary]").val(data.base_salary);
            form.find("input[name=biometrics_id]").val(data.biometrics_id);
            form.find("input[name=hire_date]").val(data.hire_date);
            form.find("#employeetype").val(data.employeetype_id);
        }
    );
    init_dropdown(crud);
});

function init_dropdown(crud) {
    crud.ajaxcall("GET", "/v2/cities/all", null, 
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
    crud.ajaxcall("GET", "/v2/employeetypes/all", null, 
    function(data) {
        var types = data.data;
        $("#employeetype").append("<option value=''>-- Please select --</option>"); 
        for(var i=0; i<types.length; i++){
            $("#employeetype").append("<option value='"+types[i].id+"'>"+types[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });
}
