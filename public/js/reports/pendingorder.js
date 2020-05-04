var pending = (function(){
    var dt_container = $("#pending_dataTable");
    var _updateModal = $('#modal-update');
    var _riders = [];
    var _cylinders = [];
    var _selected_empty_cylinders = [];

    var init_rider = function(rider_id) {
        if (_riders.length == 0) {
            ajaxcall("GET", "/employees/riders", null, 
            function(data) {
                _riders = data.data;
                $("#select_riders").append("<option value=''>-- Please select --</option>"); 
                for(var i=0; i<_riders.length; i++){
                    var selected = rider_id == _riders[i].value ? "selected" : "";
                    $("#select_riders").append("<option value='"+_riders[i].value+"' "+selected+">"+_riders[i].label+"</option>"); 
                }
            }, 
            function(e) {
                console.log(e);
            });
        }
        else {
            $("#select_riders").val(rider_id);
        }
    }

    var init_empty_cylinder = function() {
        if (_cylinders.length == 0) {            
            ajaxcall("GET", "/branches/1/emptycylinders", null, 
            function(data) {
                _cylinders = data;
                $("#select_empty_cylinder").append("<option value=''>-- Please select --</option>");
                $.each(_cylinders, function(i, item){
                    $("#select_empty_cylinder").append("<option value='"+item.id+"'>"+item.product.name+"</option>"); 
                });
            }, 
            function(e) {
                console.log(e);
            });
        }
    }

    var  format_order_detail_row = function(order) {

        var orderitems = '<h5>Order Items</h5><table border="1"><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th>';
        $.each(order.order_items, function(i, item){
            orderitems+='<tr><td>'+item.stock.product.name+'</td><td>'+item.quantity+'</td><td>'+(parseFloat(item.unit_price)).toFixed(2)+'</td>';
            orderitems+='<td>'+(item.quantity*item.unit_price).toFixed(2)+'</td></tr>';
        });
        orderitems += '</table>';
    
        var orderbringins = '<h5>Order Returns</h5><table border="1"><tr><th>Product</th><th>Qty</th>';
        $.each(order.order_bringins, function(i, item){
            orderbringins+='<tr><td>'+item.stock.product.name+'</td><td>'+item.quantity+'</td></tr>';
        });
        orderbringins += '</table>';
    
        var div = '<div class="row"><div class="col-md-6">'+orderitems+'</div><div class="col-md-6">'+orderbringins+'</div></div>';
        
           return div;
    }

    var addcylinder = function() {
        var emptycvalue = $('#select_empty_cylinder').val();
        var emptyctext = $( "#select_empty_cylinder option:selected" ).text();
        if (emptycvalue == "")
            return;
            
        var data = _selected_empty_cylinders.filter(function (e) {
            return e.id === emptycvalue;
        });

        if (data.length == 0){
            _selected_empty_cylinders.push({id: emptycvalue, quantity: 1});
            $('#bringin_list').append("<li id='empty_"+emptycvalue+"' data-id='"+emptycvalue+"'>"+emptyctext+" => "+1+"&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-danger btn-xs remove-empty'>-</a></i>");
        }
        else {
            data[0].quantity = parseInt(data[0].quantity)+1; 
            $('#empty_'+ emptycvalue).html(emptyctext+" => "+data[0].quantity+"&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-danger btn-xs remove-empty'>-</a>");
        }
    
        $('.remove-empty').click('on', function() {
            var objname = $(this).parent().attr("id");
            var id = $(this).parent().data("id");

            var data = _selected_empty_cylinders.filter(function (e) {
                return e.id === id.toString();
            });
            
            if (data.length > 0) {

                for(var i = 0; i < _selected_empty_cylinders.length; i++) {
                    if(_selected_empty_cylinders[i].id == id) {
                        _selected_empty_cylinders.splice(i, 1);
                        break;
                    }
                }
                $("#"+ objname).remove();
                
            }
        })
    }

    var update_order_status = function(id, value, rider = "", payment_status_id, cylinders = "", success) {
   
        var data1 = JSON.stringify(
                {"order_status_id": value, 
                "rider_id": rider, 
                "payment_status_id": payment_status_id, 
                "cylinders" :  cylinders});
        
        console.log("data");
        console.log(data1);
       
        ajaxcall("PUT", "/orders/"+id, data1, 
            function(data){
                if (success)
                    success();
                _updateModal.modal('hide');
            }, function(data){
                console.log(data);   
        });
    }
    
    var update_order = function() {
        var id = $('#order_update_id').val();
        var status_id = $('#order_update_status_id').val();
        var rider = $('#select_riders').val();
        var payment_status_id = $('#payment_status_id').val();

        if (rider != "")
            update_order_status(id, status_id, rider, payment_status_id, _selected_empty_cylinders);
        else {
            $('#order_update_text').html("please select a rider");
        }
    
    }

    var init_cylinder_bringin = function(bring_ins) {
        _selected_empty_cylinders = [];
        $('#bringin_list').empty();
        console.log(bring_ins);
        for(i=0; i<bring_ins.length; i++){
            var emptycvalue = bring_ins[i].stock_id;
            var emptyctext = bring_ins[i].stock.product.name;
            _selected_empty_cylinders.push({id: emptycvalue, quantity: bring_ins[i].quantity});
            $('#bringin_list').append("<li id='empty_"+emptycvalue+"' data-id='"+emptycvalue+"'>"+emptyctext+" => "+bring_ins[i].quantity+"&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-danger btn-xs remove-empty'>-</a></i>");
        }
    
        $('.remove-empty').click('on', function() {
            var objname = $(this).parent().attr("id");
            var id = $(this).parent().data("id");

            var data = _selected_empty_cylinders.filter(function (e) {
                return e.id === id.toString();
            });
            
            if (data.length > 0) {

                for(var i = 0; i < _selected_empty_cylinders.length; i++) {
                    if(_selected_empty_cylinders[i].id == id) {
                        _selected_empty_cylinders.splice(i, 1);
                        break;
                    }
                }
                $("#"+ objname).remove();
                
            }
        })
    }

    var load_update_order_modal = function(orderid, status) {
        _selected_empty_cylinders = [];
        $('#bringin_list').empty();

        var data = dt_container.DataTable().rows().data();
        var order = data.filter(function (entry) {
            return entry.id == orderid;
        });
        
        var rider_id = order[0].rider_id;
        var bring_ins = order[0].order_bringins;
        var payment_status_id = order[0].payment_status_id;

        init_rider(rider_id);
        init_empty_cylinder();
        init_cylinder_bringin(bring_ins);
        $('#order_update_id').val(orderid);
        $("#payment_status_id").val(payment_status_id);
        $('#order_update_status_id').val(status);
        
        _updateModal.modal('show');
    }

    var init_pending_table = function() {
        if (dt_container.length > 0) {
            dt_container.DataTable().destroy();
            pending_dt = dt_container.DataTable({
                processing: true,
                serverSide: true,
                ajax : "/reports/"+window.branchId+"/pendingorderreport/",
                columns :  [
                    {data: "id", name : "id", "width": "20px",},
                    {data: "order_date", name : "order_date"},
                    {data: "customername", name : "customers.name"},
                    {data: "sub_total", name : "sub_total"},
                    {data: "rider", name : "rider"},
                    {data: "order_status", name : "order_status"},
                    {data: "payment_status", name : "payment_status"},
                    {data: "action_btns", name : "action_btns"},
                ],
                order: [[ 0, "desc" ]],           
                drawCallback: function( settings, json) {
                    $('.order_action').on('change', function() {
                        if (window.confirm("Are you sure you want to update the status?")) { 
                            var selected = $(this).find(":selected").val(); 
                            if (selected == "40" || selected == "30"){
                                load_update_order_modal($(this).data("id"), $(this).find(":selected").val());
                                return;
                            }
                            update_order_status($(this).data("id"), $(this).find(":selected").val());
                        }
                        this.value=this.getAttribute('prev');
                    });
                }
            });
    
            // Array to track the ids of the details displayed rows
            var detailRows = [];
        
            $("#pending_dataTable tbody").on( 'click', 'tr td', function () {
                var tr = $(this).closest('tr');
                var row = pending_dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );
                var td = $(this).closest('td');
                if (td.html().indexOf('<select') > -1)
                    return;
                if (row.data() == undefined)
                    return;
    
                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();
        
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    row.child( format_order_detail_row( row.data() ) ).show();
        
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                }
            } );
        
            // On each draw, loop over the `detailRows` array and show any child rows
            pending_dt.on( 'draw', function () {
                $.each( detailRows, function ( i, id ) {
                    $('#'+id+' td.details-control').trigger( 'click' );
                } );
            });
    
            
        }
    }

    

    var init = function(){
        init_pending_table();        
        
        $('#btn-add-empty_cylinder').on('click', function() {
            addcylinder();
        })
    
        $('#btn-update-order').click(function() {        
            update_order();
        });

        _updateModal.on('hidden.bs.modal', function () {
            dt_container.DataTable().ajax.reload();
        })
    

    }

    var public = {
        init : init,
        update_modal: load_update_order_modal
    }

    return public;
})();



$(document).ready(function() {
    pending.init();
});

var _datatable_container = $('#dataTable');

function fetch_data() {
    if (_datatable_container.length > 0) {
        _datatable = _datatable_container.DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            ajax : {
                url: "/"+_component+"/dailysalesreport",
                "data": function(d){
                    d.date = $("#start_date").val();
                 }
            },
            data : { date: $('#start_date').val() },
            columns : [
                {data: "order_date", name : "order_date"},
                {data: "id", name : "id"},
                {data: "customer_name", name : "customer_name"},
                {data: "product_name", name : "product_name"},
                {data: "quantity", name : "quantity"},
                {data: "unit_price", name : "unit_price", render: $.fn.dataTable.render.number( ',', '.', 2 )},
                {data: "discount", name : "discount", render: $.fn.dataTable.render.number( ',', '.', 2 )},
                {data: "total", name : "total", render: $.fn.dataTable.render.number( ',', '.', 2 )},
                {data: "rider", name : "rider"},
                {data: "payment_status", name : "payment_status"},
            ],
            order: [[ 0, "desc" ]],           
        });
    }
}

function init() {
    var d = new Date();
    var dateStr = d.getFullYear() + "-" + ( d.getMonth()+1) + "-" + d.getDate();

    $('#start_date').val(dateStr);
    
    $('.input-daterange').datepicker({        
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        todayHighlight: true,  
    });

    $('#btn-pdf').click(function() {
        window.open("/"+_component+"/dailysalesreport/pdf?date="+ $('#start_date').val());
    });
    
    $('#search').click(function(){
        var start_date = $('#start_date').val();
        //var end_date = $('#end_date').val();
         
        _datatable_container.DataTable().destroy();
        fetch_data('yes', start_date);
        
    }); 
}


var init_sales_table = function() { 
    
}