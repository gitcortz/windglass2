var _customerDt;
var _customerContainer = $('#datatable-customer');
var _formOrderDetail = $("#form_orderDetail"); 
var _orderdetails;
var _customerdetail;
var _products;
var _orderdata;
$(document).ready(function() {
    
    //search_customer();
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
    $('#order-detail-update-location').click(function() {
        var branch_id = _formOrderDetail.find("select[name=branch]").val();
        
        if (branch_id != "") {
            ajaxcall("GET", "/branches/"+branch_id+"/products", null, 
                    function(data) {
                        //var products = data;
                        _products = data.filter(function (entry) {
                            return entry.product.producttype_id != 2;
                        });

                        $("#orderdetail_product").empty();
                        $("#orderdetail_product").append("<option value=''>-- Please select --</option>"); 
                        for(var i=0; i<_products.length; i++){
                            $("#orderdetail_product").append("<option value='"+_products[i].id+"'>"+_products[i].product.name+"</option>"); 
                        }
                        var tbody = $('#orderdetail_productTable tbody');
                        tbody.empty();
                        _orderdetails = [];
                        update_order_totals();
                    }, function(data) {
                        console.log(data);
                    });

            $('#order-section-2').show();
            $('#order-detail-footer').show();
        }        
     });
     $('#orderdetail_addproduct').click(function() {
        var product_id = _formOrderDetail.find("select[name=product_id]").val();
        var quantity = _formOrderDetail.find("input[name=quantity]").val();
        var tbody = $('#orderdetail_productTable tbody');

        var exists = _orderdetails.filter(function (entry) {
            return entry.stock_id == product_id;
        });

        if (exists.length > 0)
            return;

        var data = _products.filter(function (entry) {
            return entry.id == product_id;
        });
        
        if (data.length > 0) {
            var product = data[0];
            var discount = _customerdetail.discount ?  _customerdetail.discount :  0;
            var orderdetail ={
                stock_id : product_id,
                product : product.product.name,
                unit_price : parseFloat(product.product.unit_price),
                quantity: parseInt(quantity),
                discount :  parseFloat(discount),
                total : (quantity * product.product.unit_price) - discount,
            };
            
            var productRow = "<tr><td>"+orderdetail.product+"</td><td>" + orderdetail.quantity + "</td><td>" 
                        + orderdetail.unit_price.toFixed(2) + "</td><td>"+orderdetail.discount.toFixed(2)+"</td><td>"+orderdetail.total.toFixed(2)+"</td>"+
                        "<td><a href=\"#\" class=\"btn btn-danger btn-xs\" action=\"remove\" data-id=\""+orderdetail.product_id+"\">X</a></td></tr>";
        
            tbody.append(productRow);
            _orderdetails.push(orderdetail);
            update_order_totals();
        }
    });
    $('#orderdetail_productTable').on('click', 'tbody tr a[action="remove"]', function(event){
        var tr = $(this).closest('tr');        
        var product_id = tr.find('a[action="remove"]').data("id");
        jQuery(_orderdetails).each(function (index){
            if(_orderdetails[index].stock_id == product_id){
                _orderdetails.splice(index,1); // This will remove the object that first name equals to Test1
                return false; // This will stop the execution of jQuery each loop.
            }
        });
        update_order_totals();
        tr.remove();
    });
    $('#orderdetail_save').click(function() {
        save_order();
    });
    
    //$('#customer-detail-box').boxWidget('toggle')
    //$('#customer-detail-box').boxWidget('collapse')
    //$('#customer-detail-box').boxWidget('expand')
});

function init_dropdown() {
    ajaxcall("GET", "/cities/all", null, 
        function(data) {
            var cities = data.data;
            $("#customer_city").append("<option value=''>-- Please select --</option>"); 
            for(var i=0; i<cities.length; i++){
                $("#customer_city").append("<option value='"+cities[i].id+"'>"+cities[i].name+"</option>"); 
            }
        }, 
        function(e) {
            console.log(e);
        });
    ajaxcall("GET", "/branches/all", null, 
    function(data) {
        var branches = data.data;
        $("#orderdetail_branch").append("<option value=''>-- Please select --</option>"); 
        for(var i=0; i<branches.length; i++){
            $("#orderdetail_branch").append("<option value='"+branches[i].id+"'>"+branches[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });
    ajaxcall("GET", "/employees/riders", null, 
    function(data) {
        var riders = data.data;
        $("#orderdetail_rider").append("<option value=''>-- Please select --</option>"); 
        for(var i=0; i<riders.length; i++){
            $("#orderdetail_rider").append("<option value='"+riders[i].value+"'>"+riders[i].label+"</option>"); 
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
        $('#customer-detail-box').boxWidget('expand');
        $('#customer-search-box').boxWidget('collapse');
        $('#orderdetail_branch').val("");
    });
}

var load_customer = function(id, selectfunction) {
    ajaxcall("GET", "/customers/"+id, null, 
    function(data) {
        var data = data.data;
        _customerdetail = data;
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
        
        var tbody = $('#orderdetail_customerTable tbody');
        var customerRow = "<tr><td>"+data.name+"</td><td>" + data.address + "</td><td>" 
                        + data.phone + " / " + data.mobile + "</td><td>"+data.discount+"</td></tr>";
        tbody.empty();
        tbody.append(customerRow);    
        if (selectfunction)
            selectfunction();

    }, function(data) {
        console.log(data);
    });
}

var update_order_totals = function() {
    console.log('update_order_totals');
    var total_price = 0;
    var total_discount = 0;
    var total_amount = 0;
    jQuery(_orderdetails).each(function (index){
        total_price += parseFloat(_orderdetails[index].total);
        total_discount += parseFloat(_orderdetails[index].discount);
    });

    total_amount = total_price - total_discount;

    $('#orderdetail_totalprice').val(total_price.toFixed(2));
    $('#orderdetail_totaldiscount').val(total_discount.toFixed(2));
    $('#orderdetail_totalamount').val(total_amount.toFixed(2));

}


var select_customer = function(id) {
    load_customer(id, function() {
        $('#order-section-2').hide();
        $('#order-detail-footer').hide();
        $('#order-detail-box').boxWidget('expand');
    })
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
                //_customerDt.ajax.reload();
                load_customer(data_id);
            }, function() {});
    else
        ajaxcall("PUT", "/customers/"+data_id, form.serializeFormToObject(),
            function() { 
                //_customerDt.ajax.reload();
                load_customer(data_id);
            }, function() {});


}

var save_order = function() {
    //var datatable = _cart_datatables[_cart_prefix+_current_cart_index]
    //var form_data  = datatable.rows().data();  
    
    //if (form_data.length == 0)
    //    return; 

    var $customer = _customerdetail.id;
    var $subtotal = $('#orderdetail_totalprice').val(); 
    var $discount = $('#orderdetail_totaldiscount').val();
    var $branch_id = 1;
    var $payment_method_id = 10;
    var $order_status_id = $("#orderdetail_status").val();
    var $payment_status_id = 20; //Paid
    var $notes = "";

    _orderdata = {
        "id": 0,
        "customer_id": $customer,
        "branch_id": $branch_id,
        "sub_total": $subtotal,
        "discount": $discount,
        "payment_method_id": $payment_method_id,
        "order_status_id": $order_status_id,
        "payment_status_id": $payment_status_id,
        "notes": $notes,
        "items" : _orderdetails
    }
    console.log(_orderdata);

    ajaxcall("POST", "/orders", _orderdata, function() {
        //success
        //show_payment_complete_modal();
        alert('saved');
    }, function() {
        //error
    });
                    
}