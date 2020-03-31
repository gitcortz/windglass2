var _customerDt;
var _customerContainer = $('#datatable-customer');
$(document).ready(function() {
    
    search_customer();
    init_dropdown();

    $('#pos_customer_btnsearch').click(function() {
        search_customer();
    });
    $('#customer_search').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            search_customer();
        }        
    });
    $('#customer_btnsave').click(function() {
        save_customer();
    });
    //$('#customer-detail-box').boxWidget('toggle')
    //$('#customer-detail-box').boxWidget('collapse')
    //$('#customer-detail-box').boxWidget('expand')
});

function init_dropdown() {
    ajaxcall("GET", "/cities/all", null, 
        function(data) {
            var cities = data.data;
            $("#pos_customer_city").append("<option value=''>-- Please select --</option>"); 
            for(var i=0; i<cities.length; i++){
                $("#pos_customer_city").append("<option value='"+cities[i].id+"'>"+cities[i].name+"</option>"); 
            }
        }, 
        function(e) {
            console.log(e);
        });
}

var search_customer = function() {
    keyword = $('#customer_search').val().trim();
    _customerContainer.DataTable().destroy();       
    _customerDt = _customerContainer.DataTable({
        processing: true,
        serverSide: true,
        ajax :  {
            url: "/customers/search",
            data : { keyword : keyword }               
        },
        columns : [
            {data: "name", name : "name"},
            {data: "address", name : "address"},
            {data: "city", name : "city"},
            {data: "contact", name : "contact"},
            {data: "action_btns", name : "action_btns"},
        ],
        order: [[ 0, "desc" ]],    
        dom: '<"top">rt<"bottom"lip><"clear">'       
    });
    _customerContainer.off('click'); 
    _customerContainer.on('click', 'tbody tr a[action="select"]', function(event){
        select_customer($(this).data("id"));
    });
}

var select_customer = function(id) {
    ajaxcall("GET", "/customers/"+id, null, 
        function(data) {
            var data = data.data;
            var form = $("#form_customerDetail");
            form.find("input[name=id]").val(data.id);
            form.find("input[name=name]").val(data.name);
            form.find("input[name=address]").val(data.address);
            form.find("input[name=city]").val(data.city);
            form.find("input[name=notes]").val(data.notes);
            form.find("input[name=mobile]").val(data.mobile);
            form.find("input[name=phone]").val(data.phone);
            form.find("input[name=discount]").val(data.discount);
            form.find("#city").val(data.city_id);
            $('#customer-detail-box').boxWidget('expand');
        }, function(data) {
            console.log(data);
        });
}

var save_customer = function() {
    var form = $('#form_customerDetail');
    var data_id = $('#customer_id').val();
    if (!form.valid()) {
        return;
    }

    var data = form.serializeFormToObject();
    if (data.id == "")
        ajaxcall("POST", "/customers", form.serializeFormToObject(), 
            function() { 
                _customerDt.ajax.reload();
            }, function() {});
    else
        ajaxcall("PUT", "/customers/"+data_id, form.serializeFormToObject(),
            function() { 
                _customerDt.ajax.reload();
            }, function() {});


}