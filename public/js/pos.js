var _customerDt;
var _customerContainer = $('#datatable-customer');
var _formOrderDetail = $("#form_orderDetail"); 
var _orderDt;
var _orderContainer = $('#order_dataTable');
var _orderdetails;
var _customerdetail;
var _products;
var _orderdata;
var _branch_id;

$(document).ready(function() {
    
    //search_customer();
    init_dropdown();
    initialize_select_status(10);
    _branch_id = $('#default_branch').val();
    
    $('#pos_customer_btnsearch').click(function() {
        search_customer();
    });
    $('#pos_order_btnsearch').click(function() {
        search_order();
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
    $('#btn-reset-order').click(function() {
        reset_order();
    });
    $('#orderdetail_print').click(function() {
        print_order();
    });
    $('#order-detail-update-location').click(function() {
        var branch_id = _formOrderDetail.find("select[name=branch_id]").val();
        console.log(branch_id);
        if (branch_id != "") {
            select_branch(branch_id, function() {
                var tbody = $('#orderdetail_productTable tbody');
                tbody.empty();
                _orderdetails = [];
                update_order_totals();
            });
        }        
     });
     $('#orderdetail_addproduct').click(function() {
        var product_id = _formOrderDetail.find("select[name=product_id]").val();
        var quantity = _formOrderDetail.find("input[name=quantity]").val();
        var tbody = $('#orderdetail_productTable tbody');

        var exists = _orderdetails.filter(function (entry) {
            return entry.stock_id == product_id;
        });

        if (exists.length > 0) {
            //remove if exists
            var a = $("#orderdetail_productTable").find("[data-id='"+exists[0].stock_id+"']");  
            var tr = a.closest('tr');
            jQuery(_orderdetails).each(function (index){
                if(_orderdetails[index].stock_id == exists[0].stock_id){
                    _orderdetails.splice(index,1); // This will remove the object that first name equals to Test1
                    return false; // This will stop the execution of jQuery each loop.
                }
            });
            tr.remove();          
        }

        var data = _products.filter(function (entry) {
            return entry.id == product_id;
        });
        
        if (data.length > 0) {
            var product = data[0];
            var isCylinder = (product.product.producttype_id==1);
            var discount = _customerdetail.discount && isCylinder ?  _customerdetail.discount :  0;
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
                        "<td><a href=\"#\" class=\"btn btn-danger btn-xs product_remove\" action=\"remove\" data-id=\""+orderdetail.stock_id+"\">X</a></td></tr>";
        
            tbody.append(productRow);
            _orderdetails.push(orderdetail);
            update_order_totals();
            
        }
    });
    $('#orderdetail_productTable').on('click', 'tbody tr a[action="remove"]', function(event){
        var tr = $(this).closest('tr');        
        var product_id = tr.find('a[action="remove"]').data("id");
        
        jQuery(_orderdetails).each(function (index){
            console.log(_orderdetails[index].stock_id + ' = ' + product_id);
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

function select_branch(branch_id, func) {
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
                $('#order-section-2').show();
                $('#order-detail-footer').show();

                if (func)
                    func();                
            }, function(data) {
                console.log(data);
            });
}

var search_customer = function() {
    keyword = $('#customer_search').val().trim();
    _customerContainer.parent().show();

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
        select_branch(_branch_id, function() {
            var tbody = $('#orderdetail_productTable tbody');
            tbody.empty();
            _orderdetails = [];
            update_order_totals();
        });
        $('#customer-search-box').boxWidget('collapse');
        $('#orderdetail_branch').val("");
    });
}

var search_order = function() {
    keyword = $('#order_search').val().trim();
    _customerContainer.parent().hide();
    display_order_table( {order_id : keyword});
}


var load_customer = function(id, func) {
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
        
        var tbody = $('#orderdetail_customerTable tbody');
        var customerRow = "<tr><td>"+data.name+"</td><td>" + data.address + "</td><td>" 
                        + data.phone + " / " + data.mobile + "</td><td>"+data.discount+"</td></tr>";
        tbody.empty();
        tbody.append(customerRow);    
        if (func)
            func();

    }, function(data) {
        console.log(data);
    });
}

var open_order_details = function() {
  
   $('#order-detail-box').boxWidget('expand');
  
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
        display_order_table({customer_id : _customerdetail.id});
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
    var $branch_id = $('#orderdetail_branch_id').val();
    var $rider_id =  $('select[name="rider_id"').val();
    var $payment_method_id = 10;
    var $order_status_id = $("#orderdetail_status").val();
    var $payment_status_id = 20; //Paid
    var $notes = "";
    var $id = $("#orderdetail_id").val() == "" ? 0 :  $("#orderdetail_id").val();
    if ($id == 0)
        $branch_id = _branch_id;
    
    console.log($branch_id);

    _orderdata = {
        "id": $id,
        "customer_id": $customer,
        "branch_id": $branch_id,
        "sub_total": $subtotal,
        "discount": $discount,
        "payment_method_id": $payment_method_id,
        "order_status_id": $order_status_id,
        "payment_status_id": $payment_status_id,
        "rider_id" : $rider_id,
        "notes": $notes,
        "items" : _orderdetails
    }
    console.log(_orderdata);

    
    ajaxcall("POST", "/orders", _orderdata, function(d) {
        //success
        //show_payment_complete_modal();
        initialize_select_status($order_status_id);
        initialize_product_section($order_status_id);
        $('#order_detail_id_label').html(d.data.id);
        
        alert('saved ' + d.data.id);
        _orderDt.ajax.reload();
    }, function() {
        //error
    });
    
}

var load_order_item = function(order_items) {
    var tbody = $('#orderdetail_productTable tbody');
    tbody.empty();
    _orderdetails = [];

    order_items.forEach(function(item) {
        var product = item.stock;
        var discount = item.discount == null ? 0 : item.discount;
        var orderdetail ={
            stock_id : item.stock_id,
            product : product.product.name,
            unit_price : parseFloat(item.unit_price),
            quantity: parseInt(item.quantity),
            discount :  parseFloat(discount),
            total : (item.quantity * item.unit_price) - discount,
        };
        
        var productRow = "<tr><td>"+orderdetail.product+"</td><td>" + orderdetail.quantity + "</td><td>" 
                    + orderdetail.unit_price.toFixed(2) + "</td><td>"+orderdetail.discount.toFixed(2)+"</td><td>"+orderdetail.total.toFixed(2)+"</td>"+
                    "<td><a href=\"#\" class=\"btn btn-danger btn-xs product_remove\" action=\"remove\" data-id=\""+orderdetail.stock_id+"\">X</a></td></tr>";
    
        $('#orderdetail_productTable tbody').append(productRow);
        _orderdetails.push(orderdetail);

    });
    
    var $order_status_id = $("#orderdetail_status").val();
    update_order_totals();
}

var display_order_table = function(searchdata) { 
    if (_orderContainer.length > 0) {
        _orderDt = _orderContainer.DataTable().destroy();
        _orderDt = _orderContainer.DataTable({
            processing: true,
            serverSide: true,
            searching: false,
           ajax :  {
                url: "/pos/list/",
                data : searchdata
            },
            columns :  [
                {data: "id", name : "id"},
                {data: "order_date", name : "order_date"},
                {data: "customername", name : "customers.name"},
                {data: "order_status", name : "order_status"},
                {data: "total", name : "total", className: 'dt-body-right', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                {data: "action_btns", name : "action_btns"},
            ],
            order: [[ 0, "desc" ]],           
            drawCallback: function( settings, json) {
                $('.order_action').on('change', function() {
                    if (window.confirm("Are you sure you want to update the status?")) { 
                        if ($(this).find(":selected").val() == "40"){
                            init_rider();
                            init_empty_cylinder();
                            $('#order_update_id').val($(this).data("id"));
                            $('#order_update_status_id').val($(this).find(":selected").val());
                            _updateModal.modal('show');
                            return;
                        }
                        update_order_status($(this).data("id"), $(this).find(":selected").val());
                    }
                });
            },
        });

        _orderContainer.off('click');
        _orderContainer.on('click', 'tbody tr a[action="view"]', function(event){
            var data = _orderDt.row($(this).parents('tr')).data();
            if (!_customerdetail || data.customer_id != _customerdetail.id)
                load_customer(data.customer_id);
            load_order(data);
            open_order_details();

        });

    }
}

var load_order = function(data) {   
    initialize_select_status(data.order_status_id);
    _formOrderDetail.find('input[name="orderdetail_id"]').val(data.id);
    _formOrderDetail.find('input[name="order_status_id"]').val(data.order_status_id);
    _formOrderDetail.find('input[name="orderdetail_branch_id"]').val(data.branch_id);
    _formOrderDetail.find('select[name="rider_id"]').val(data.rider_id);
    $('#order-detail-update-location').hide();
    $('#orderdetail_branch').prop("disabled", true);
    $('#order_detail_id_label').html(data.id);
    $('#order_detail_date_label').html(data.order_date);
    select_branch(data.branch_id);
   load_order_item(data.order_items);
   initialize_product_section(data.order_status_id);
   console.log(data);
   //alert( data[0] +"'s salary is: "+ data[ 5 ] );
}

var reset_order = function() {
    console.log('reset_order');
    initialize_select_status(10);
    initialize_product_section(10);
    $('#customer-search-box').boxWidget('collapse');
    $('#orderdetail_branch').val("");
    $('#orderdetail_status').val("10");
    $('#orderdetail_id').val("");
    $('#orderdetail_rider').val("");
    $('#orderdetail_product').val("");
    $('#orderdetail_qty').val("1");
    $('#order_detail_id_label').html("new");
    $('#order_detail_date_label').html(formatDate(new Date()));
    $('#order-detail-update-location').show();
    $('#orderdetail_branch').prop("disabled", false);
    var tbody = $('#orderdetail_productTable tbody');
    tbody.empty();
    _orderdetails = [];
    update_order_totals();
    //$('#order-section-2').hide();
    //$('#order-detail-footer').hide();
}

var print_order = function() {
    if (confirm("Generate Receipt?")) {
        window.open("/pos/receipt/" + $('#order_detail_id_label').html());
    }
}

var initialize_product_section = function(status) {
    status = parseInt(status);
    var add_product_section = $('#add_product_section');
    var product_remove = $('.product_remove');
 
    if (status <= 10) {
        add_product_section.show();
        product_remove.show();
    }
    else {
        add_product_section.hide();
        product_remove.hide();
    }
    
}
var initialize_select_status = function(status) {
     
    status = parseInt(status);
    var select_status = $('#orderdetail_status');
    select_status.empty();
    if (status <= 10) {
        select_status.append($('<option>', { value: 10, text: 'DRAFT'}));        
    }
    if (status <= 20) {
        select_status.append($('<option>', { value: 20, text: 'ORDERED'}));                        
    }
    if (status <= 30) {
        select_status.append($('<option>', { value: 30, text: 'DELIVERED'}));
    }
    if (status <= 40) {
        select_status.append($('<option>', { value: 40, text: 'COMPLETED'}));
    }
    if (window.isAdmin && status >= 20){
        select_status.append($('<option>', { value: 0, text: 'CANCELLED'}));
    }

}

var formatDate = function(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [month, day, year].join('-');
}